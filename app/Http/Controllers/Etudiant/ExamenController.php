<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Examen;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExamenController extends Controller
{
    public function index()
    {
        $etudiant = auth()->user()->etudiant;
        
        // Only show upcoming exams (today or future)
        $examens = Examen::with(['module', 'salle'])
            ->where('groupe_id', $etudiant->groupe_id)
            ->where('date', '>=', now()->toDateString())
            ->orderBy('date', 'asc')
            ->get();

        // Add countdown information to each examen
        foreach ($examens as $examen) {
            $examDate = Carbon::parse($examen->date);
            $daysRemaining = now()->startOfDay()->diffInDays($examDate, false);
            
            if ($daysRemaining == 0) {
                $examen->countdown = "Aujourd'hui";
                $examen->countdown_class = "danger";
            } elseif ($daysRemaining == 1) {
                $examen->countdown = "Demain";
                $examen->countdown_class = "warning";
            } else {
                $examen->countdown = "Dans $daysRemaining jours";
                $examen->countdown_class = "info";
            }
        }

        return view('etudiant.examens.index', compact('examens'));
    }
}
