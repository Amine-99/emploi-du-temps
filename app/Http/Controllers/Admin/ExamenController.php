<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Examen;
use App\Models\Module;
use App\Models\Groupe;
use App\Models\Salle;
use Illuminate\Http\Request;

class ExamenController extends Controller
{
    public function index()
    {
        $examens = Examen::with(['module', 'groupe', 'salle'])->orderBy('date', 'desc')->get();
        return view('admin.examens.index', compact('examens'));
    }

    public function create()
    {
        $modules = Module::all();
        $groupes = Groupe::where('actif', true)->get();
        $salles = Salle::orderByRaw('LENGTH(numero)')->orderBy('numero')->get();
        $types = ['EFM Régional', 'EFM Local', 'EFF'];
        
        return view('admin.examens.create', compact('modules', 'groupes', 'salles', 'types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'module_id' => 'required|exists:modules,id',
            'groupe_id' => 'required|exists:groupes,id',
            'salle_id' => 'nullable|exists:salles,id',
            'date' => 'required|date',
            'heure_debut' => 'required',
            'heure_fin' => 'required',
            'type' => 'required|string',
            'coefficient' => 'required|numeric|min:1',
        ]);

        Examen::create($request->all());

        return redirect()->route('admin.examens.index')->with('success', 'Examen créé avec succès.');
    }

    public function edit(Examen $examen)
    {
        $modules = Module::all();
        $groupes = Groupe::where('actif', true)->get();
        $salles = Salle::orderByRaw('LENGTH(numero)')->orderBy('numero')->get();
        $types = ['EFM Régional', 'EFM Local', 'EFF'];

        return view('admin.examens.edit', compact('examen', 'modules', 'groupes', 'salles', 'types'));
    }

    public function update(Request $request, Examen $examen)
    {
        $request->validate([
            'module_id' => 'required|exists:modules,id',
            'groupe_id' => 'required|exists:groupes,id',
            'salle_id' => 'nullable|exists:salles,id',
            'date' => 'required|date',
            'heure_debut' => 'required',
            'heure_fin' => 'required',
            'type' => 'required|string',
            'coefficient' => 'required|numeric|min:1',
        ]);

        $examen->update($request->all());

        return redirect()->route('admin.examens.index')->with('success', 'Examen mis à jour avec succès.');
    }

    public function destroy(Examen $examen)
    {
        $examen->delete();
        return redirect()->route('admin.examens.index')->with('success', 'Examen supprimé avec succès.');
    }
}
