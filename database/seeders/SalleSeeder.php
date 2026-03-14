<?php

namespace Database\Seeders;

use App\Models\Salle;
use Illuminate\Database\Seeder;

class SalleSeeder extends Seeder
{
    public function run(): void
    {
        Salle::create([
            'numero' => 'A101',
            'nom' => 'Salle A101',
            'type' => 'Cours',
            'capacite' => 30,
            'equipements' => 'Tableau blanc, Projecteur',
            'batiment' => 'Bâtiment A',
            'disponible' => true
        ]);

        Salle::create([
            'numero' => 'A102',
            'nom' => 'Salle A102',
            'type' => 'Cours',
            'capacite' => 30,
            'equipements' => 'Tableau blanc, Projecteur',
            'batiment' => 'Bâtiment A',
            'disponible' => true
        ]);

        Salle::create([
            'numero' => 'B101',
            'nom' => 'Labo Info 1',
            'type' => 'TP',
            'capacite' => 20,
            'equipements' => '20 PC, Projecteur, Tableau',
            'batiment' => 'Bâtiment B',
            'disponible' => true
        ]);

        Salle::create([
            'numero' => 'B102',
            'nom' => 'Labo Info 2',
            'type' => 'TP',
            'capacite' => 20,
            'equipements' => '20 PC, Projecteur, Tableau',
            'batiment' => 'Bâtiment B',
            'disponible' => true
        ]);

        Salle::create([
            'numero' => 'C101',
            'nom' => 'Labo Réseaux',
            'type' => 'Atelier',
            'capacite' => 15,
            'equipements' => 'Switchs, Routeurs, Câblage',
            'batiment' => 'Bâtiment C',
            'disponible' => true
        ]);

        Salle::create([
            'numero' => 'AMPHI1',
            'nom' => 'Amphithéâtre Principal',
            'type' => 'Amphithéâtre',
            'capacite' => 150,
            'equipements' => 'Système audio, 2 Projecteurs, Micro',
            'batiment' => 'Bâtiment Principal',
            'disponible' => true
        ]);
    }
}
