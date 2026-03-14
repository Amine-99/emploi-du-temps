<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'seance_realisation_id',
        'etudiant_id',
        'status',
        'commentaire'
    ];

    public function seanceRealisation()
    {
        return $this->belongsTo(SeanceRealisation::class);
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }
}
