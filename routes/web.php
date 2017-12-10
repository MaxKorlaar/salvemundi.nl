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

    Route::group(['prefix' => 'administratie', 'namespace' => 'Admin', 'as' => 'admin/', 'middleware' => ['auth', 'auth.admin']], function () {
        Route::resource('aanmeldingen', 'ApplicationsController')->names('applications');
        Route::get('/aanmeldingen/{application}/pasfoto', 'SignupController@afbeelding');
        //        Route::get('account', 'AccountController@getView')->name('account');
        //        Route::put('account', 'AccountController@update')->name('update_account');
        //        Route::get('account/delete', 'AccountController@getDeleteView')->name('account_deletion');
        //        Route::delete('account', 'AccountController@delete')->name('do_delete_account');

    });

    Route::auth();

