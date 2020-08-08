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

Route::get('/key', function(){
    $key = str_random(32);
    return $key;
});

Route::get('/headline/list', 'HeadlineController@list');
Route::get('/keuangan/list','KeuanganController@list');

Route::post('/register','AuthController@register');
Route::post('/login','AuthController@login');
Route::get('/logout', 'AuthController@logout');

Route::group(['middleware'=>'login'],function(){
    Route::get('/', 'AuthController@check');

    //User Controller
    Route::get('/user','UserController@index');
    Route::post('/user/store','UserController@store');
    Route::get('/user/{id}','UserController@show');
    Route::put('/user/update/{id}','UserController@update');
    Route::delete('/user/{id}','UserController@delete');
    Route::put('/user/{id}','UserController@updateProfile');

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

    //Video Controller
    Route::get('/video','VideoController@index');
    Route::post('/video/create','VideoController@create');
    Route::get('/video/{id}','VideoController@show');
    Route::put('/video/{id}','VideoController@update');
    Route::delete('/video/{id}','VideoController@delete');

    //Headline 
    Route::get('/headline/dashboard', 'HeadlineController@dashboard');
    Route::get('/headline', 'HeadlineController@index');
    Route::get('/headline/{id}', 'HeadlineController@show');
    Route::post('/headline', 'HeadlineController@store');
    Route::put('/headline/{id}', 'HeadlineController@update');
    Route::delete('/headline/{id}', 'HeadlineController@delete');

    // Imam 
    Route::get('/imam', 'ImamController@index');
    Route::get('/imam/{id}', 'ImamController@show');
    Route::post('/imam', 'ImamController@store');
    Route::post('/imam/{id}', 'ImamController@update');
    Route::delete('/imam/{id}', 'ImamController@delete');

    // Pengurus
    Route::get('/pengurus', 'PengurusController@index');
    Route::get('/pengurus/{id}', 'PengurusController@show');
    Route::post('/pengurus', 'PengurusController@store');
    Route::post('/pengurus/{id}', 'PengurusController@update');
    Route::delete('/pengurus/{id}', 'PengurusController@delete');

    // List Slide
    Route::get('/slide', 'SlideController@index');
    Route::get('/slide/{id}', 'SlideController@show');
    Route::post('/slide', 'SlideController@store');
    Route::post('/slide/{id}', 'SlideController@update');
    Route::delete('/slide/{id}', 'SlideController@delete');

    // Penasehat
    Route::get('/penasehat', 'PenasehatController@index');
    Route::get('/penasehat/{id}', 'PenasehatController@show');
    Route::post('/penasehat', 'PenasehatController@store');
    Route::post('/penasehat/{id}', 'PenasehatController@update');
    Route::delete('/penasehat/{id}', 'PenasehatController@delete');
});
