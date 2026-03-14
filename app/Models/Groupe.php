<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'filiere_id',
        'annee',
        'effectif',
        'annee_scolaire',
        'actif'
    ];

    protected $casts = [
        'annee' => 'integer',
        'effectif' => 'integer',
        'actif' => 'boolean'
    ];

    // Relations
    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }

    public function emploisDuTemps()
    {
        return $this->hasMany(EmploiDuTemps::class);
    }

    public function professeurs()
    {
        return $this->belongsToMany(Professeur::class, 'professeur_groupe');
    }

    // Accesseur pour nom complet
    public function getNomCompletAttribute(): string
    {
        return $this->nom . ' - ' . $this->filiere->nom;
    }
}
