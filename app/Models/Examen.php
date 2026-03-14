<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'groupe_id',
        'salle_id',
        'date',
        'heure_debut',
        'heure_fin',
        'type',
        'coefficient',
    ];

    protected $casts = [
        'date' => 'date',
        'coefficient' => 'float',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }

    public function salle()
    {
        return $this->belongsTo(Salle::class);
    }
}
