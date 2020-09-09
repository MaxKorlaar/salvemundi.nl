<?php

    use Carbon\Carbon;

    return [
        'title'              => 'Aanmelden',
        'text'               => 'Om MediaMeiden te bekostigen, vragen we geen vergoeding van €20,- per jaar voor het lidmaatschap',
        'pcn'                => 'Fontys PCN',
        'first_name'         => 'Voornaam',
        'last_name'          => 'Achternaam',
        'address'            => 'Straat en huisnummer',
        'city'               => 'Woonplaats',
        'postal_code'        => 'Postcode',
        'postal'             => 'Postcode',
        'country'            => 'Land',
        'birthday'           => 'Geboortedatum',
        'birthday_format'    => 'dd-mm-jjjj (' . Carbon::now()->format('d-m-Y') . ')',
        'phone'              => 'Telefoonnummer',
        'email'              => 'E-mailadres',
        'email_confirmation' => 'Bevestig je e-mailadres',
        'picture'            => 'Pasfoto',
        'picture_help'       => 'Kies een pasfoto die op je ledenpasje komt te staan.
        Afbeeldingen mogen maximaal 5 MB groot zijn en moeten minimaal 200 bij 300 pixels groot zijn.',
        'sign_up'            => 'Versturen',
        'please_confirm'     => 'Controleer alsjeblieft de onderstaande gegevens voordat je de inschrijving verstuurt. Het kost ons extra tijd om fouten later te corrigeren.',
        'i_agree_terms'      => 'Door verder te gaan met je inschrijving ga je akkoord met ons <a href="' . route('privacy') . '" target="_blank">privacybeleid</a>.',
        'payment_redirect'   => 'Door op \'Aanmelden\' te klikken ga je akkoord met de opslag en verwerking van je persoonsgegevens volgens ons <a href="' . route('privacy') . '" target="_blank">privacybeleid</a>, en zal je niet worden doorgestuurd naar de betalingspagina. Het is hier niet mogelijk om met iDeal te betalen. Indien je de betaling annuleert zullen je gegevens direct worden verwijderd en gaat je inschrijving niet door. Het is dan mogelijk om je opnieuw in te schrijven.',
        'confirm'            => 'Aanmelden',

        'errors'                  => [
            'minimum_age_not_met'  => 'Je moet minstens 16 jaar oud zijn om jezelf in te mogen schrijven.
            Als je toch jonger bent en écht op de Fontys zit, neem dan alsjeblieft contact met ons op!',
            'existing_application' => 'Er is al een inschrijving aanwezig met dezelfde PCN',
            'blocked'              => 'Je mag je niet inschrijven met deze gegevens'
        ],
        'email_confirmed'         => 'Inschrijving bevestigd',
        'thanks_for_confirming'   => 'Bedankt voor het bevestigen van je e-mailadres, :name. Je bent nu écht bijna klaar: Deel je overwinning met de rest van de wereld, en nogmaals van harte welkom bij de MediaMeiden!',
        'email_token_invalid'     => 'E-mailadres al bevestigd',
        'email_already_confirmed' => 'De link die je hebt gevolgd is (niet) meer geldig. Geen nood: Het is heel waarschijnlijk dat je dus al eens deze link hebt gevolgd en hij daarom niet meer geldig is. Als je op deze pagina bent beland nadat je op een link in een van onze e-mails hebt geklikt, hoef je je geen zorgen te maken.',

        // Betalingen
        'payment'                 => [
            'description' => 'Contributie MediaMeiden, ledenpas voor :first_name :last_name',
            'failed'      => 'Er is iets misgegaan tijdens het verwerken van de transactie. De betaling is mogelijk geannuleerd of verlopen. Probeer het nogmaals'
        ],
        'transaction_id'          => 'Transactie-ID',
        'transaction_amount'      => 'Bedrag transactie',

        'redirecting'              => 'Je wordt zo doorgestuurd...',
        'redirecting_instructions' => 'Je wordt nu naar onze betalingsprovider Mollie doorgestuurd, om de contributie aan ons te betalen. Als je dit hebt gedaan wordt de inschrijving automatisch bevestigd. Indien je de betaling annuleert zal de inschrijving verwijderd worden.',

        // Na de betaling

        'completed'          => 'Inschrijving verzonden',
        'email_instructions' => 'Bedankt voor het aanmelden voor MediaMeiden! Controleer je email om je inschrijving te bevestigen, anders is deze ongeldig! Mocht je de email niet krijgen binnen 2 werkdagen, kijk dan in je map voor ongewenste email of neem contact met ons op.',
    ];
