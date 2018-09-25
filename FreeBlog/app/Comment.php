<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = [
    	'comment',
    	'user_id'
    ];

    public function article(){
        return $this->belongsTo('App\Article', 'article_id');
    }

    public function comment(){
        return $this->belongsTo('App\Comment', 'comment_id');
    }

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }
}
