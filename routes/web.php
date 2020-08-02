<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

Route::get('/key', function(){
    $key = str_random(32);
    return $key;
});

Route::get('/headline/list', 'HeadlineController@list');
Route::get('/keuangan/list','KeuanganController@list');

Route::post('/register','AuthController@register');
Route::post('/login','AuthController@login');

Route::group(['middleware'=>'login'],function(){
    Route::get('/', function () {
        return redirect('beranda');
    });

    //User Controller
    Route::get('/user','UserController@index');
    Route::get('/user/{id}','UserController@show');
    Route::post('/user/store','UserController@store');
    Route::put('/user/{id}','UserController@update');
    Route::delete('/user/{id}','UserController@delete');

    //Keuangan Controller
    Route::get('/keuangan','KeuanganController@index');
    Route::get('/keuangan/{id}','KeuanganController@show');
    Route::post('/keuangan/store','KeuanganController@store');
    Route::put('/keuangan/{id}','KeuanganController@update');
    Route::delete('/keuangan/{id}','KeuanganController@delete');

    //Foto Controller
    Route::get('/foto','FotoController@index');
    Route::post('/foto/create','FotoController@create');
    Route::get('/foto/{id}','FotoController@show');
    Route::put('/foto/{id}','FotoController@update');
    Route::delete('/foto/{id}','FotoController@delete');

    //Headline 
    Route::get('/headline', 'HeadlineController@index');
    Route::get('/headline/{id}', 'HeadlineController@show');
    Route::post('/headline', 'HeadlineController@store');
    Route::put('/headline/{id}', 'HeadlineController@update');
    Route::delete('/headline/{id}', 'HeadlineController@delete');
});
