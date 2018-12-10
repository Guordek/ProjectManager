<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'color',
    ];

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }
}
