<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';
    protected $fillable = [
    	'name'
    ];

    public function articles(){
        return $this->belongsToMany('App\Article', 'articles_has_tags', 'tag_id', 'article_id')
            ->withTimestamps();
    }

    public function scopeSearch($query, $name){
        if(!empty($name)){
            $query = $query->where('name', 'LIKE', "%$name%");
        }

        return $query;
    }
}
