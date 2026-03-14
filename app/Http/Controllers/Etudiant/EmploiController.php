<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\EmploiDuTemps;
use App\Models\Etudiant;

class EmploiController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $etudiant = Etudiant::with('groupe.filiere')->where('user_id', $user->id)->first();

        $emplois = collect();
        $groupe = null;

        if ($etudiant && $etudiant->groupe) {
            $groupe = $etudiant->groupe;
            $emplois = EmploiDuTemps::with(['professeur', 'module', 'salle'])
                ->where('groupe_id', $etudiant->groupe_id)
                ->where('actif', true)
                ->get()
                ->groupBy('jour');
        }

        $jours = EmploiDuTemps::JOURS;
        
        $creneaux = EmploiDuTemps::getCreneaux('Lundi');

        return view('etudiant.emploi', compact('etudiant', 'groupe', 'emplois', 'jours', 'creneaux'));
    }
}
