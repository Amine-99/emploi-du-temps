<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salle extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero',
        'nom',
        'type',
        'capacite',
        'equipements',
        'batiment',
        'disponible'
    ];

    protected $casts = [
        'capacite' => 'integer',
        'disponible' => 'boolean'
    ];

    // Relations
    public function emploisDuTemps()
    {
        return $this->hasMany(EmploiDuTemps::class);
    }

    // Scopes
    public function scopeDisponible($query)
    {
        return $query->where('disponible', true);
    }

    // Constantes
    const TYPES = [
        'Cours',
        'TP',
        'Atelier',
        'Amphithéâtre'
    ];
}
