<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Groupe;
use App\Models\Filiere;

class GroupeSeeder extends Seeder
{
    public function run(): void
    {
        $filieres = Filiere::all();

        if ($filieres->isEmpty()) {
            return;
        }

        $groupes = [
            ['nom' => 'Groupe 1', 'filiere_id' => $filieres->first()->id, 'annee' => 1, 'annee_scolaire' => '2025-2026'],
            ['nom' => 'Groupe 2', 'filiere_id' => $filieres->first()->id, 'annee' => 1, 'annee_scolaire' => '2025-2026'],
        ];

        foreach ($groupes as $groupe) {
            Groupe::create($groupe);
        }
    }
}
