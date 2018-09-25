<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = [
    	'name'
    ];

    public function articles(){
        return $this->belongsToMany('App\Article', 'articles_has_categories', 'category_id', 'article_id')
            ->withTimestamps();
    }
}
