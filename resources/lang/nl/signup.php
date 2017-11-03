<?php
    return [
        'title'           => 'Inschrijven',
        'pcn'             => 'Fontys PCN',
        'name'            => 'Voor- en achternaam',
        'address'         => 'Straat en huisnummer',
        'city'            => 'Woonplaats',
        'postal_code'     => 'Postcode (1234AB)',
        'birthday'        => 'Geboortedatum',
        'birthday_format' => 'dd/mm/jjjj (' . \Carbon\Carbon::now()->format(trans('datetime.format.date')) . ')',
        'phone' => 'Telefoonnummer',
        'email' => 'E-mail-adres',
        'email_confirmation' => 'Bevestig je e-mail-adres',

        'errors' => [
            'minimum_age_not_met' => 'Je moet minstens 16 jaar oud zijn om jezelf in te mogen schrijven'
        ]
    ];