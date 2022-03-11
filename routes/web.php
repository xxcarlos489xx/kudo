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
Route::get('/','Dashboard\DashboardController@index');

Route::get('/dashboard/{vue_capture?}', 'Dashboard\DashboardController@index')->where('vue_capture', '^(?!storage).*$')->name('dashboard');
Route::post('/dashboard/getTableros', 'Dashboard\DashboardController@getTableros');
Route::post('/dashboard/eliminar/{id}', 'Dashboard\DashboardController@eliminar');
Route::post('/dashboard/enviar/{id}', 'Dashboard\DashboardController@enviar');
Route::post('/dashboard/getTablero/{id}', 'Dashboard\DashboardController@getTablero');
Route::post('/dashboard/saveTablero', 'Dashboard\DashboardController@saveTablero');
Route::post('/dashboard/saveKudo', 'Dashboard\DashboardController@saveKudo');


//RUTAS DE LOGIN
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('auth/login', 'Auth\LoginController@login');
Route::get('auth/logout', 'Auth\LoginController@logout')->name('authLogout');
