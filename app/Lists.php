<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lists extends Model
{
    protected $fillable = [
        'title',
    ];

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

    public function projet()
    {
        return $this->belongsTo('App\Projet');
    }
}
