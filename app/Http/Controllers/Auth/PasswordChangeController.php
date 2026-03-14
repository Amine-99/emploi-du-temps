<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordChangeController extends Controller
{
    public function showChangeForm()
    {
        // Si l'utilisateur n'a pas besoin de changer son mot de passe, on le redirige
        if (!auth()->user()->force_password_change) {
            return redirect($this->getRedirectRoute());
        }

        return view('auth.force-password-change');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = auth()->user();

        // On s'assure que le nouveau mot de passe n'est pas le même que l'ancien
        if (Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Le nouveau mot de passe doit être différent de l\'ancien.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'force_password_change' => false, // On lève le blocage
        ]);

        return redirect($this->getRedirectRoute())->with('success', 'Votre mot de passe a été mis à jour avec succès. Bienvenue !');
    }

    private function getRedirectRoute()
    {
        $user = auth()->user();
        
        switch ($user->role) {
            case 'admin':
            case 'head_admin':
                return route('admin.dashboard');
            case 'professeur':
                return route('professeur.dashboard');
            case 'etudiant':
                return route('etudiant.dashboard');
            default:
                return '/';
        }
    }
}
