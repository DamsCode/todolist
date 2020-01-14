<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'task','isDone',
    ];

    public function lists()
    {
        return $this->belongsTo('App\Lists');
    }
}
