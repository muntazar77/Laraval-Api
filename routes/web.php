<?php

use App\Model\Post;
use App\Model\Tag;
use App\User;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('users', function () {

// //    $post =  Post::find(1) ;
//    $post = Post::find(1);
//    $posts = $post->tags;
//    return  $posts;


// });
