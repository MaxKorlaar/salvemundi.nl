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
    return view('index');
})->name('home');

Route::get('/inschrijven', 'SignupController@index')->name('signup');
Route::post('/inschrijven/bevestigen', 'SignupController@getConfirmationPage')->name('signup.send');
Route::get('/inschrijven/bevestigen', 'SignupController@index');
Route::post('/inschrijven', 'SignupController@signup')->name('signup.confirm');