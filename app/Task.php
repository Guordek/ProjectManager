<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'start', 'end', 'project_id', 'level_id',
    ];

    public function project() {
      return $this->belongsTo('App\Project');
    }

    public function level() {
      return $this->belongsTo('App\Level');
    }
}
