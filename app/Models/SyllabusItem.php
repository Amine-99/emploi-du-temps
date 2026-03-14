<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyllabusItem extends Model
{
    protected $fillable = [
        'module_id',
        'titre',
        'description',
        'ordre',
        'poids_pourcentage'
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function realisations()
    {
        return $this->belongsToMany(SeanceRealisation::class, 'seance_realisation_syllabus')
                    ->withPivot('commentaire')
                    ->withTimestamps();
    }
}
