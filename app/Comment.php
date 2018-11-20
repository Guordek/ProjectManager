<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comment', 'task_id', 'user_id'
    ];

    public function task() {
      return $this->belongsTo('App\Task');
    }

    public function user() {
      return $this->belongsTo('App\User');
    }
}
