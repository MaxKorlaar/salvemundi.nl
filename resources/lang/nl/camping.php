<?php
    return [
        'signup' => [
            'title'               => 'Aanmelden voor het kamp',
            'questions' => [
              [
                  'Wat is het Salve Mundi Kamp?',
                  'Goede vraag! Het Salve Mundi Kamp is een kamp georganiseerd door studievereniging Salve Mundi voor haar leden.'
              ],
              [
                  'Wanneer vindt dit kamp plaats?',
                  'Het kamp begint op vrijdag 6 april, en duurt tot zondagmiddag 8 april. De exacte vertrektijd en locatie ontvang je later per e-mail.'
              ],
              [
                  'Dat is zeker niet gratis?',
                  'Nee, helaas niet. Je betaalt slechts €' . number_format(config('mollie.camping_costs'), 2, ',', '.') .' voor het hele weekend. Dit is "all-inclusive". Dit houdt in dat je voor €' . number_format(config('mollie.camping_costs'), 2, ',', '.') . ' het hele weekend kan genieten van de activiteiten, gratis eten krijgt en ook gratis mag drinken. En om de brandende vraag gelijk maar te beantwoorden, ja, dat houd ook in onbeperkt bier. Meer bier de man!'
              ],
              [
                  'Hoe komen we op de kamplocatie?',
                  'Met een oude, in de tijd verloren, techniek genaamd "de fiets". We zullen op de fiets vertrekken vanaf Fontys R1 en fietsen naar onze kamplocatie met tussendoor een aantal tussenstops. Ga je zelf een andere vorm van vervoer regelen, laat het dan wel op tijd weten!'
              ],
              [
                  'Maar wat moet ik dan meenemen?',
                  'Nou, dingen zoals: Slaapkleding, slaapzak, regen/sport-kleding, normale kleding, toiletspullen, handdoeken, kussens, schoenen, puzzelboekjes, zaklamp, knuffelbeesten en niet te vergeten je bikini!'
              ],
              [
                  'Ik heb medicijnen / allergieën / ben een vegetariër, hoe gaan jullie hier mee om?',
                  'In het geval van medicijnen / allergieën dien je dit tijdens je inschrijving aan te geven. Meld ons welke vorm van medicijnen je slikt, hoe vaak en wanneer op de dag je deze slikt. En in geval van nood met wie we contact op moeten nemen.'
              ],
              [
                  'Waar moet ik rekening mee houden?',
                  'Hou er rekening mee dat je niet te veel waardevolle spullen meeneemt. Salve Mundi is niet verantwoordelijk voor schade, diefstal en andere vormen van kwalen op je eigendom.'
              ],
              [
                  'Wat mag ik niet meenemen?',
                  'Geen elektronische apparatuur naast je telefoon en een zaklamp. Daarnaast geen gevaarlijke voorwerpen zoals zakmessen, vuurwapens, explosieven, hakbijlen, kettingzagen, kernreactoren etc. Vormen van drugs zijn ook niet toegestaan. De kampleiding mag objecten waarvan zij vinden dat deze gevaarlijk of schadelijk zijn tijdelijk in beslag nemen.'
              ]
            ],
            'text'                => 'Verdere informatie krijg je geruime tijd van te voren in je mail. Voor meer informatie over het kamp kan je het ook de <a href="' . route('home') . '#events">Facebook-pagina van het kamp</a> in de gaten houden.
            Het kamp wordt georganiseerd door onze eigen <a href="' . route('committees/camping') . '">kampcommissie</a> (natuurlijk). Mocht je nog vragen hebben over het kamp, neem dan gerust contact op met Wesley Ingenbleek op 0611191647.',
            'confirmed_signups' => 'Kampeerders',
            'pcn'                 => 'Fontys PCN',
            'id' => 'ID',
            'member_id'           => 'Lidnummer',
            'member_id_help'      => 'Heb je nog geen ledenpasje? Het is mogelijk om je lidnummer te vinden in <a href="https://docs.google.com/spreadsheets/d/1ivk5LjC_W1e_wy40OoVHUXYIC5V8L22TW7zXR0suc0o/edit?usp=sharing" target="_blank">de openbare ledenlijst</a>.',
            'first_name'          => 'Voornaam',
            'last_name'           => 'Achternaam',
            'address'             => 'Straat en huisnummer',
            'city'                => 'Woonplaats',
            'postal_code'         => 'Postcode',
            'postal'              => 'Postcode',
            'birthday'            => 'Geboortedatum',
            'birthday_format'     => 'dd-mm-jjjj (' . \Carbon\Carbon::now()->format('d-m-Y') . ')',
            'phone'               => 'Telefoonnummer',
            'transaction_id' => 'Transactie-ID',
            'email'               => 'E-mail-adres',
            'email_confirmation'  => 'Bevestig je e-mail-adres',
            'agree_salvemundi'    => 'Ik ga akkoord met (TBD) <a href="https://drive.google.com/uc?export=open&id=1ZGaXvr1_b0ToqtzQDqTl0YaGmoymvUpp">de kampvoorwaarden van Salve Mundi</a>',
            'agree_buitenjan'     => 'Ik ga akkoord met (TBD) <a href="#?">de algemene voorwaarden van De Buitenjan</a>',
            'agree_terms'         => 'Door op \'Schrijf me in\' te drukken geef je aan lid te zijn van studievereniging Salve Mundi, ga je akkoord met <a href="https://drive.google.com/uc?export=open&id=1ZGaXvr1_b0ToqtzQDqTl0YaGmoymvUpp" target="_blank">de huisregels van Salve Mundi</a> en dat je gegevens worden verwerkt volgens ons <a href="' . route('privacy') . '" target="_blank">privacybeleid</a>. Je zal dan automatisch worden doorgestuurd naar de betalingspagina, waar het mogelijk is om via iDeal te betalen. Indien de transactie niet succesvol is, zal je inschrijving automatisch worden verwijderd. Wanneer je inschrijving daadwerkelijk bevestigd is zal je hiervan een automatisch bericht ontvangen per email. Salve Mundi behoudt zich het recht om deelnemers zonder opgaaf van reden te weigeren.',
            'remarks'             => 'Opmerkingen',
            'remarks_placeholder' => 'Dingen die wij moeten weten of opmerkingen over allergieën, ziektes, medicijnen en/of dieetwensen. Laat leeg indien niet van toepassing',
            'sign_up'             => 'Schrijf me in',
            'terms'               => 'Akkoord voorwaarden',
            'errors'              => [
                'agree_salvemundi'     => 'Je moet akkoord gaan met de kampvoorwaarden van Salve Mundi',
                'agree_buitenjan'      => 'Je moet akkoord gaan met algemene voorwaarden van De Buitenjan',
                'existing_application' => 'Er is al een aanmelding verzonden met dit PCN',
                'minimum_age_not_met' => 'Sorry, maar je bent te jong om je in te mogen schrijven voor het kamp. Kloppen je gegevens wel? Neem anders contact met ons op.',
            ],
            'payment'             => [
                'description' => 'De deelnamekosten voor het kamp van Salve Mundi voor :first_name :last_name',
                'failed'      => 'Er is iets misgegaan tijdens het verwerken van de transactie. De betaling is mogelijk geannuleerd of verlopen. Probeer het nogmaals'
            ],

            'redirecting'              => 'Je wordt zo doorgestuurd...',
            'redirecting_instructions' => 'Je wordt nu naar onze betalingsprovider Mollie doorgestuurd om de kosten voor de deelname aan het kamp te betalen. Als je dit hebt gedaan wordt de inschrijving automatisch bevestigd.',

            'completed'             => 'Aanmelding verzonden',
            'email_instructions'    => 'Bedankt voor je aanmelding voor het kamp! Je betaling wordt momenteel verwerkt in ons systeem, maar zodra deze succesvol is afgerond krijg je van ons een mailtje ter bevestiging. Hopelijk tot ziens op het kamp!',
            'email_confirmed'       => 'Aanmelding kamp bevestigd',
            'thanks_for_confirming' => 'Bedankt voor het bevestigen van je e-mail-adres, :name. Je aanmelding voor het kamp is nu ook automatisch bevestigd bij ons.',
            //            'instructions'          => 'Om mee te doen aan het kamp is het nodig om contributie te betalen. Je dient <b>€35,-</b> over te maken op rekeningnummer <b>NL97 RABO 0326 3418 11</b> t.n.v. <b>s.v. Salve Mundi</b> onder vermelding van het volgende kenmerk in de omschrijving: <b>:id</b>.'
        ]
    ];