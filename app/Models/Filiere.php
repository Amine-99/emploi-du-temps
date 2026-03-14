<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'nom',
        'description',
        'duree_formation',
        'niveau',
        'annee',
        'secteur',
        'type_formation',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean',
        'duree_formation' => 'integer'
    ];

    // Relations
    public function groupes()
    {
        return $this->hasMany(Groupe::class);
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class);
    }

    public function professeurs()
    {
        return $this->belongsToMany(Professeur::class, 'filiere_professeur');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    // Constantes
    const NIVEAUX = [
        'Technicien',
        'Technicien Spécialisé',
        'Qualification'
    ];
}
