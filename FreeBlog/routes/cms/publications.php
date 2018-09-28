<?php

use Illuminate\Http\Request;

Route::resource('publications', 'PublicationController');
Route::get('publications/{id}/destroy', 'PublicationController@destroy')->name('publications.destroy');
Route::post('publications/destroy', 'PublicationController@destroyMulti')->name('publications.multi_destroy');