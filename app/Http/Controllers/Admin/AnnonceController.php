<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use Illuminate\Http\Request;

class AnnonceController extends Controller
{
    public function index()
    {
        $annonces = Annonce::with('user')->latest()->paginate(15);
        return view('admin.annonces.index', compact('annonces'));
    }

    public function create()
    {
        return view('admin.annonces.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
        ]);

        Annonce::create([
            'titre' => $request->titre,
            'contenu' => $request->contenu,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.annonces.index')
            ->with('success', 'Annonce créée avec succès.');
    }

    public function destroy(Annonce $annonce)
    {
        $annonce->delete();
        return redirect()->route('admin.annonces.index')
            ->with('success', 'Annonce supprimée avec succès.');
    }
}
