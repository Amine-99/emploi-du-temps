<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Professeur;
use App\Models\Filiere;
use App\Models\SeanceRealisation;
use App\Models\SyllabusItem;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',        // Code unique du module (ex: INF101)
        'nom',         // Nom du module
        'masse_horaire', // Masse horaire
        'coefficient', // Coefficient
        'semestre',    // Semestre
        'max_heures_mensuel', // Limite d'heures mensuelles
    ];

    protected $casts = [
        'max_heures_mensuel' => 'integer',
    ];

    // Un module peut être enseigné par plusieurs professeurs
    public function professeurs()
    {
        return $this->belongsToMany(Professeur::class, 'module_professeur');
    }

    // Un module peut appartenir à plusieurs filières
    public function filieres()
    {
        return $this->belongsToMany(Filiere::class);
    }

    // Un module peut apparaître dans plusieurs emplois du temps
    public function emploisDuTemps()
    {
        return $this->hasMany(EmploiDuTemps::class);
    }

    /**
     * Calculer les heures mensuelles réalisées du module pour un groupe spécifique (ou tous)
     */
    public function getHeuresMensuellesActuelles(?int $excludeEmploiId = null, ?int $groupeId = null): float
    {
        $debutMois = now()->startOfMonth();
        $finMois = now()->endOfMonth();

        $query = SeanceRealisation::where(function($q) use ($groupeId) {
            $q->where('module_id', $this->id)
              ->orWhere(function($sq) {
                  $sq->whereNull('module_id')
                     ->whereHas('emploiDuTemps', function($eq) {
                         $eq->where('module_id', $this->id);
                     });
              });
        });

        if ($groupeId) {
            $query->whereHas('emploiDuTemps', function($q) use ($groupeId) {
                $q->where('groupe_id', $groupeId);
            });
        }

        if ($excludeEmploiId) {
            $query->where('emploi_du_temps_id', '!=', $excludeEmploiId);
        }

        $query->whereBetween('date', [$debutMois, $finMois]);

        $totalMinutes = 0;
        foreach ($query->get() as $realisation) {
            $emploi = $realisation->emploiDuTemps;
            $debut = \Carbon\Carbon::parse($emploi->heure_debut);
            $fin = \Carbon\Carbon::parse($emploi->heure_fin);
            $totalMinutes += $debut->diffInMinutes($fin);
        }

        return $totalMinutes / 60;
    }

    /**
     * Calculer le total des heures (masse horaire consommée) pour un groupe
     * Basé sur les séances RÉELLEMENT validées par les professeurs
     */
    public function getHeuresTotalesByGroupe(int $groupeId): float
    {
        $query = SeanceRealisation::whereHas('emploiDuTemps', function($q) use ($groupeId) {
            $q->where('groupe_id', $groupeId);
        })
        ->where(function($q) {
            $q->where('module_id', $this->id)
              ->orWhere(function($sq) {
                  $sq->whereNull('module_id')
                     ->whereHas('emploiDuTemps', function($eq) {
                         $eq->where('module_id', $this->id);
                     });
              });
        });

        $totalMinutes = 0;
        foreach ($query->get() as $realisation) {
            $emploi = $realisation->emploiDuTemps;
            $debut = \Carbon\Carbon::parse($emploi->heure_debut);
            $fin = \Carbon\Carbon::parse($emploi->heure_fin);
            $totalMinutes += $debut->diffInMinutes($fin);
        }

        return $totalMinutes / 60;
    }

    public function syllabusItems()
    {
        return $this->hasMany(SyllabusItem::class)->orderBy('ordre');
    }

    public function getProgressSyllabusAttribute()
    {
        $totalPoids = $this->syllabusItems()->sum('poids_pourcentage');
        if ($totalPoids == 0) return 0;

        $completedPoids = $this->syllabusItems()
            ->whereHas('realisations')
            ->sum('poids_pourcentage');
        
        return min(100, round(($completedPoids / $totalPoids) * 100));
    }
}
