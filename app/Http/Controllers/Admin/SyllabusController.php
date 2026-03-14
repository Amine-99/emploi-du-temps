<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\SyllabusItem;
use Illuminate\Http\Request;

class SyllabusController extends Controller
{
    public function index(Module $module)
    {
        $items = $module->syllabusItems;
        return view('admin.modules.syllabus', compact('module', 'items'));
    }

    public function store(Request $request, Module $module)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'poids_pourcentage' => 'required|integer|min:0|max:100',
            'ordre' => 'nullable|integer'
        ]);

        $module->syllabusItems()->create($request->all());

        return back()->with('success', 'Chapitre ajouté au syllabus.');
    }

    public function update(Request $request, SyllabusItem $item)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'poids_pourcentage' => 'required|integer|min:0|max:100',
            'ordre' => 'nullable|integer'
        ]);

        $item->update($request->all());

        return back()->with('success', 'Chapitre mis à jour.');
    }

    public function destroy(SyllabusItem $item)
    {
        $item->delete();
        return back()->with('success', 'Chapitre supprimé du syllabus.');
    }
}
