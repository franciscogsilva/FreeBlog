<?php

use Illuminate\Http\Request;

Route::resource('categories', 'CategoryController');
Route::get('categories/{id}/destroy', 'CategoryController@destroy')->name('categories.destroy');
Route::post('categories/destroy', 'CategoryController@destroyMulti')->name('categories.multi_destroy');