<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'category_id', 'status_id',
    ];

    public function tasks() {
      return $this->hasMany('App\Task');
    }

    public function status() {
      return $this->belongsTo('App\Status');
    }

    public function category() {
      return $this->belongsTo('App\Category');
    }

    public function users() {
      return $this->belongsToMany('App\User', 'project_user', 'project_id', 'user_id');
    }
}
