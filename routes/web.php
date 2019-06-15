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



//Route::get('/teste', function(){
//    echo '<h1>teste</h1>';
//});

//Route::get('/about', function(){
//    return view('pages.about');
//});
//
//Route::get('/users/{id}/{name}', function($id, $name){
//    return 'User:'.$id.' Name: '.$name;
//});

if(version_compare(PHP_VERSION, '7.2.0', '>=')) {

    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

}
Route::get('/', 'PagesController@index');

Route::get('/about', 'PagesController@about');

Route::get('/services', 'PagesController@services');

Route::get('/blog', 'PagesController@blog');

Route::redirect('/index', 'http://127.0.0.1/lsapp/public/');

Route::resource('posts', 'PostsController');//mapeia todas as rotas das funções de 'posts controller' 
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
