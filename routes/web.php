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

Route::resource('coordinators', 'CoordinatorController');
Route::post('coordinators/assign', 'CoordinatorController@assign')->name('coordinators.assign');

Route::resource('doctors', 'DoctorController');
Route::post('doctors/assign', 'DoctorController@assign')->name('doctors.assign');
Route::post('doctors/message', 'DoctorController@message')->name('doctors.message');
Route::get('doctors/question/{id}', 'DoctorController@question')->name('doctors.question');

Route::resource('specialists', 'SpecialistController');
Route::post('specialists/message', 'SpecialistController@message')->name('specialists.message');
Route::get('specialists/question/{id}', 'SpecialistController@question')->name('specialists.question');
