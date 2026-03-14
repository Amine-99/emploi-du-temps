<?php

namespace App\Imports;

use App\Models\Etudiant;
use App\Models\Groupe;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;

class EtudiantsImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $cef = $this->getVal($row, ['cef', 'id', 'matricule']);
        $nom = $this->getVal($row, ['nom', 'last name', 'lastname']);
        $prenom = $this->getVal($row, ['prenom', 'prénom', 'first name', 'firstname']);
        $groupeName = $this->getVal($row, ['groupe', 'classe', 'section']);
        $dateN = $this->getVal($row, ['datenaissance', 'date naissance', 'naissance', 'dob']);

        if (!$cef || !$nom || !$prenom || !$groupeName) {
            return null;
        }

        $email = $cef . '@ofppt-emploi.ma';
        $groupe = Groupe::where('nom', 'like', $groupeName)->first();
        if (!$groupe) return null;

        // Create or update User
        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $prenom . ' ' . $nom,
                'password' => Hash::make('OFPPT@EMPLOI'),
                'role' => 'etudiant',
                'force_password_change' => true,
                'actif' => true,
            ]
        );

        // Date format handling
        $dateNaissance = null;
        if ($dateN) {
            try {
                if (is_numeric($dateN)) {
                    $dateNaissance = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($dateN);
                } else {
                    $dateNaissance = Carbon::parse($dateN);
                }
            } catch (\Exception $e) {}
        }

        // Create or update Etudiant
        $etudiant = Etudiant::updateOrCreate(
            ['cef' => $cef],
            [
                'nom' => mb_strtoupper($nom),
                'prenom' => mb_convert_case($prenom, MB_CASE_TITLE, "UTF-8"),
                'email' => $email,
                'date_naissance' => $dateNaissance,
                'groupe_id' => $groupe->id,
                'user_id' => $user->id,
                'actif' => true,
            ]
        );

        // Update group effectif
        $groupe->update(['effectif' => $groupe->etudiants()->count()]);

        return $etudiant;
    }

    public function rules(): array
    {
        return [
            // Using '*' for header-agnostic rules if possible, but ToModel usually needs keys
        ];
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
