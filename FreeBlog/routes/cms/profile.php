<?php

use Illuminate\Http\Request;

Route::get('profile-user/{id}', 'UserController@edit')->name('profile.edit');
Route::put('profile-user/{id}', 'UserController@update')->name('profile.update');