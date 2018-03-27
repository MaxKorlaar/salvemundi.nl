<?php
    return [
        'confirm_application'    => [
            'subject'      => 'Bevestig je inschrijving',
            'greeting'     => 'Hoi :name,',
            'instructions' => 'Om je inschrijving én email-adres bij Salve Mundi te bevestigen hoef je nu alleen nog maar op de link in dit bericht te klikken.
      Heb je deze email niet aangevraagd? Dan kan je hem gerust negeren.',
            'not_complete' => 'Je inschrijving is echter nog niet compleet. We willen graag dat je nog €25,- overmaakt naar NL97 RABO 0326 3418 11. Benoem hierbij je naam en PCN bij de beschrijving, dat maakt het voor ons overzichtelijker. ',
            'when_done'    => 'Als je dit allemaal hebt gedaan, ontvang je zo snel mogelijk je pasje.',
            'link'         => 'Bevestig je inschrijving',
        ],
        'new_member_application' => [
            'subject'    => 'Nieuwe inschrijving van :name',
            'greeting'   => 'Hallo bestuur,',
            'intro_text' => 'Er is een nieuwe aanmelding voor Salve Mundi ingezonden. De gebruiker heeft betaald voor de inschrijving. Meer informatie over de transactie kan gevonden worden op Mollie.com.',
            'sent_from'  => 'Deze aanmelding is verzonden vanaf :ip.',
        ],
        'signup'                 => [
            'payment_confirmation' => [
                'subject'      => 'Bedankt voor je inschrijving!',
                'greeting'     => 'Hoi :name,',
                'instructions' => 'Goed nieuws! We hebben zojuist je betaling ontvangen en dat betekent dat we automatisch je aanmelding hebben bevestigd. Welkom bij Salve Mundi!',
                'more_info'    => 'Dus ter bevestiging: We hebben zojuist 25 euro van je ontvangen en deze gekoppeld aan je aanmelding. Deze kosten bestaan uit 20 euro voor het lidmaatschap voor 1 jaar en 5 euro voor je ledenpas. Je zal nog van ons horen, maar wees niet bang om vragen te stellen aan ons door te mailen naar info@salvemundi.nl of door ons aan te spreken op school.'
            ],
        ],
        'camping'                => [
            'payment_confirmation' => [
                'subject'      => 'Bedankt voor je aanmelding!',
                'greeting'     => 'Hoi :name,',
                'instructions' => 'Goed nieuws! We hebben zojuist je betaling ontvangen en dat betekent dat we automatisch je aanmelding hebben bevestigd. Het lijkt er dus op dat je meegaat op kamp, gezellig!',
                'more_info'    => 'Dus ter bevestiging: We hebben zojuist ' . number_format(config('mollie.camping_costs'), 2, ',', '.') . ' euro van je ontvangen en deze gekoppeld aan je aanmelding. Je zal nog van ons horen, maar wees niet bang om vragen te stellen aan ons door te mailen naar kamp@salvemundi.nl of door ons aan te spreken op school. Blijf vooral ook de Facebook-pagina van het kamp in de gaten houden voor de laatste updates!'
            ],
            'new_application'      => [
                'subject'    => 'Nieuwe kamp-aanmelding van :name',
                'greeting'   => 'Hallo kampcommissie,',
                'intro_text' => 'Er is een nieuwe aanmelding voor het kamp ingezonden. De gebruiker heeft betaald.',
                'sent_from'  => 'Deze aanmelding is verzonden vanaf :ip.',
            ],
        ],

        'intro' => [
            'confirm_application'  => [
                'subject'      => 'Bevestig je inschrijving voor de intro',
                'greeting'     => 'Geachte :name,',
                'instructions' => 'Tof dat je je hebt aangemeld voor het introductiekamp 2018. Het belooft een fantastische introductie te worden. Tijdens deze introductie zal je kennismaken met je studiegenoten en met het echte studentenleven. Deze introductie is georganiseerd door Salve Mundi, de studievereniging van Fontys Hogescholen ICT.',
                'link'         => 'Bevestig je inschrijving',
                'when_done'    => 'LET OP: je aanmelding wordt pas definitief bevestigd wanneer je hebt betaald. Hiervoor is het eerst nodig om nu direct je e-mail-adres te bevestigen. Je kan rond juni een e-mail van ons verwachten waarin we je verzoeken om aan de betaling te voldoen. Na deze betaling hoef je geen verdere acties te ondernemen.'
            ],
            'new_application'      => [
                'subject'    => 'Nieuwe intro-inschrijving van :name',
                'greeting'   => 'Hallo bestuur,',
                'intro_text' => 'Er is een nieuwe aanmelding voor de intro ingezonden. De gebruiker heeft zijn/haar email-adres bevestigd.',
                'true'       => 'Ja',
                'false'      => 'Nee',
                'sent_from'  => 'Deze aanmelding is verzonden vanaf :ip.',
            ],
            'payment_confirmation' => [
                'subject'      => 'Bedankt voor je aanmelding!',
                'greeting'     => 'Hoi :name,',
                'instructions' => 'Goed nieuws! We hebben zojuist je betaling ontvangen en dat betekent dat we automatisch je aanmelding hebben bevestigd. Het lijkt er dus op dat je meedoet met de FHICT intro van 2018, georganiseerd door Salve Mundi!',
                'more_info'    => 'Dus ter bevestiging: We hebben zojuist :amount euro van je ontvangen en deze gekoppeld aan je aanmelding. Je zal nog van ons horen, maar wees niet bang om vragen te stellen aan ons door te mailen naar info@salvemundi.nl.'
            ],
            'supervisor' => [
                'confirm_application' => [
                    'subject'      => 'Bevestig je inschrijving als begeleider voor de intro',
                    'greeting'     => 'Geachte :name,',
                    'instructions' => 'Leuk dat je je hebt aangemeld als begeleider voor de intro van 2018. Het belooft een fantastische introductie te worden. Het is nodig om je inschrijving nog te bevestigen door te klikken op de link in deze e-mail.',
                    'link'         => 'Bevestig je inschrijving',
                    'when_done'    => 'We zullen nog contact met je opnemen indien je meedoet als begeleider. We kunnen namelijk maar een beperkt aantal intro-ouders mee laten doen met de intro van 2018.'
                ],
                'new_application' => [
                    'subject'    => 'Papa/mama-inschrijving voor de intro van :name',
                    'greeting'   => 'Hallo bestuur,',
                    'intro_text' => 'Er is een nieuwe aanmelding voor de intro als papa of mama ingezonden. De gebruiker heeft zijn/haar email-adres bevestigd.',
                    'true'       => 'Ja',
                    'false'      => 'Nee',
                    'sent_from'  => 'Deze aanmelding is verzonden vanaf :ip.',
                ],
            ]
        ],

        'signature'  => 'Met vriendelijke groet,
    s.v. Salve Mundi
    https://salvemundi.nl',
        'disclaimer' => 'Dit bericht is automatisch verzonden. Antwoorden is hierop niet mogelijk'
    ];