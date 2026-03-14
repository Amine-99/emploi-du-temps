<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    protected $fillable = ['titre', 'contenu', 'user_id', 'active'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function readers()
    {
        return $this->belongsToMany(User::class, 'annonce_reads')->withPivot('read_at');
    }

    public function isReadBy($user)
    {
        return $this->readers()->where('user_id', $user->id)->exists();
    }
}
