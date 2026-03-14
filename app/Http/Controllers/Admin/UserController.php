<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        $search = request('search');

        $users = User::when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('role', 'like', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => 'required|in:head_admin,admin,professeur,etudiant',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'force_password_change' => true,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $isSelf = Auth::id() === $user->id;
        $isHeadAdmin = auth()->user()->role === 'head_admin';

        $rules = [
            'password' => ['required', 'confirmed', Password::defaults()],
        ];

        if ($isSelf) {
            $rules['current_password'] = ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('The current password is incorrect.');
                }
            }];
        }

        if ($isHeadAdmin && $request->has('role')) {
            $rules['role'] = 'required|in:head_admin,admin,professeur,etudiant';
        }

        $request->validate($rules);

        $updateData = [
            'password' => Hash::make($request->password),
        ];

        if ($isHeadAdmin && $request->has('role')) {
            $updateData['role'] = $request->role;
        }

        if ($isHeadAdmin) {
            // Un head_admin ne peut pas se désactiver lui-même
            if ($isSelf) {
                $updateData['actif'] = true;
            } else {
                $updateData['actif'] = $request->has('actif');
            }
        }

        $user->update($updateData);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if (Auth::id() === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot delete your own account.');
        }

        if (auth()->user()->role !== 'head_admin' && $user->role === 'head_admin') {
            return redirect()->route('admin.users.index')->with('error', 'You cannot delete a head admin.');
        }

        if (auth()->user()->role !== 'head_admin' && $user->role === 'admin') {
            return redirect()->route('admin.users.index')->with('error', 'You cannot delete another admin.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
