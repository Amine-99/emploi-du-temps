<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'actif',
        'force_password_change',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'actif' => 'boolean',
            'force_password_change' => 'boolean',
        ];
    }

    // Vérifier les rôles
    public function isHeadAdmin(): bool
    {
        return $this->role === 'head_admin';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin' || $this->isHeadAdmin();
    }

    public function isProfesseur(): bool
    {
        return $this->role === 'professeur';
    }

    public function isEtudiant(): bool
    {
        return $this->role === 'etudiant';
    }

    // Relations
    public function professeur()
    {
        return $this->hasOne(Professeur::class);
    }

    public function etudiant()
    {
        return $this->hasOne(Etudiant::class);
    }
}
