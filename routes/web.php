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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/test', function () {
    return Request::only('searchtime');
});

Route::get('/test2', function (){
    $a = Cookie::get('lang');
    return $a;
});



Route::get('/index', 'View\navController@toIndex');

Route::get('/history', 'View\navController@toHistory');

Route::get('/stats', 'View\navController@toStats');

Route::get('/english','View\navController@setEnglishLang');

Route::get('/finnish','View\navController@setFinnishLang');

Route::get('/french','View\navController@setFrenchLang');

Route::get('/', 'View\navController@toIndex');

Route::get('/dataFunction/{device}/{detector}/{formatted}/{time}', 'View\navController@toDataFunction');

Route::get('/dataFunctionTime/{device}/{detector}/{date}/{time}', 'View\navController@toDataFunctionTime');

Route::get('/dataFunctionAmount/{device}/{detector}/{date}/{time}', 'View\navController@toDataFunctionAmount');






