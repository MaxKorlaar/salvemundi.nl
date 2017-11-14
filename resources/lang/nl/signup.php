<?php
    return [
        'title'              => 'Aanmelden',
        'pcn'                => 'Fontys PCN',
        'name'               => 'Voor- en achternaam',
        'address'            => 'Straat en huisnummer',
        'city'               => 'Woonplaats',
        'postal_code'        => 'Postcode (1234AB)',
        'birthday'           => 'Geboortedatum',
        'birthday_format'    => 'dd-mm-jjjj (' . \Carbon\Carbon::now()->format('d-m-Y') . ')',
        'phone'              => 'Telefoonnummer',
        'email'              => 'E-mail-adres',
        'email_confirmation' => 'Bevestig je e-mail-adres',
        'sign_up'            => 'Versturen',
        'please_confirm'     => 'Controleer alsjeblieft de onderstaande gegevens voordat je de inschrijving verstuurt. Het kost ons extra tijd om fouten later te corrigeren.',
        'i_agree_terms'      => 'Door op bevestigen te drukken ga je akkoord met de [algemene voorwaarden] van Salve Mundi.',
        'confirm'            => 'Schrijf me in!',
        'completed'          => 'Inschrijving verzonden',
        'email_instructions' => 'Je inschrijving is echter nog niet compleet! Om hem geldig moet je eerst nog de instructies volgen in een email die je zojuist hebt ontvangen.
        Hiermee kan je je email-adres bevestigen en worden we op de hoogte gesteld van jouw inschrijving!
        Mocht je de email echt niet kunnen vinden, kijk dan in je map voor ongewenste email of neem contact met ons op.',
        'errors'             => [
            'minimum_age_not_met'  => 'Je moet minstens 16 jaar oud zijn om jezelf in te mogen schrijven',
            'existing_application' => 'Er is al een inschrijving aanwezig met dezelfde PCN',
            'blocked'              => 'Je mag je niet inschrijven met deze gegevens'
        ]
    ];