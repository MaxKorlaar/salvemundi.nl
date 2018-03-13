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

    Route::get('/', 'IndexController@getHomePage')->name('home');

    /*
     * Commissies
     */

    Route::group(['prefix' => 'commissies', 'as' => 'committees/'], function () {
        Route::get('bestuur', 'CommitteeController@getAdministrationPage')->name('administration');
        Route::get('feest', 'CommitteeController@getPartyPage')->name('party');
        Route::get('media', 'CommitteeController@getMediaPage')->name('media');
        Route::get('kamp', 'CommitteeController@getCampingPage')->name('camping');
        Route::get('dames', 'CommitteeController@getWomenPage')->name('women');
    });

    Route::get('/evenementen/facebook', 'IndexController@getFacebookEvents')->name('facebook_events');

    Route::group(['prefix' => 'inschrijven', 'as' => 'signup.'], function () {
        Route::get('/', 'SignupController@index')->name('signup');
        Route::post('/', 'SignupController@signup')->name('confirm');
        Route::get('/bevestigen', 'SignupController@getConfirmationPageWithoutSignup')->name('confirmation');
        Route::post('/bevestigen', 'SignupController@getConfirmationPage')->name('send');
        Route::get('/bevestigen/{application}/{token}', 'SignupController@confirmEmail')->name('confirm_email');

        Route::get('/bevestigen/betaling/', 'SignupController@confirmPayment')->name('confirm_payment');
    });
    Route::post('/webhook/betaling/inschrijven/{application}', 'SignupController@confirmPaymentWebhook')->name('webhook.payment.signup');

    Route::get('/kamp', 'CampingController@index')->name('camping');
    Route::get('/kamp/inschrijven', 'CampingController@getSignupForm')->name('camping.signup');
    Route::post('/kamp/inschrijven', 'CampingController@signup')->name('camping.signup.send');
    Route::get('/kamp/inschrijven/bevestigen/{application}/{token}', 'CampingController@confirmEmail')->name('camping.signup.confirm_email');

    Route::get('/kamp/inschrijven/bevestigen/betaling/', 'CampingController@confirmPayment')->name('camping.signup.confirm_payment');
    Route::post('/webhook/betaling/kamp/{application}', 'CampingController@confirmPaymentWebhook')->name('webhook.payment.camping');

    Route::group(['prefix' => 'intro', 'as' => 'intro.'], function () {
        Route::get('/', 'IntroController@getInfo')->name('info');
        Route::get('inschrijven', 'IntroController@getSignupForm')->name('signup');
        Route::post('inschrijven', 'IntroController@signup')->name('signup.send');

        Route::get('inschrijven/papas-en-mamas', 'IntroController@getSupervisorInfo')->name('supervisor_info');
        Route::get('inschrijven/papas-en-mamas/gegevens', 'IntroController@getSupervisorSignupForm')->name('supervisor_signup');
        Route::post('inschrijven/papas-en-mamas/gegevens', 'IntroController@supervisorSignup')->name('supervisor_signup.send');

        Route::get('inschrijven/bevestigen/{application}/{token}', 'IntroController@confirmEmail')->name('signup.confirm_email');

        Route::get('inschrijven/bevestigen/betaling/', 'IntroController@confirmPayment')->name('signup.confirm_payment');

    });
    Route::post('/webhook/betaling/intro/{application}', 'IntroController@confirmPaymentWebhook')->name('webhook.payment.intro');

    Route::group(['prefix' => 'administratie', 'namespace' => 'Admin', 'as' => 'admin/', 'middleware' => ['auth', 'auth.admin']], function () {
        //Route::resource('aanmeldingen', 'ApplicationsController')->names('applications');
        //Route::get('/aanmeldingen/{application}/pasfoto', 'SignupController@afbeelding');
        //        Route::get('account', 'AccountController@getView')->name('account');
        //        Route::put('account', 'AccountController@update')->name('update_account');
        //        Route::get('account/delete', 'AccountController@getDeleteView')->name('account_deletion');
        //        Route::delete('account', 'AccountController@delete')->name('do_delete_account');
        Route::get('kamp', 'CampingController@getSignups')->name('camping');
    });

    Route::get('privacybeleid', 'MetaController@getPrivacyPage')->name('privacy');
    Route::get('/sitemap.xml', 'MetaController@getSitemap')->name('sitemap');
    // Route::auth();

