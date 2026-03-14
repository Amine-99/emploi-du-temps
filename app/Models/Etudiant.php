<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;

    protected $fillable = [
        'cef',
        'nom',
        'prenom',
        'email',
        'telephone',
        'date_naissance',
        'groupe_id',
        'user_id',
        'actif'
    ];

    protected $casts = [
        'actif' => 'boolean',
        'date_naissance' => 'date'
    ];

    // Relations
    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accesseurs
    public function getNomCompletAttribute(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }

    // Scopes
    public function scopeActif($query)
    {
        return $query->where('actif', true);
    }
}
