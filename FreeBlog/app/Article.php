<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';
    protected $fillable = [
    	'title',
    	'slug',
    	'content',
    	'user_id',
    	'image_id'
    ];

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function image(){
        return $this->belongsTo('App\Image', 'image_id');
    }

    public function categories(){
        return $this->belongsToMany('App\Category', 'articles_has_categories', 'article_id', 'category_id')
            ->withTimestamps();
    }

    public function tags(){
        return $this->belongsToMany('App\Tag', 'articles_has_tags', 'article_id', 'tag_id')
            ->withTimestamps();
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }

    public function likes(){
        return $this->belongsToMany('App\User', 'likes', 'article_id', 'user_id')
            ->withTimestamps();
    }
}
