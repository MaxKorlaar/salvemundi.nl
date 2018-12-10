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

    Route::group(['prefix' => 'winkel', 'as' => 'store.'], function () {
        Route::get('/', 'StoreController@index')->name('index');

        Route::get('mandje', 'StoreController@viewCart')->name('cart');
        Route::post('mandje', 'StoreController@addToCart')->name('add_to_cart');
        Route::post('mandje/bestellen', 'StoreController@placeOrder')->name('cart.place_order');
        Route::get('mandje/bestellen', 'StoreController@viewCart');
        Route::delete('mandje/{index}', 'StoreController@removeFromCart')->name('cart.remove_item');

        Route::get('{slug}', 'StoreController@viewItem')->name('view_item');
        Route::get('{slug}/{stock}/afbeelding/{image}.pict', 'StoreController@getImage')->name('image');
        // De .pict-extensie gebruiken om CloudFlare (CDN) te forceren om de afbeelding te cachen
        Route::get('{slug}/{stock}/afbeelding/{image}/volledig.pict', 'StoreController@getImageFull')->name('image_full');

    });

    Route::get('merchandise', 'MerchandiseController@getMerchandise')->name("merchandise");
    Route::get('merchandise/vests', 'MerchandiseController@getVests')->name("merchandise.vests");
    Route::get('merchandise/shirts', 'MerchandiseController@getShirts')->name("merchandise.shirts");
    /*
     * Commissies
     */

    Route::group(['prefix' => 'commissies', 'as' => 'committees/'], function () {
        Route::get('bestuur', 'CommitteeController@getAdministrationPage')->name('administration');
        Route::get('feest', 'CommitteeController@getPartyPage')->name('party');
        Route::get('media', 'CommitteeController@getMediaPage')->name('media');
        Route::get('kamp', 'CommitteeController@getCampingPage')->name('camping');
        Route::get('activiteiten', 'CommitteeController@getActivityPage')->name('activity');
        Route::get('studie', 'CommitteeController@getStudyPage')->name('study');
        Route::get('ledenzaken', 'CommitteeController@getInternalAffairsPage')->name('internal_affairs');
        Route::get('externe-betrekkingen', 'CommitteeController@getExternalAffairsPage')->name('external_affairs');
        Route::get('alpha-centauri', 'CommitteeController@getAlphaCentauriPage')->name('alpha_centauri');
        Route::get('kas', 'CommitteeController@getTreasurePage')->name('treasure');
    });
    Route::get('nieuwe-commissieleden', 'CommitteeController@getVacanciesPage')->name('vacancies');

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

        Route::get('papas-en-mamas', 'IntroController@getSupervisorInfo')->name('supervisor_info');
        Route::get('papas-en-mamas/inschrijven', 'IntroController@getSupervisorSignupForm')->name('supervisor_signup');
        Route::post('papas-en-mamas/inschrijven', 'IntroController@supervisorSignup')->name('supervisor_signup.send');

        Route::get('inschrijven/bevestigen/{application}/{token}', 'IntroController@confirmEmail')->name('signup.confirm_email');
        Route::get('papas-en-mamas/inschrijven/bevestigen/{application}/{token}', 'IntroController@confirmSupervisorEmail')->name('supervisor_signup.confirm_email');

        Route::get('inschrijven/betalen/{application}/{token}', 'IntroController@getPaymentPage')->name('signup.payment_request');

        Route::get('inschrijven/bevestigen/betaling/', 'IntroController@confirmPayment')->name('signup.confirm_payment');

    });
    Route::post('/webhook/betaling/intro/{application}', 'IntroController@confirmPaymentWebhook')->name('webhook.payment.intro');

    Route::group(['prefix' => 'lid', 'namespace' => 'Member', 'as' => 'member.', 'middleware' => ['auth']], function () {
        Route::get('over-mij', 'IndexController@getAboutView')->name('about_me');
        Route::get('over-mij/foto', 'IndexController@getOwnPhoto')->name('own_photo');
        Route::post('lidmaatschap-verlengen', 'MembershipController@renew')->name('membership.renew');
        Route::get('lidmaatschap-verlengen/bevestigen/betaling/{transaction}', 'MembershipController@confirmPayment')->name('membership.confirm_payment');
    });

    Route::post('/webhook/betaling/lidmaatschap/{member}', 'Member\MembershipController@confirmPaymentWebhook')->name('webhook.payment.renew_membership');

    Route::group(['prefix' => 'administratie', 'namespace' => 'Admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
        //Route::resource('aanmeldingen', 'ApplicationsController')->names('applications');
        //Route::get('/aanmeldingen/{application}/pasfoto', 'SignupController@afbeelding');
        //        Route::get('account', 'AccountController@getView')->name('account');
        //        Route::put('account', 'AccountController@update')->name('update_account');
        //        Route::get('account/delete', 'AccountController@getDeleteView')->name('account_deletion');
        //        Route::delete('account', 'AccountController@delete')->name('do_delete_account');
        Route::resource('kamp', 'CampingController')->names('camping');

        Route::get('intro/onbevestigd', 'IntroController@getUnconfirmedSignups');
        Route::post('intro/genereer-tokens', 'IntroController@generateTokensForUnpaidSignups')->name('intro.generate_tokens');
        Route::post('intro/stuur-email-herinnering', 'IntroController@sendConfirmEmailReminders')->name('intro.send_email_reminders');
        Route::post('intro/stuur-betaal-herinnering', 'IntroController@sendPaymentReminders')->name('intro.send_payment_reminders');
        Route::get('intro/spreadsheet', 'IntroController@spreadsheetIndex')->name('intro.spreadsheet');
        Route::get('intro/{application}/verwijderen', 'IntroController@getDeleteConfirmation')->name('intro.delete_confirmation');
        Route::resource('intro', 'IntroController')->names('intro');

        Route::group(['prefix' => 'winkel', 'namespace' => 'Store', 'as' => 'store.', 'middleware' => ['auth.admin']], function () {
            Route::resource('items', 'ItemController');
            Route::resource('items/{item}/voorraad', 'StockController')->names('items.stock');
            Route::get('items/{item}/voorraad/{voorraad}/verwijderen', 'StockController@getDeleteConfirmation')->name('items.stock.delete_confirmation');
            Route::get('items/{item}/voorraad/{voorraad}/afbeelding/{image}', 'StockController@getImage')->name('items.stock.image');
            Route::get('items/{item}/voorraad/{voorraad}/afbeelding/{image}/volledig', 'StockController@getImageFull')->name('items.stock.image_full');
        });

        Route::get('aanmeldingen-naar-leden', 'MemberController@applicationsToMembers');

        Route::resource('gebruikers', 'UserController')->names('users');
        Route::get('leden/importeren', 'MemberController@showImportForm')->name('members.import');
        Route::post('leden/importeren', 'MemberController@importList')->name('members.do_import');

        Route::get('leden/spreadsheet', 'MemberController@spreadsheetIndex')->name('members.spreadsheet');

        Route::get('leden/email', 'MemberController@getMailForm')->name('members.email');
        Route::post('leden/email/voorbeeld', 'MemberController@getMailPreview')->name('members.preview_email');
        Route::post('leden/email', 'MemberController@sendMail')->name('members.do_send_email');

        Route::get('leden/email-verlenging-nodig', 'MemberController@getInactiveMailForm')->name('members.email_inactive');
        Route::post('leden/email-verlenging-nodig/voorbeeld', 'MemberController@getInactiveMailPreview')->name('members.preview_email_inactive');
        Route::post('leden/email-verlenging-nodig', 'MemberController@sendInactiveMail')->name('members.do_send_email_inactive');

        Route::get('leden/verwijder-inactieve', 'MemberController@deleteInactiveConfirmation')->name('members.delete_inactive_confirmation');
        Route::delete('leden/verwijder-inactieve', 'MemberController@deleteInactive')->name('members.delete_inactive');
        Route::resource('leden', 'MemberController')->names('members');
        Route::get('leden/{member}/verwijderen', 'MemberController@getDeleteConfirmation')->name('members.delete_confirmation');
        Route::resource('leden.lidmaatschap', 'MembershipController')->names('members.membership');
        Route::get('leden/{member}/afbeelding', 'MemberController@getPicture')->name('members.picture');
        Route::get('leden/{member}/afbeelding/volledig', 'MemberController@getFullPicture')->name('members.full_picture');

    });

    Route::get('korting', 'DiscountController@getDefaultView')->name('discounts.index');
    Route::get('korting/villa-fiesta', 'DiscountController@getVillaView')->name('discounts.villa_fiesta');
    Route::get('korting/happii', 'DiscountController@getHappiView')->name('discounts.happii');

    Route::get('drive', 'IndexController@getDriveRedirect');

    Route::get('privacybeleid', 'MetaController@getPrivacyPage')->name('privacy');
    Route::get('/sitemap.xml', 'MetaController@getSitemap')->name('sitemap');

    Route::get('uitschrijven', 'IndexController@getCancelPage');

    Route::get('login', 'Auth\FHICTLoginController@getLoginView')->name('login');
    Route::get('login/fhict', 'Auth\FHICTLoginController@redirect')->name('login.redirect');
    Route::get('login/oauth', 'Auth\FHICTLoginController@afterLoginAuth')->name('login.redirect_url');
    Route::get('log-uit', 'Auth\FHICTLoginController@logout')->name('logout');
    // Route::auth();