<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});



	Route::group(['prefix' => 'admin'], function () {
	    Route::get('/', ["as" => "dashboard" , "uses" => "HomeController@index"]);

	Route::resource("users" , "UserController");
	Route::resource("posts" , "PostsController");
	Route::resource("categories" , "CategoryController");
	Route::resource("Permission" , "PermissionController" , ["except" => ["show" , "create"]]);
	Route::get("settings" , ["as" => "settings" , "uses" => "PagesController@settings"]);

	});

    Route::post('/sendmessage', ["as" => "chat" , "uses" => "ChatController@sendMessage"]);
/*
    Route::get('testweb', function(){
    	return view("test");
    });
*/

	Route::get("profile/{user}" , ["as" => "profile" , "uses" => "PagesController@profile"]);

	Route::get("logoutoff" , "PagesController@logoutoff");



Route::auth();


