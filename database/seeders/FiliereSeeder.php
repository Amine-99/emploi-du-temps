<?php

namespace Database\Seeders;

use App\Models\Filiere;
use App\Models\Groupe;
use App\Models\Module;
use App\Models\Professeur;
use App\Models\Etudiant;
use App\Models\User;
use Illuminate\Database\Seeder;

class FiliereSeeder extends Seeder
{
    public function run(): void
    {
        // Créer des filières
        $dd = Filiere::create([
            'code' => 'DD',
            'nom' => 'Développement Digital',
            'description' => 'Formation en développement web et mobile',
            'duree_formation' => 2,
            'niveau' => 'Technicien Spécialisé',
            'active' => true
        ]);

        $tri = Filiere::create([
            'code' => 'TRI',
            'nom' => 'Techniques des Réseaux Informatiques',
            'description' => 'Formation en administration réseaux et systèmes',
            'duree_formation' => 2,
            'niveau' => 'Technicien Spécialisé',
            'active' => true
        ]);

        // Créer des groupes
        $dd101 = Groupe::create([
            'nom' => 'DD101',
            'filiere_id' => $dd->id,
            'annee' => 1,
            'effectif' => 25,
            'annee_scolaire' => '2024-2025'
        ]);

        $dd201 = Groupe::create([
            'nom' => 'DD201',
            'filiere_id' => $dd->id,
            'annee' => 2,
            'effectif' => 22,
            'annee_scolaire' => '2024-2025'
        ]);

        $tri101 = Groupe::create([
            'nom' => 'TRI101',
            'filiere_id' => $tri->id,
            'annee' => 1,
            'effectif' => 28,
            'annee_scolaire' => '2024-2025'
        ]);

        // Créer des modules
        Module::create([
            'code' => 'M101',
            'nom' => 'Programmation structurée',
            'filiere_id' => $dd->id,
            'masse_horaire' => 120,
            'coefficient' => 3,
            'semestre' => 1
        ]);

        Module::create([
            'code' => 'M102',
            'nom' => 'Base de données',
            'filiere_id' => $dd->id,
            'masse_horaire' => 100,
            'coefficient' => 3,
            'semestre' => 1
        ]);

        Module::create([
            'code' => 'M103',
            'nom' => 'Développement Web Frontend',
            'filiere_id' => $dd->id,
            'masse_horaire' => 80,
            'coefficient' => 2.5,
            'semestre' => 1
        ]);

        Module::create([
            'code' => 'M201',
            'nom' => 'Administration Réseaux',
            'filiere_id' => $tri->id,
            'masse_horaire' => 100,
            'coefficient' => 3,
            'semestre' => 1
        ]);

        // Créer des professeurs
        $profUser = User::where('email', 'prof@ofppt.ma')->first();

        $prof1 = Professeur::create([
            'matricule' => 'P001',
            'nom' => 'Benjelloun',
            'prenom' => 'Ahmed',
            'email' => 'prof@ofppt.ma',
            'telephone' => '0600000001',
            'specialite' => 'Développement Web',
            'user_id' => $profUser->id,
            'actif' => true
        ]);

        Professeur::create([
            'matricule' => 'P002',
            'nom' => 'El Fassi',
            'prenom' => 'Fatima',
            'email' => 'elfassi@ofppt.ma',
            'telephone' => '0600000002',
            'specialite' => 'Base de données',
            'actif' => true
        ]);

        Professeur::create([
            'matricule' => 'P003',
            'nom' => 'Berrada',
            'prenom' => 'Karim',
            'email' => 'berrada@ofppt.ma',
            'telephone' => '0600000003',
            'specialite' => 'Réseaux',
            'actif' => true
        ]);

        // Créer des étudiants
        $etudUser = User::where('email', 'etudiant@ofppt.ma')->first();

        Etudiant::create([
            'cef' => 'E001',
            'nom' => 'Alami',
            'prenom' => 'Youssef',
            'email' => 'etudiant@ofppt.ma',
            'telephone' => '0600000010',
            'date_naissance' => '2002-05-15',
            'groupe_id' => $dd101->id,
            'user_id' => $etudUser->id,
            'actif' => true
        ]);

        Etudiant::create([
            'cef' => 'E002',
            'nom' => 'Benkirane',
            'prenom' => 'Sara',
            'email' => 'sara.benkirane@gmail.com',
            'telephone' => '0600000011',
            'date_naissance' => '2003-02-20',
            'groupe_id' => $dd101->id,
            'actif' => true
        ]);

        // Mettre à jour les effectifs
        $dd101->update(['effectif' => $dd101->etudiants()->count()]);
    }
}
