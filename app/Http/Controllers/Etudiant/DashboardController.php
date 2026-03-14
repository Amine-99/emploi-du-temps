<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Etudiant;
use App\Models\EmploiDuTemps;
use App\Models\Annonce;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $etudiant = Etudiant::where('user_id', $user->id)->first();
        
        $notifications = $user->unreadNotifications;

        $annonces = Annonce::where('active', true)->latest()->get();

        $seancesAujourdhui = collect();
        if ($etudiant) {
            $jourActuel = ucfirst(now()->locale('fr')->isoFormat('dddd'));
            $seancesAujourdhui = EmploiDuTemps::with(['professeur', 'module', 'salle'])
                ->where('groupe_id', $etudiant->groupe_id)
                ->where('jour', $jourActuel)
                ->where('actif', true)
                ->orderBy('heure_debut')
                ->get();
        }

        return view('etudiant.dashboard', compact('etudiant', 'notifications', 'seancesAujourdhui', 'annonces'));
    }


    public function markAnnonceAsRead(Annonce $annonce)
    {
        $annonce->readers()->syncWithoutDetaching([auth()->id() => ['read_at' => now()]]);
        return back();
    }
}
