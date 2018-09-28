<?php

use Illuminate\Http\Request;

Route::resource('tags', 'TagController');
Route::get('tags/{id}/destroy', 'TagController@destroy')->name('tags.destroy');
Route::post('tags/destroy', 'TagController@destroyMulti')->name('tags.multi_destroy');