<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    public function articles(){
        return $this->hasMany('App\Article');
    }
}
