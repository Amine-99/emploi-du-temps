<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Filiere;
use App\Models\Groupe;
use App\Models\Professeur;
use App\Models\Etudiant;
use App\Models\Module;
use App\Models\Salle;
use App\Models\EmploiDuTemps;
use App\Models\Attendance;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'filieres' => Filiere::count(),
            'groupes' => Groupe::count(),
            'professeurs' => Professeur::where('actif', true)->count(),
            'etudiants' => Etudiant::where('actif', true)->count(),
            'modules' => Module::count(),
            'salles' => Salle::where('disponible', true)->count(),
            'seances' => EmploiDuTemps::where('actif', true)->count(),
            'absences' => Attendance::where('status', 'Absent')->count(),
        ];

        $dernieresSeances = EmploiDuTemps::with(['professeur', 'groupe', 'module', 'salle'])
            ->latest()
            ->take(5)
            ->get();

        $demandesAnnulation = EmploiDuTemps::with(['professeur', 'groupe', 'module'])
            ->where('statut_approbation', 'pending')
            ->get();

        return view('admin.dashboard', compact('stats', 'dernieresSeances', 'demandesAnnulation'));
    }
}
