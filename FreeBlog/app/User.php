<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function articles(){
        return $this->hasMany('App\Article');
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }

    public function likes(){
        return $this->belongsToMany('App\Article', 'likes', 'user_id', 'article_id')
            ->withTimestamps();
    }

    public function isAdmin(){
        return $this->type->name === 'Admin';
    }

    public function updateLoginDate(){
        $this->logged_at = Carbon::now();
        $this->save();
    }
}
