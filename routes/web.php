<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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
Route::get('login', ['as' => 'login', 'uses' => 'PortalLoginController@redirectToProvider']);
Route::get('callback', ['as' => 'callback', 'uses' => 'PortalLoginController@handleProviderCallback']);
Route::get("/firstPage", function(){
    return view('api_get');
});

Route::get("/IDM_OK", function(){
    return view('IDM_OK');
});

Route::get("/reader_info", function(){
    return view('reader_info');
});
