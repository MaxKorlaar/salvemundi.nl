<?php
    return [
        'title'           => 'Inschrijven',
        'pcn'             => 'Fontys PCN',
        'name'            => 'Voor- en achternaam',
        'address'         => 'Straat en huisnummer',
        'city'            => 'Woonplaats',
        'postal_code'     => 'Postcode (1234AB)',
        'birthday'        => 'Geboortedatum',
        'birthday_format' => 'dd-mm-jjjj (' . \Carbon\Carbon::now()->format('d-m-Y') . ')',
        'phone' => 'Telefoonnummer',
        'email' => 'E-mail-adres',
        'email_confirmation' => 'Bevestig je e-mail-adres',
        'please_confirm' => 'Controleer alsjeblieft de onderstaande gegevens voordat je de inschrijving verstuurt. Het kost ons extra tijd om fouten later te corrigeren.',
        'i_agree_terms' => 'Door op bevestigen te drukken ga je akkoord met de [algemene voorwaarden] van Salve Mundi.',
        'confirm' => 'Schrijf me in!',
        'errors' => [
            'minimum_age_not_met' => 'Je moet minstens 16 jaar oud zijn om jezelf in te mogen schrijven'
        ]
    ];