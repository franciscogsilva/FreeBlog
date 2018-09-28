<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleStatus extends Model
{
    protected $table = 'article_statuses';
    protected $fillable = [
    	'name'
    ];

    public function articles(){
        return $this->hasMany('App\Article');
    }
}
