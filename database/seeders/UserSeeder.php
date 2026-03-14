<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Head Admin
        User::create([
            'name' => 'Head Administrateur',
            'email' => 'headadmin@ofppt.ma',
            'password' => 'OFPPT@EMPLOI',
            'role' => 'head_admin'
        ]);

        // Admin
        User::create([
            'name' => 'Administrateur',
            'email' => 'admin@ofppt.ma',
            'password' => 'OFPPT@EMPLOI',
            'role' => 'admin'
        ]);

        // Professeur
        User::create([
            'name' => 'Ahmed Benjelloun',
            'email' => 'prof@ofppt.ma',
            'password' => 'OFPPT@EMPLOI',
            'role' => 'professeur'
        ]);

        // Étudiant
        User::create([
            'name' => 'Youssef Alami',
            'email' => 'etudiant@ofppt.ma',
            'password' => 'OFPPT@EMPLOI',
            'role' => 'etudiant'
        ]);
    }
}
