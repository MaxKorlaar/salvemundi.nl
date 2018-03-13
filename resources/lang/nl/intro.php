<?php
    return [
        'signup'     => [
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
            'remarks_placeholder'   => 'Opmerkingen (Bijvoorbeeld allergie-informatie of medicijngebruik)',
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
        ],
        'supervisor' => [
            'info'   => [
                'title'                   => 'Aanmelden voor de intro als intropapa of -mama',
                'supervisors_only'        => 'Deze pagina is bedoeld voor het inschrijven als papa of mama voor de intro. <a href="' . route('intro.signup') . '">Klik hier</a> om je in te schrijven als deelnemer',
                'content'                 => [
                    'Het heeft even geduurd, maar daar zijn we weer! De feestcommissie presenteert de nieuw en verbeterde intro. Dit intro is een pilot en een experiment, daarbij wordt hij groter en mooier als het voorgaande jaar. De hele intro is hartstikke leuk, maar zonder begeleiding komen we nergens. Daarom zoeken wij zoals het voorgaande jaar 42 geïnteresseerde papa\'s en mama\'s welke mee willen gaan.',
                    'Dit jaar bestaat de intro uit 2 delen. Het deel van vorig jaar, waar welke velen van jullie aan hebben mee gedaan of hebben begeleid, bestaat nog steeds net zoals het vorige jaar. Het verschil is dat er dit jaar een inschrijfmogelijkheid is voor 200 nieuwe studenten welke kunnen inschrijven voor de echte introductie. Deze introductie gaat op woensdagmiddag nadat de andere studenten klaar zijn door naar een slaaplocatie. Op deze slaaplocatie zal de echte introductie plaatsvinden, welke wij het introkamp hebben genoemd. '
                ],
                'three_routes'            => 'Als papa of mama kun je voor 3 routes kiezen;',
                'routes'                  => [
                    'Als papa/mama ben je welkom op de intro overdag, \'s avonds lig je in je eigen bed en ontmoet je de studenten de volgende dag \'s middags voor het festival.',
                    'Als papa/mama ben je welkom op de intro overdag, maar je gaat ook mee als begeleiding naar de overnachting. Hier zal je mee feesten maar ook mee helpen opruimen. De volgende dag ga je ook mee naar het festival. Afsluitend is er nog een derde dag om de slaaplocatie in orde te maken en er voor te zorgen dat de kinderen zich richting huis begeven.',
                    'Als papa/mama heb je geen voorkeur voor A of B: je bent flexibel en laat je door de feestcommissie inplannen waar nodig. (Dit geeft een hogere kans op toelating)'
                ],
                'more_content'            => [
                    'De introductie zal plaatsvinden op 22, 23 en 24 augustus. Een woensdag, donderdag en vrijdag. Het niveau is dit jaar wel drastisch anders. Er is dan ook een team nodig wat goed samenwerkt, en niet de agenda of planning van de feestcommissie in twijfel trekt. Dit jaar komen wij namens Salve Mundi dan ook verantwoordelijk te staan voor de planning, en wanneer mensen hiervan afwijken kunnen wij hier sancties op krijgen.',
                    'Het verschil tussen de hoeveelheid begeleiding nodig van A of B verschilt aan het aantal inschrijvingen wat we krijgen. Het introkamp gaat pas door bij een minimum van 100 inschrijvingen. Hierbij zijn er 20 B papa\'s of mama\'s nodig. Wanneer er 200 inschrijvingen zijn worden het er 40. Het kan dus zijn dat je gevraagd wordt om wat anders te doen dan wat je wens was. Er zal hierbij wel contact met je opgenomen worden',
                    '<u>De papa\'s en mama\'s worden gekozen door middel van loting.</u> Er zijn namelijk bepaalde factoren welke je kansen kunnen verbeteren, en of je een plek kunnen garanderen. Op het inschrijfformulier zijn bepaalde velden zoals: <i>In het bezit van een actief rijbewijs</i>, <i>ik vind het niet erg om een avond nuchter te blijven wanneer dit van mij gevraagd wordt</i> en <i>ik ben in bezit van een actief bhv/EHBO-brevet</i>. Tevens tellen recente activiteiten waarin leden buiten de feestcommissie de feestcommissie wel hebben geholpen (tijdens bijvoorbeeld de februari-intro) ook mee. Voor geen papa of mama zal een vergoeding volgen in de vorm van geld. Er zal wel op de slaaplocatie korting zijn op consumpties en nog meer.'
                ],
                'requirements_for_signup' => 'Voorwaarden voor inschrijving:',
                'requirements'            => [
                    'Je bent een actief lid van Salve Mundi in het bezit van een ledenpas met een lidmaatschap geldend tot september 2018;',
                    'Je bent tenminste 18 jaar of ouder;',
                    'Je kunt leiding geven, jezelf aan een planning houden, logisch nadenken en hebt respect voor de planning georganiseerd door de feestcommissie;',
                    'Tijdens de gehele intro, wanneer je actief bent als begeleider, zal je geen drugs gebruiken',
                    'Bij aanmelding wordt er van je verwacht dat je definitief vrij bent op de data 22, 23 en 24 augustus',
                    'Je motivatie binnen de opleiding is positief en zit tenminste in semester 2 wanneer de introductie plaatsvindt',
                    'Voor B-begeleiding welke blijft slapen geldt ook de 20 euro borg per persoon voor de kamer. Dit wordt gedaan om een snelle opruiming te garanderen vrijdagochtend.'
                ],
                'for_questions'           => 'Mocht je vragen hebben, stuur dan gerust een e-mail naar <a href="mailto:intro@salvemundi.nl?subject=Vragen intro begeleiding">intro@salvemundi.nl</a>.',
                'click_to_sign_up'        => 'Klik hier om je in te schrijven als intropapa of -mama'

            ],
            'signup' => [
                'title'              => 'Aanmelden voor de intro als intropapa of -mama',
                'instructions' => 'Niet alle selectievakjes zijn verplicht. Vink slechts aan wat van toepassing is voor jouw situatie.',
                'member_id' => 'Lidnummer (zoals te vinden op je ledenpas)',
                'first_name'         => 'Voornaam',
                'last_name'          => 'Achternaam',
                'phone'              => 'Telefoonnummer',
                'email'              => 'E-mail-adres',
                'email_confirmation' => 'Bevestig e-mail-adres',
                'age_at_intro'       => 'Leeftijd te 22 augustus 2018',
                'shirt_size'         => 'Welke shirtmaat heb je? (Unisex)',
                'shirt_sizes'        => [
                    'S', 'M', 'L', 'XL', '2X', '3X'
                ],
                'remain_sober' => 'Ik vind het niet erg om op een ingedeelde avond nuchter te blijven',
                'drivers_license' => 'Ik heb een geldig rijbewijs',
                'first_aid_license' => 'Te 22 augustus bezit ik een actief EHBO brevet',
                'company_first_response_license' => 'Te 22 augustus bezit ik een actief BHV brevet',
                'routes' => ['A', 'B', 'C'],
                'genders' => [
                    'Papa',
                    'Mama'
                ],
                'route_type' => 'Route :route',
                'remarks' => 'Opmerkingen',
                'remarks_placeholder' => 'Opmerkingen (Bijvoorbeeld allergie-informatie, medicijngebruik en eetwensen)',
                'agree_salvemundi' => 'Ik ga akkoord met <a target="_blank" href="#">de introductie-voorwaarden</a> (bestand todo)',
                'agree_intro_terms' => 'Ik ga akkoord met <a target="_blank" href="' . route('intro.supervisor_info') . '">de voorwaarden gegeven op de informatiepagina</a> en heb alles goed doorgenomen',
                'sign_up' => 'Aanmelden'
            ]
        ]
    ];