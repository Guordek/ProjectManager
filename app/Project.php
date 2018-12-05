<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\Sluggable;

class Project extends Model
{

    use Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'start', 'end', 'slug', 'category_id', 'status_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'start',
        'end',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

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
