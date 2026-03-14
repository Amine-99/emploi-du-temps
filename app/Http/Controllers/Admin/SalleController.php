<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Salle;
use App\Http\Requests\SalleRequest;

class SalleController extends Controller
{
    public function index()
    {
        $salles = Salle::orderByRaw('LENGTH(numero)')->orderBy('numero')
            ->paginate(10);

        return view('admin.salles.index', compact('salles'));
    }

    public function create()
    {
        $types = Salle::TYPES;
        return view('admin.salles.create', compact('types'));
    }

    public function store(SalleRequest $request)
    {
        Salle::create($request->validated());

        return redirect()->route('admin.salles.index')
            ->with('success', 'Salle créée avec succès');
    }

    public function show(Salle $salle)
    {
        return view('admin.salles.show', compact('salle'));
    }

    public function edit(Salle $salle)
    {
        $types = Salle::TYPES;
        return view('admin.salles.edit', compact('salle', 'types'));
    }

    public function update(SalleRequest $request, Salle $salle)
    {
        $salle->fill($request->validated());
        $salle->disponible = $request->has('disponible');
        $salle->save();

        return redirect()->route('admin.salles.index')
            ->with('success', 'Salle modifiée avec succès');
    }

    public function destroy(Salle $salle)
    {
        $salle->delete();

        return redirect()->route('admin.salles.index')
            ->with('success', 'Salle supprimée avec succès');
    }

    public function toggle(Salle $salle)
    {
        $newStatus = $salle->disponible ? 0 : 1;
        
        \DB::table('salles')->where('id', $salle->id)->update([
            'disponible' => $newStatus
        ]);
        
        return back()->with('success', 'Statut de la salle ' . $salle->numero . ' mis à jour.');
    }
}
