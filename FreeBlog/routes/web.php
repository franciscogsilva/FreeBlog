<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/register/verify/{confirmation_code}', 'Auth\AuthController@verify');
	
Route::namespace('Web')->group(function(){
	Route::get('/', 'HomeController@index')->name('welcome');

	Route::get('/home', function () {
	    return redirect()->route('welcome');
	})->name('home');

	Route::get('articles/{slug}', 'ArticleController@show')->name('articles.show-front');
});

Route::group(['prefix'=>'admin', 'middleware' => ['web','auth', 'editor']], function () {	
	Route::namespace('Cms')->group(function(){
		Route::get('/', 'HomeController@index')->name('admin.index');
		include_once 'cms/articles.php';
		include_once 'cms/categories.php';
		include_once 'cms/profile.php';
		include_once 'cms/tags.php';
	});
});

Route::group(['prefix'=>'admin', 'middleware' => ['web','auth', 'admin']], function () {	
	Route::namespace('Cms')->group(function(){
		include_once 'cms/users.php';	
    });
});	
