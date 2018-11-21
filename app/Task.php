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
        'name', 'description', 'start', 'end', 'project_id', 'user_id', 'level_id', 'status_id'
    ];

    public function project() {
      return $this->belongsTo('App\Project');
    }

    public function level() {
      return $this->belongsTo('App\Level');
    }

    public function status() {
      return $this->belongsTo('App\Status');
    }

    public function user() {
      return $this->belongsTo('App\User');
    }

    public function comments() {
      return $this->hasMany('App\Comment');
    }
}
