<?php

use App\Model\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([
    'middleware' => 'api',

    'prefix' => 'auth',
    'namespace' =>'API'

], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    // Route::put('profile/{user}', 'AuthController@updateProfile');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('user', 'AuthController@me');

    Route::post('/admin_login', 'AuthController@adminLogin');



// profile
    Route::get('profile', 'AuthController@profile');
     Route::put('profile', 'AuthController@updateProfile');
});

// Route::get('me', 'API/Admin/UserController@me');


Route::group([
    'middleware' => 'api',
    'namespace' =>'API\Admin'
], function ($router) {

     ###### Category  #######
     Route::apiResource('category','CategoryController');

     ###### User  #######
     Route::apiResource('user','UserController');

         ###### Post #######
       Route::apiResource('post','PostController');
       Route::get('trashed-posts','PostController@trashed')->name('trashed.index');
       Route::get('trashed-posts/{id}','PostController@restore')->name('trashed.restore');

         Route::get("posts/all", "PostController@all");




     // Route::get('post/{slug}','PostController@postSlug');


         ###### setting #######
      Route::get('/settings','SettingController@index')->name('settings');
      Route::put('/settings/update','SettingController@update')->name('settings.update');



    // Route::group([ 'middleware' => [ 'auth:api' ]], function () {

    // // Route::apiResource('user','UserController');




    // });

});


 Route::group(['middleware' => 'api','namespace' =>'API'], function () {

// منشورات ذات صلة
 Route::get("posts/related/{slug}", "HomeController@relatedPost");

 // منشورات اكثر مشاهدة  most viwe
 Route::get("posts/mostview", "HomeController@mostViwe");

 // منشورات اكثر مشاهدة  most viwe
 Route::get("posts/newsPost", "HomeController@newsPost");

// Singl post
 Route::get("posts/singl/{slug}", "HomeController@singPost");

// category
 Route::get("categoryAll", "HomeController@categoryAll");
 Route::get("category/posts/{id}", "HomeController@categoryPosts");
 Route::get("category/name/{id}", "HomeController@categoryName");



//مقالات المميزة
Route::get("posts/featured", "HomeController@featuredPost");


// count
 Route::get("count/numbr", "HomeController@count");

//  بحث
 Route::get('res-search','HomeController@search');
//  Route::get('searchposts/{query}','HomeController@searchposts');








 });


