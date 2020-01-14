<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    protected $fillable = [
        'title','description',
    ];


    public function lists()
    {
        return $this->hasMany('App\Lists');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
