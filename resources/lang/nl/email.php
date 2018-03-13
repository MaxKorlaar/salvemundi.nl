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
        'signup' => [
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
            'new_application'     => [
                'subject'    => 'Nieuwe kamp-aanmelding van :name',
                'greeting'   => 'Hallo kampcommissie,',
                'intro_text' => 'Er is een nieuwe aanmelding voor het kamp ingezonden. De gebruiker heeft betaald.',
                'sent_from'  => 'Deze aanmelding is verzonden vanaf :ip.',
            ],
        ],

        'intro' => [
            'confirm_application' => [
                'subject'      => 'Bevestig je inschrijving voor de intro',
                'greeting'     => 'Hoi :name,',
                'instructions' => 'Om je inschrijving voor de intro van Salve Mundi te bevestigen hoef je nu alleen nog maar op de link in dit bericht te klikken. Heb je deze email niet aangevraagd? Dan kan je hem gerust negeren.',
                'link'         => 'Bevestig je inschrijving',
                'when_done'    => 'Bevestig je je inschrijving niet, dan krijgen we je gegevens niet binnen en word je <b>niet</b> ingeschreven voor de intro!'
            ],
            'new_application'     => [
                'subject'    => 'Nieuwe intro-inschrijving van :name',
                'greeting'   => 'Hallo bestuur,',
                'intro_text' => 'Er is een nieuwe aanmelding voor de intro ingezonden. Het email-adres van deze gebruiker is bevestigd.',
                'true'       => 'Ja',
                'false'      => 'Nee',
                'sent_from'  => 'Deze aanmelding is verzonden vanaf :ip.',
            ],
        ],

        'signature'  => 'Met vriendelijke groet,
       s.v. Salve Mundi
       info@salvemundi.nl',
        'disclaimer' => 'Dit bericht is automatisch verzonden. Antwoorden is hierop niet mogelijk'
    ];