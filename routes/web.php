<?php

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


Auth::routes([
    'reset' => false,
    'verify' => false,
    'register' => false,
]);



Route::post('/postIngreso', 'SolicitudController@postIngreso')->name('postIngreso');
Route::post('/postSalida', 'SolicitudController@postSalida')->name('postSalida');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/test', 'SolicitudController@test')->name('test');
Route::get('/getSolicitudes', 'SolicitudController@getSolicitudes')->name('getSolicitudes');
Route::get('/getDepartamentos', 'SolicitudController@getDepartamentos')->name('getDepartamentos');
Route::get('/getPuestos', 'SolicitudController@getPuestos')->name('getPuestos');
Route::get('/getLocalidad', 'SolicitudController@getLocalidad')->name('getLocalidad');
Route::get('/getEmpleado', 'SolicitudController@getEmpleado')->name('getEmpleado');

Route::delete('/deleteSalida/{id}', 'SolicitudController@deleteSalida')->name('deleteSalida');
Route::delete('/procesarSalida/{id}', 'SolicitudController@procesarSalida')->name('procesarSalida');



// Vue-Router 
Route::get('{path}', 'HomeController@index')->where( 'path' , '([A-z\d\-\/_.]+)?' );
