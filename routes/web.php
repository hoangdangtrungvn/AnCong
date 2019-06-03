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
    return view('auth.login');
});

Route::get('login', 'AuthController@showLoginForm')->name('login');
Route::post('login', 'AuthController@login');
Route::get('logout', 'AuthController@logout')->name('logout');

Route::post('coordinators/assign', 'CoordinatorController@assign')->name('coordinators.assign');

Route::resource('coordinators', 'CoordinatorController');
Route::resource('doctors', 'DoctorController');
