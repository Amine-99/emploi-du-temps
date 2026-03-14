<?php

namespace App\Imports;

use App\Models\Professeur;
use App\Models\User;
use App\Models\Groupe;
use App\Models\Module;
use App\Models\EmploiDuTemps;
use App\Models\Salle;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProfesseursImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $matricule = $this->getVal($row, ['mle', 'matricule', 'mle affecté présentiel actif', 'mle affecté syn actif', 'mle/matricule']);
        $nom = $this->getVal($row, ['nom', 'formateur', 'professeur']);
        $prenom = $this->getVal($row, ['prenom', 'prénom']);

        if (!$matricule || !$nom) return null;

        if (!$prenom) {
             $parts = explode(' ', $nom);
             if (count($parts) >= 2) {
                 $prenom = array_shift($parts);
                 $nom = implode(' ', $parts);
             } else {
                 $prenom = $nom;
             }
        }

        $email = $this->getVal($row, ['email', 'mail']) ?: (mb_strtolower($prenom . '.' . $nom) . '@ofppt-emploi.ma');
        $tel = $this->getVal($row, ['telephone', 'phone', 'tel']);
        $spec = $this->getVal($row, ['specialite', 'spécialité', 'domaine']);

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $prenom . ' ' . $nom,
                'password' => Hash::make('OFPPT@EMPLOI'),
                'role' => 'professeur',
                'force_password_change' => true,
                'actif' => true
            ]
        );

        $professeur = Professeur::updateOrCreate(
            ['matricule' => $matricule],
            [
                'nom' => mb_strtoupper($nom),
                'prenom' => mb_convert_case($prenom, MB_CASE_TITLE, "UTF-8"),
                'email' => $email,
                'telephone' => $tel,
                'specialite' => $spec,
                'user_id' => $user->id,
                'actif' => true
            ]
        );

        // Handle associations if provided in row
        $groupeRef = $this->getVal($row, ['groupe', 'classe']);
        $moduleRef = $this->getVal($row, ['module', 'matiere', 'élément']);

        if ($groupeRef && $moduleRef) {
            $groupe = Groupe::where('nom', 'like', $groupeRef)->first();
            $module = Module::where('nom', 'like', $moduleRef)->orWhere('code', $moduleRef)->first();

            if ($groupe && $module) {
                EmploiDuTemps::updateOrCreate([
                    'professeur_id' => $professeur->id,
                    'groupe_id' => $groupe->id,
                    'module_id' => $module->id
                ], [
                    'jour' => 'Lundi',
                    'heure_debut' => '08:30:00',
                    'heure_fin' => '11:00:00',
                    'type_seance' => 'Présentiel',
                    'semaine_type' => 'Toutes',
                    'actif' => true,
                    'salle_id' => Salle::first()?->id
                ]);
            }
        }

        return $professeur;
    }

    private function getVal($row, $keys)
    {
        foreach ($keys as $key) {
            $nk = $this->normalizeKey($key);
            foreach ($row as $rk => $rv) {
                if ($this->normalizeKey($rk) === $nk && trim((string)$rv) !== '') {
                    return trim((string)$rv);
                }
            }
        }
        return null;
    }

    private function normalizeKey($key)
    {
        $key = mb_strtolower(trim($key));
        $key = preg_replace('/[áàâäãå]/u', 'a', $key);
        $key = preg_replace('/[éèêë]/u', 'e', $key);
        $key = preg_replace('/[íìîï]/u', 'i', $key);
        $key = preg_replace('/[óòôöõ]/u', 'o', $key);
        $key = preg_replace('/[úùûü]/u', 'u', $key);
        $key = preg_replace('/[^a-z0-9]/', '', $key);
        return $key;
    }
}
