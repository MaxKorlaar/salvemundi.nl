<?php
    return [
        'signup' => [
            'title'               => 'Aanmelden voor het kamp',
            'text'                => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec felis velit, suscipit eu urna vel, sollicitudin volutpat tellus. In turpis arcu, bibendum et erat in, tincidunt gravida massa. Aliquam nec dapibus neque, in sodales lorem. Aliquam diam dolor, fringilla eget vulputate et, fermentum ac diam. Vestibulum egestas, enim eu egestas pulvinar, lorem nibh malesuada augue, in volutpat quam augue at sem. Proin in arcu enim. Maecenas consequat nibh maximus fringilla gravida. Curabitur posuere, massa nec fringilla sagittis, sem turpis dapibus neque, nec feugiat risus sapien in sem. De kosten voor deelname aan het kamp bedragen momenteel €35,-.',
            'pcn'                 => 'Fontys PCN',
            'first_name'          => 'Voornaam',
            'last_name'           => 'Achternaam',
            'address'             => 'Straat en huisnummer',
            'city'                => 'Woonplaats',
            'postal_code'         => 'Postcode',
            'postal'              => 'Postcode',
            'birthday'            => 'Geboortedatum',
            'birthday_format'     => 'dd-mm-jjjj (' . \Carbon\Carbon::now()->format('d-m-Y') . ')',
            'phone'               => 'Telefoonnummer',
            'email'               => 'E-mail-adres',
            'email_confirmation'  => 'Bevestig je e-mail-adres',
            'agree_salvemundi'    => 'Ik ga akkoord met (TBD) <a href="https://drive.google.com/uc?export=open&id=1ZGaXvr1_b0ToqtzQDqTl0YaGmoymvUpp">de kampvoorwaarden van Salve Mundi</a>',
            'agree_buitenjan'     => 'Ik ga akkoord met (TBD) <a href="#?">de algemene voorwaarden van De Buitenjan</a>',
            'agree_terms'         => 'Door op \'Schrijf me in\' te drukken ga je akkoord met (tbd) <a href="https://drive.google.com/uc?export=open&id=1ZGaXvr1_b0ToqtzQDqTl0YaGmoymvUpp">de kampvoorwaarden van Salve Mundi</a>.',
            'remarks'             => 'Opmerkingen',
            'remarks_placeholder' => 'Dingen die wij moeten weten of opmerkingen over allergieën, ziektes, medicijnen en/of dieetwensen. Laat leeg indien niet van toepassing',
            'sign_up'             => 'Schrijf me in',
            'terms'               => 'Akkoord voorwaarden',
            'errors'              => [
                'agree_salvemundi'     => 'Je moet akkoord gaan met de kampvoorwaarden van Salve Mundi',
                'agree_buitenjan'      => 'Je moet akkoord gaan met algemene voorwaarden van De Buitenjan',
                'existing_application' => 'Er is al een aanmelding verzonden met dit PCN'
            ],
            'payment' => [
              'description' => 'De deelnamekosten voor het kamp van Salve Mundi voor :first_name :last_name',
              'failed' => 'Er is iets misgegaan tijdens de transactie. De betaling is mogelijk geannuleerd of verlopen. Probeer het nogmaals'
            ],

            'redirecting'              => 'Je wordt zo doorgestuurd...',
            'redirecting_instructions' => 'Je wordt nu naar onze betalingsprovider Mollie doorgestuurd om de kosten voor de deelname aan het kamp te betalen. Als je dit hebt gedaan wordt de inschrijving automatisch bevestigd.',

            'completed'             => 'Aanmelding verzonden',
            'email_instructions'    => 'Bedankt voor je aanmelding voor het kamp! Je betaling wordt momenteel verwerkt in ons systeem, maar zodra deze succesvol is afgerond krijg je van ons een mailtje ter bevestiging. Hopelijk tot ziens op het kamp!',
            'email_confirmed'       => 'Aanmelding kamp bevestigd',
            'thanks_for_confirming' => 'Bedankt voor het bevestigen van je e-mail-adres, :name. Je aanmelding voor het kamp is nu ook automatisch bevestigd bij ons.',
            'instructions'          => 'Om mee te doen aan het kamp is het nodig om contributie te betalen. Je dient <b>€35,-</b> over te maken op rekeningnummer <b>NL97 RABO 0326 3418 11</b> t.n.v. <b>s.v. Salve Mundi</b> onder vermelding van het volgende kenmerk in de omschrijving: <b>:id</b>.'
        ]
    ];