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
    	'image_id',
        'article_status_id'
    ];

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function image(){
        return $this->belongsTo('App\Image', 'image_id');
    }

    public function status(){
        return $this->belongsTo('App\ArticleStatus', 'article_status_id');
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

    public function scopeSearch($query, $search, $category_id, $tag_id, $article_status_id=null){
        if(!empty($search)){
            $query = $query->where('title', 'LIKE', "%$search%")
                ->orWhereHas('user', function($query) use($search){
                    $query->where('name', 'LIKE', "%$search%")
                        ->orWhere('email', 'LIKE', "%$search%");
                });
        }if(!empty($category_id)){
            $query = $query->whereHas('categories', function($categories) use($category_id){
                $categories->where('category_id', $category_id);
            });
        }if(!empty($tag_id)){
            $query = $query->whereHas('tags', function($tags) use($tag_id){
                $tags->where('tag_id', $tag_id);
            });
        }if(!empty($article_status_id)){
            $query->where('article_status_id', $article_status_id);
        }

        return $query;
    }
}
