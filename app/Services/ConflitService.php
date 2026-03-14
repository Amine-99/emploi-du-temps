<?php

namespace App\Services;

use App\Models\EmploiDuTemps;
use App\Models\Professeur;
use App\Models\Module;

class ConflitService
{
    /**
     * Vérifie tous les conflits pour une séance
     */
    public function verifierConflits(array $data, ?int $excludeId = null): array
    {
        $conflits = [];

        // Conflit professeur
        $conflitProf = $this->verifierConflitProfesseur(
            $data['professeur_id'],
            $data['jour'],
            $data['heure_debut'],
            $data['heure_fin'],
            $excludeId
        );
        if ($conflitProf) {
            $conflits['professeur'] = $conflitProf;
        }

        // Conflit salle
        if (($data['type_seance'] ?? 'Présentiel') === 'Présentiel' && isset($data['salle_id'])) {
            $conflitSalle = $this->verifierConflitSalle(
                $data['salle_id'],
                $data['jour'],
                $data['heure_debut'],
                $data['heure_fin'],
                $excludeId
            );
            if ($conflitSalle) {
                $conflits['salle'] = $conflitSalle;
            }
        }

        // Conflit groupe
        $conflitGroupe = $this->verifierConflitGroupe(
            $data['groupe_id'],
            $data['jour'],
            $data['heure_debut'],
            $data['heure_fin'],
            $excludeId
        );
        if ($conflitGroupe) {
            $conflits['groupe'] = $conflitGroupe;
        }

        // Vérifier le dépassement d'heures mensuelles du professeur
        $depassement = $this->verifierDepassementHeures(
            $data['professeur_id'],
            $data,
            $excludeId
        );
        if ($depassement) {
            $conflits['heures'] = $depassement;
        }

        // Vérifier le dépassement d'heures mensuelles du module
        $depassementModule = $this->verifierDepassementHeuresModule(
            $data['module_id'],
            $data,
            $excludeId
        );
        if ($depassementModule) {
            $conflits['heures_module'] = $depassementModule;
        }

        return $conflits;
    }

    /**
     * Vérifie si un professeur est déjà occupé
     */
    public function verifierConflitProfesseur(
        int $professeurId,
        string $jour,
        string $heureDebut,
        string $heureFin,
        ?int $excludeId = null
    ): ?EmploiDuTemps {
        $query = EmploiDuTemps::where('professeur_id', $professeurId)
            ->where('jour', $jour)
            ->where('actif', true)
            ->where(function ($q) use ($heureDebut, $heureFin) {
                $q->where('heure_debut', '<', $heureFin)
                  ->where('heure_fin', '>', $heureDebut);
            });

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->with(['groupe', 'module', 'salle'])->first();
    }

    /**
     * Vérifie si une salle est déjà occupée
     */
    public function verifierConflitSalle(
        int $salleId,
        string $jour,
        string $heureDebut,
        string $heureFin,
        ?int $excludeId = null
    ): ?EmploiDuTemps {
        $query = EmploiDuTemps::where('salle_id', $salleId)
            ->where('jour', $jour)
            ->where('actif', true)
            ->where(function ($q) use ($heureDebut, $heureFin) {
                $q->where('heure_debut', '<', $heureFin)
                  ->where('heure_fin', '>', $heureDebut);
            });

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->with(['groupe', 'professeur', 'module'])->first();
    }

    /**
     * Vérifie si un groupe est déjà occupé
     */
    public function verifierConflitGroupe(
        int $groupeId,
        string $jour,
        string $heureDebut,
        string $heureFin,
        ?int $excludeId = null
    ): ?EmploiDuTemps {
        $query = EmploiDuTemps::where('groupe_id', $groupeId)
            ->where('jour', $jour)
            ->where('actif', true)
            ->where(function ($q) use ($heureDebut, $heureFin) {
                $q->where('heure_debut', '<', $heureFin)
                  ->where('heure_fin', '>', $heureDebut);
            });

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->with(['professeur', 'module', 'salle'])->first();
    }

    /**
     * Vérifier si l'ajout d'une séance dépasse le max d'heures mensuelles du professeur
     */
    public function verifierDepassementHeures(int $professeurId, array $data, ?int $excludeId = null): ?array
    {
        $professeur = Professeur::find($professeurId);

        if (!$professeur || !$professeur->max_heures_mensuel) {
            return null; // pas de limite définie
        }

        $heuresActuelles = $professeur->getHeuresMensuellesActuelles($excludeId);
        $semaineType = $data['semaine_type'] ?? 'Toutes';
        
        $debut = \Carbon\Carbon::parse($data['heure_debut']);
        $fin = \Carbon\Carbon::parse($data['heure_fin']);
        $heuresCalculated = $debut->diffInMinutes($fin) / 60;
        
        $heuresNouvelle = $heuresCalculated * ($semaineType === 'Toutes' ? 4 : 2);
        $total = $heuresActuelles + $heuresNouvelle;

        if ($total > $professeur->max_heures_mensuel) {
            return [
                'professeur' => $professeur,
                'max' => $professeur->max_heures_mensuel,
                'actuel' => $heuresActuelles,
                'nouvelle' => $heuresNouvelle,
                'total' => $total,
            ];
        }

        return null;
    }

    /**
     * Vérifier si l'ajout d'une séance dépasse le max d'heures mensuelles du module
     */
    public function verifierDepassementHeuresModule(int $moduleId, array $data, ?int $excludeId = null): ?array
    {
        $module = Module::find($moduleId);

        if (!$module || !$module->max_heures_mensuel) {
            return null; // pas de limite définie
        }

        // Vérification par GROUPE
        $heuresActuelles = $module->getHeuresMensuellesActuelles($excludeId, $data['groupe_id']);
        $semaineType = $data['semaine_type'] ?? 'Toutes';
        
        $debut = \Carbon\Carbon::parse($data['heure_debut']);
        $fin = \Carbon\Carbon::parse($data['heure_fin']);
        $heuresCalculated = $debut->diffInMinutes($fin) / 60;
        
        $heuresNouvelle = $heuresCalculated * ($semaineType === 'Toutes' ? 4 : 2);
        $total = $heuresActuelles + $heuresNouvelle;

        if ($total > $module->max_heures_mensuel) {
            return [
                'module' => $module,
                'max' => $module->max_heures_mensuel,
                'actuel' => $heuresActuelles,
                'nouvelle' => $heuresNouvelle,
                'total' => $total,
                'groupe_id' => $data['groupe_id']
            ];
        }

        return null;
    }

    /**
     * Formater les messages de conflit
     */
    public function formaterMessagesConflits(array $conflits): array
    {
        $messages = [];

        if (isset($conflits['professeur'])) {
            $seance = $conflits['professeur'];
            $messages[] = "⚠️ Conflit Professeur: Déjà assigné au groupe {$seance->groupe->nom} ({$seance->heure_debut} - {$seance->heure_fin})";
        }

        if (isset($conflits['salle'])) {
            $seance = $conflits['salle'];
            $messages[] = "⚠️ Conflit Salle: Déjà utilisée par {$seance->groupe->nom} ({$seance->heure_debut} - {$seance->heure_fin})";
        }

        if (isset($conflits['groupe'])) {
            $seance = $conflits['groupe'];
            $messages[] = "⚠️ Conflit Groupe: Déjà en cours avec {$seance->professeur->nom_complet} ({$seance->heure_debut} - {$seance->heure_fin})";
        }

        if (isset($conflits['heures'])) {
            $info = $conflits['heures'];
            $actuel = $this->formatHeures($info['actuel']);
            $max = $this->formatHeures($info['max']);
            $nouvelle = $this->formatHeures($info['nouvelle']);
            $total = $this->formatHeures($info['total']);
            $messages[] = "⚠️ Dépassement d'heures professeur: Le professeur {$info['professeur']->nom_complet} a déjà {$actuel} sur {$max}/mois. Cette séance ajouterait {$nouvelle} (total: {$total}).";
        }

        if (isset($conflits['heures_module'])) {
            $info = $conflits['heures_module'];
            $actuel = $this->formatHeures($info['actuel']);
            $max = $this->formatHeures($info['max']);
            $nouvelle = $this->formatHeures($info['nouvelle']);
            $total = $this->formatHeures($info['total']);
            $messages[] = "⚠️ Dépassement d'heures module: Le module {$info['module']->code} - {$info['module']->nom} a déjà {$actuel} sur {$max}/mois. Cette séance ajouterait {$nouvelle} (total: {$total}).";
        }

        return $messages;
    }

    private function formatHeures(float $heures): string
    {
        $h = floor($heures);
        $m = round(($heures - $h) * 60);

        if ($m == 0) {
            return "{$h}h";
        }

        return "{$h}h" . str_pad($m, 2, '0', STR_PAD_LEFT) . "min";
    }
}
