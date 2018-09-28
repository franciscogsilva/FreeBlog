<?php

use Illuminate\Http\Request;

Route::resource('articles', 'ArticleController');
Route::get('articles/{id}/destroy', 'ArticleController@destroy')->name('articles.destroy');
Route::post('articles/destroy', 'ArticleController@destroyMulti')->name('articles.multi_destroy');