<?php
    return [
        'title'              => 'Aanmelden',
        'text'               => 'Om Salvemundi te bekostigen, vragen we een vergoeding van €20,- per jaar voor het lidmaatschap en een eenmalige vergoeding van €5,- voor de ledenpas.',
        'pcn'                => 'Fontys PCN',
        'first_name'         => 'Voornaam',
        'last_name'          => 'Achternaam',
        'address'            => 'Straat en huisnummer',
        'city'               => 'Woonplaats',
        'postal_code'        => 'Postcode',
        'postal'             => 'Postcode',
        'birthday'           => 'Geboortedatum',
        'birthday_format'    => 'dd-mm-jjjj (' . \Carbon\Carbon::now()->format('d-m-Y') . ')',
        'phone'              => 'Telefoonnummer',
        'email'              => 'E-mail-adres',
        'email_confirmation' => 'Bevestig je e-mail-adres',
        'picture'            => 'Pasfoto',
        'picture_help'       => 'Kies een pasfoto die op je ledenpasje komt te staan.
        Afbeeldingen mogen maximaal 5 MB groot zijn en moeten minimaal 200 bij 300 pixels groot zijn.',
        'sign_up'            => 'Versturen',
        'please_confirm'     => 'Controleer alsjeblieft de onderstaande gegevens voordat je de inschrijving verstuurt. Het kost ons extra tijd om fouten later te corrigeren.',
        'i_agree_terms'      => 'Door verder te gaan met je inschrijving ga je akkoord met de <a target="_blank" href="https://drive.google.com/uc?export=open&id=1ZGaXvr1_b0ToqtzQDqTl0YaGmoymvUpp">algemene voorwaarden</a> van Salve Mundi en ons <a href="' . route('privacy') . '" target="_blank">privacybeleid</a>.',
        'payment_redirect' => 'Door op \'Door naar betalen\' te klikken zullen je gegevens bewaard worden volgens ons <a href="' . route('privacy') . '" target="_blank">privacybeleid</a> en zal je worden doorgestuurd naar de betalingspagina. Het is hier mogelijk om met iDeal te betalen. Indien je de betaling annuleert zullen je gegevens direct worden verwijderd en gaat je inschrijving niet door. Het is dan mogelijk om je opnieuw in te schrijven.',
        'confirm'            => 'Door naar betalen',

        'errors'                => [
            'minimum_age_not_met'  => 'Je moet minstens 16 jaar oud zijn om jezelf in te mogen schrijven.
            Als je toch jonger bent en écht op de Fontys zit, neem dan alsjeblieft contact met ons op!',
            'existing_application' => 'Er is al een inschrijving aanwezig met dezelfde PCN',
            'blocked'              => 'Je mag je niet inschrijven met deze gegevens'
        ],
        'email_confirmed'       => 'Inschrijving bevestigd',
        'thanks_for_confirming' => 'Bedankt voor het bevestigen van je e-mail-adres, :name. Je bent nu écht bijna klaar:
        Het laatste wat we willen is dat je €25,- overmaakt naar NL97 RABO 0326 3418 11. Benoem hierbij je naam en PCN bij de beschrijving, dat maakt het voor ons overzichtelijker.',

        // Betalingen
        'payment'               => [
            'description' => 'Contributie Salve Mundi, ledenpas voor :first_name :last_name',
            'failed'      => 'Er is iets misgegaan tijdens de transactie. De betaling is mogelijk geannuleerd of verlopen. Probeer het nogmaals'
        ],
        'transaction_id'        => 'Transactie-ID',
        'transaction_amount'    => 'Bedrag transactie',

        'redirecting'              => 'Je wordt zo doorgestuurd...',
        'redirecting_instructions' => 'Je wordt nu naar onze betalingsprovider Mollie doorgestuurd, om de contributie aan ons te betalen. Als je dit hebt gedaan wordt de inschrijving automatisch bevestigd. Indien je de betaling annuleert zal de inschrijving verwijderd worden.',

        // Na de betaling

        'completed'          => 'Inschrijving verzonden',
        'email_instructions' => 'Bedankt voor het aanmelden voor Salve Mundi! Je betaling wordt momenteel verwerkt in ons systeem, maar zodra deze succesvol is afgerond krijg je van ons een mailtje ter bevestiging. Mocht je de email niet krijgen binnen 2 werkdagen nadat de betaling is afgerond, kijk dan in je map voor ongewenste email of neem contact met ons op.',
    ];