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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/test', 'SolicitudController@test')->name('test');
Route::get('/getSolicitudes', 'SolicitudController@getSolicitudes')->name('getSolicitudes');
Route::get('/getDepartamentos', 'SolicitudController@getDepartamentos')->name('getDepartamentos');
Route::get('/getPuestos', 'SolicitudController@getPuestos')->name('getPuestos');
Route::get('/getLocalidad', 'SolicitudController@getLocalidad')->name('getLocalidad');
Route::get('/infoSolicitud/{id}', 'SolicitudController@infoSolicitud')->name('infoSolicitud');
Route::get('/getEmpleado', 'SolicitudController@getEmpleado')->name('getEmpleado');


// Vue-Router 
Route::get('{path}', 'HomeController@index')->where( 'path' , '([A-z\d\-\/_.]+)?' );
