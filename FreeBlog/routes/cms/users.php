<?php

use Illuminate\Http\Request;

Route::resource('users', 'UserController');
Route::get('users/{id}/destroy', 'UserController@destroy')->name('users.destroy');
Route::post('users/destroy', 'UserController@destroyMulti')->name('users.multi_destroy');