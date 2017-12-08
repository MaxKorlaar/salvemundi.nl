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
    Route::get('/inschrijven/bevestigen', 'SignupController@getConfirmationPageWithoutSignup')->name('signup.confirmation');
    Route::post('/inschrijven/bevestigen', 'SignupController@getConfirmationPage')->name('signup.send');
    Route::post('/inschrijven', 'SignupController@signup')->name('signup.confirm');

    Route::get('/inschrijven/bevestigen/{application}/{token}', 'SignupController@confirmEmail')->name('signup.confirm_email');

    Route::get('/afbeelding/{application}', 'SignupController@afbeelding');