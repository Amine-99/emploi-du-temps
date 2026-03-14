<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeanceRealisation extends Model
{
    protected $fillable = ['emploi_du_temps_id', 'date', 'module_id'];

    protected $casts = [
        'date' => 'date'
    ];

    public function emploiDuTemps()
    {
        return $this->belongsTo(EmploiDuTemps::class)->withTrashed();
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function syllabusItems()
    {
        return $this->belongsToMany(SyllabusItem::class, 'seance_realisation_syllabus')
                    ->withPivot('commentaire')
                    ->withTimestamps();
    }
}
