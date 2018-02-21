<?php
    return [
        'signup' => [
            'title'                 => 'Aanmelden voor de intro van 2018',
            'text'                  => 'Het is mogelijk om je als aankomend student in te schrijven voor de intro van 2018. Deze wordt georganiseerd door Salve Mundi, de studievereniging van FHICT in Eindhoven.',
            'pcn'                   => 'Fontys PCN (Indien bekend)',
            'first_name'            => 'Voornaam',
            'last_name'             => 'Achternaam',
            'birthday'              => 'Geboortedatum',
            'birthday_format'       => 'dd-mm-jjjj (' . \Carbon\Carbon::now()->format('d-m-Y') . ')',
            'phone'                 => 'Telefoonnummer',
            'email'                 => 'E-mail-adres',
            'email_confirmation'    => 'Bevestig je e-mail-adres',
            'shirt_size'            => 'Welke shirtmaat heb je? (Unisex)',
            'shirt_sizes'           => [
                'S', 'M', 'L', 'XL', '2X', '3X'
            ],
            'alcohol'               => 'Ik mag en wil alcohol nuttigen',
            'extra_shirt'           => 'Ik wil graag een extra shirt aanschaffen (€9,-)',
            'same_sex_rooms'        => 'Ik vind het <strong>niet</strong> prettig om een kamer te delen met mensen van het andere geslacht',
            'remarks'               => 'Opmerkingen',
            'remarks_placeholder'   => 'Opmerkingen (Bijvoorbeeld allergie-informatie)',
            'agree_salvemundi'      => 'Ik ga akkoord met <a href="https://drive.google.com/uc?export=open&id=1ZGaXvr1_b0ToqtzQDqTl0YaGmoymvUpp">de voorwaarden van Salve Mundi</a>',
            'agree_buitenjan'       => 'Ik ga akkoord met (TBD) <a href="#?">de algemene voorwaarden van De Buitenjan</a>',
            'transaction_id'        => 'Betalingskenmerk',
            'sign_up'               => 'Schrijf me in',
            'terms'                 => 'Akkoord voorwaarden',
            'errors'                => [
                'agree_salvemundi'     => 'Je moet akkoord gaan met de voorwaarden van Salve Mundi',
                'agree_buitenjan'      => 'Je moet akkoord gaan met algemene voorwaarden van De Buitenjan',
                'existing_application' => 'Er is al een aanmelding verzonden met dit PCN. Neem contact op met info@salvemundi.nl voor vragen.'
            ],
            'completed'             => 'Aanmelding verzonden',
            'email_instructions'    => 'Je aanmelding is echter nog niet bevestigd! Om hem geldig te maken moet je eerst nog de instructies volgen in een email die je zojuist hebt ontvangen.',
            'email_confirmed'       => 'Aanmelding intro 2018 bevestigd',
            'thanks_for_confirming' => 'Bedankt voor het bevestigen van je e-mail-adres, :name. Je aanmelding voor de intro van 2018 is bevestigd bij ons.',
            'instructions'          => 'Je bent nu bijna klaar. Om mee te doen aan de intro is het nodig om contributie te betalen. Je dient <b>€:amount</b> over te maken op rekeningnummer <b>NL97 RABO 0326 3418 11</b> t.n.v. <b>s.v. Salve Mundi</b> onder vermelding van het volgende kenmerk in de omschrijving: <b>:id</b>.',
            'sent_email'            => 'Deze gegevens staan ook in de email die je zojuist hebt ontvangen, waardoor je op deze pagina terecht kwam.',
        ]
    ];