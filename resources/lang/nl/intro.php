<?php
    return [
        'info'       => [
            'closed_warning'    => 'Helaas is het niet meer mogelijk om je hier in te schrijven voor de introductie van Salve Mundi. Als je toch graag wil meedoen, meld je dan aan voor de reservelijst: Stuur een e-mail met je telefoonnummer naar <a href="mailto:intro@salvemundi.nl">intro@salvemundi.nl</a> om op de reservelijst te komen.',
            'title'             => 'Inschrijven Intro FHICT 2018',
            'dates'             => '22, 23 en 24 augustus 2018',
            'click_to_sign_up'  => 'Klik hier om je in te schrijven',
            'students_only'     => 'Deze pagina is bedoeld voor deelnemers, en niet voor begeleiding!',
            'intro'             => [
                '<h4>Hallo nieuwe studenten!</h4>',
                'Dit jaar zal er tijdens de introductieweek de mogelijkheid zijn om te blijven overnachten. Wij vanuit Salve Mundi zijn druk bezig geweest om dit mogelijk te maken voor de nieuwe studenten. Om hier gebruik van te maken vragen wij een relatief kleine vergoeding. Nieuwe aanmeldingen dienen direct de contributie te betalen bij het verzenden van het inschrijfformulier. Hiervoor vragen wij een bedrag van 60 euro + 20 euro borg voor de slaapkamer. Na afloop krijg je deze 20 euro weer terug. De prijs is lager omdat onze school een lekkere bijdrage doet in de intro. Voor deze maximaal 60 euro krijg je: 2 nachten met vervoer van en naar de slaaplocatie, eten, een festival en veel meer. '
            ],
            'content'           => [
                [
                    'Hoe ziet de slaaplocatie eruit?',
                    'Onze slaaplocatie is in Veldhoven. Wij zullen het vervoer regelen naar de slaaplocatie. Het pand heeft meerdere slaapruimtes waar stapelbedden staan. Je ligt hier met 4, 6 of 12 mensen op een kamer. Natuurlijk hebben we ook aan de versnaperingen gedacht, dus zal er een bar geplaatst worden en hebben we een feestzaal, waar we tot de late uurtjes door kunnen gaan. Drinken (fris en bier) kan middels consumptiemunten gehaald worden aan de bar. Deze munten zijn verkrijgbaar bij de muntenverkoop op de slaaplocatie.'
                ],
                [
                    'Wat gaan we allemaal doen?',
                    'Op woensdag worden jullie allemaal op school verwacht om kennis te maken met jullie nieuwe klas. Het is de bedoeling dat je dan alvast je overnachting spullen meeneemt en voorziet van een label met je naam. Wij zorgen er dan voor dat de spullen op de slaaplocatie aankomen.'
                ]
            ],
            'more_info'         => [
                'Tijdens deze eerste dag maken jullie kennis met jullie klasgenoten. Daarna zullen de papa’s en mama’s vanuit onze vereniging binnenkomen en nemen we jullie mee de stad in. We zullen tijdens de middag ons door Eindhoven begeven en is er natuurlijk een kans om een drankje te drinken in onze stamkroeg de Villa Fiësta. Na het middagprogramma zullen we ons met bussen begeven naar de slaaplocatie. Hier zal een kamerindeling gemaakt worden en wordt er friet met snacks gebakken. Hierna zullen we ons rustig aan begeven naar de feestzaal toe. In de feestzaal volgt een avond vol activiteiten, afsluitend met een feest.',
                'Donderdag zullen we op tijd weer wakker worden om gezamenlijk te ontbijten. Na het ontbijt gaan we met de bus weer terug naar Eindhoven om naar het Purple festival te gaan. Dit is een festival voor alle nieuwe studenten van alle opleidingen op Fontys Hogeschool. Na een middag vol feesten en dansen zullen we in de avond weer terug gaan naar de slaaplocatie. Hier zal de feestzaal weer geopend worden zodat we nog een mooi laatste feestje kunnen geven.',
                'Op vrijdag zullen we ook weer op tijd wakker worden om te gaan opruimen. Het is de bedoeling dat alle kamers worden geveegd en schoon worden achtergelaten door de studenten die hier geslapen hebben. Daarna zit de introductie erop en kan je op de slaaplocatie worden opgehaald of naar Eindhoven worden gebracht door onze bussen om daar te worden opgehaald.',
                'Wil jij ook graag je introductie extra leuk maken en lijkt het je leuk om je nieuwe studiegenoten alvast te leren kennen? Twijfel dan niet en meld je aan voor het introductiekamp dat plaatsvindt op 22, 23 en 24 augustus!'
            ],
            'supervisor_signup' => 'Ook dit jaar zoeken we weer naar leden van Salve Mundi om mee te doen als intropapa of -mama! Het is dan ook <a href="' . route('intro.supervisor_info') . '">mogelijk om je aan te melden</a> als begeleider voor de intro van 2018.'

        ],
        'signup'     => [
            'title'               => 'Inschrijven voor de FHICT intro van 2018',
            'text'                => 'Om de introductie te bekostigen vragen wij een contributie. Deze dient direct bij het verzenden van dit formulier aan voldaan te worden. Op 1 juli wordt er een betalingslink verstuurd naar de huidige deelnemers. Hiervoor vragen wij een bedrag van 60 euro + 20 euro borg voor de slaapkamer. Na afloop krijg je deze 20 euro weer terug. Wel is het handig om jezelf in te schrijven: Er zijn namelijk slechts 200 plekken voor de 550 inschrijvingen op de opleiding zelf. Het is dus belangrijk om je hier aan te melden. Zorg ook dat je een e-mail stuurt naar <a href="mailto:intro@salvemundi.nl">intro@salvemundi.nl</a> wanneer je toch een andere opleiding gaat volgen en je jezelf dus wilt afmelden. Zo houden we het voor iedereen eerlijk!',
            'pcn'                 => 'Fontys PCN (Indien bekend)',
            'first_name'          => 'Voornaam',
            'last_name'           => 'Achternaam',
            'birthday'            => 'Geboortedatum',
            'birthday_format'     => 'dd-mm-jjjj (' . \Carbon\Carbon::now()->format('d-m-Y') . ')',
            'address'             => 'Straat en huisnummer',
            'city'                => 'Woonplaats',
            'postal_code'         => 'Postcode',
            'postal'              => 'Postcode',
            'phone'               => 'Telefoonnummer student',
            'contact_phone'       => 'Telefoonnummer contactpersoon (in geval van nood)',
            'email'               => 'E-mail-adres',
            'email_confirmation'  => 'Bevestig je e-mail-adres',
            'gender'              => 'Geslacht',
            'genders'             => ['Man', 'Vrouw', 'Overige'],
            'shirt_size'          => 'Welke shirtmaat heb je? (Unisex)',
            'shirt_sizes'         => [
                'S', 'M', 'L', 'XL', '2XL', '3XL'
            ],
            'alcohol'             => 'Ik mag en wil alcohol nuttigen',
            'extra_shirt'         => 'Ik wil graag een extra shirt aanschaffen (€9,-)',
            'same_sex_rooms'      => 'Ik vind het <strong>niet</strong> prettig om een kamer te delen met mensen van het andere geslacht',
            'same_sex_room'       => 'Je wordt altijd in een kamer ingedeeld met mensen van hetzelfde geslacht.',
            'remarks'             => 'Opmerkingen',
            'remarks_placeholder' => 'Opmerkingen (Bijvoorbeeld allergie-informatie of medicijngebruik)',
            'agree_salvemundi'    => 'Ik ga akkoord met <a target="_blank" href="https://drive.google.com/uc?export=open&id=1ZGaXvr1_b0ToqtzQDqTl0YaGmoymvUpp">de voorwaarden van Salve Mundi</a> en de <a target="_blank" href="' . asset('storage/Intro specifieke huisregels.pdf') . '">intro huisregels van Salve Mundi</a>',
            'agree_buitenjan'     => 'Ik ga akkoord met <a target="_blank" href="' . asset('storage/Huisregels-Buitenjan.pdf') . '">de huisregels van De Buitenjan</a>',
            'transaction_id'      => 'Betalingskenmerk',
            'transaction_amount'  => 'Bedrag transactie',

            'privacy_terms' => 'Door op \'Schrijf me in\' te klikken ga je akkoord met de opslag en verwerking van je persoonsgegevens volgens ons <a href="' . route('privacy') . '" target="_blank">privacybeleid</a> en zal je worden doorgestuurd naar de betalingspagina. Het is hier mogelijk om met iDeal te betalen. Indien je de betaling annuleert zullen je gegevens direct worden verwijderd en gaat je inschrijving niet door. Het is dan mogelijk om je opnieuw in te schrijven.
De contributie van de intro kost 60 euro. Hierbij komt ook 20 euro borg voor de overnachting. Voor de betaling dient er dan ook in totaal <b>80 euro</b> betaald te worden. <b>De 20 euro borg wordt na afloop van de intro terugbetaald.</b>

',

            'sign_up'                  => 'Schrijf me in',
            'terms'                    => 'Akkoord voorwaarden',
            'errors'                   => [
                'agree_salvemundi'     => 'Je moet akkoord gaan met de voorwaarden van Salve Mundi',
                'agree_buitenjan'      => 'Je moet akkoord gaan met algemene voorwaarden van De Buitenjan',
                'existing_application' => 'Er is al een aanmelding verzonden met dit PCN. Neem contact op met intro@salvemundi.nl voor vragen.'
            ],
            //            'completed' => 'Bijna klaar...',
            'completed'                => 'Aanmelding bevestigd',
            //            'email_instructions'       => 'Je aanmelding is echter nog niet bevestigd! Om hem geldig te maken moet je eerst nog de instructies volgen in een e-mail we je zojuist hebben gestuurd. Je aanmelding komt niet bij ons binnen indien je hem niet bevestigt via deze e-mail. Heb je na 5 minuten nog steeds geen e-mail ontvangen? Meld je dan opnieuw aan of neem anders direct contact met ons op door een e-mail te sturen naar intro@salvemundi.nl.',
            'email_instructions'       => 'Bedankt voor het aanmelden voor de intro van Salve Mundi! Je betaling wordt momenteel verwerkt in ons systeem, maar zodra deze succesvol is afgerond krijg je van ons een mailtje ter bevestiging. Mocht je de email niet krijgen binnen 2 werkdagen nadat de betaling is afgerond, kijk dan in je map voor ongewenste email of neem contact met ons op.',
            'email_confirmed'          => 'Aanmelding intro 2018 bevestigd',
            'thanks_for_confirming'    => 'Bedankt voor het bevestigen van je e-mail-adres, :name. Je aanmelding voor de intro van 2018 is gereserveerd bij ons.',
            'instructions'             => 'Verder ontvang je binnenkort via dit e-mail-adres de nieuwsbrief. In deze nieuwsbrief staat alles wat je moet weten over de intro. Dus houd je mail goed in de gaten. Mocht je nog vragen of opmerkingen hebben dan kan je een e-mail sturen naar intro@salvemundi.nl of onze website (salvemundi.nl) bezoeken. Wij zien al uit naar een mooi feestje.',
            'sent_email'               => 'Deze gegevens staan ook in de e-mail die je zojuist hebt ontvangen, waardoor je op deze pagina terecht kwam.',
            // Betalingen
            'payment'                  => [
                'description'             => 'Contributie Intro FHICT 2018 van Salve Mundi',
                'description_extra_shirt' => 'Contributie Intro FHICT 2018 + extra shirt van Salve Mundi',
                'failed'                  => 'Er is iets misgegaan tijdens het verwerken van de transactie. De betaling is mogelijk geannuleerd of verlopen. Probeer je nogmaals aan te melden',
                'failed_from_mail'        => 'Er is iets misgegaan tijdens het verwerken van de transactie. De betaling is mogelijk geannuleerd of verlopen. Probeer het nogmaals door opnieuw de link te volgen in de e-mail die je hebt ontvangen.'
            ],
            //            'email_instructions'       => 'Bedankt voor je aanmelding voor het kamp! Je betaling wordt momenteel verwerkt in ons systeem, maar zodra deze succesvol is afgerond krijg je van ons automatisch een mailtje ter bevestiging. Dit gebeurt normaalgesproken automatisch binnen een paar minuten. Hopelijk tot ziens op de intro!',
            'redirecting'              => 'Je wordt zo doorgestuurd...',
            'redirecting_instructions' => 'Je wordt nu naar onze betalingsprovider Mollie doorgestuurd, om de contributie voor de intro aan ons te betalen. Als je dit hebt gedaan wordt de aanmelding automatisch bevestigd. Indien je de betaling annuleert zal de aanmelding verwijderd worden.',

        ],
        'supervisor' => [
            'info'   => [
                'title'                   => 'Aanmelden voor de intro als intropapa of -mama',
                'supervisors_only'        => 'Deze pagina is bedoeld voor het inschrijven als papa of mama voor de intro. <a href="' . route('intro.signup') . '">Klik hier</a> om je in te schrijven als deelnemer',
                'content'                 => [
                    'Het heeft even geduurd, maar daar zijn we weer! De feestcommissie presenteert de nieuwe en verbeterde intro. Deze intro is een pilot en een experiment, daarbij wordt hij groter en mooier dan het voorgaande jaar. De hele intro is hartstikke leuk, maar zonder begeleiding komen we nergens. Daarom zoeken wij zoals het voorgaande jaar 42 geïnteresseerde papa\'s en mama\'s die mee willen gaan.',
                    'Dit jaar bestaat de intro uit 2 delen. Het deel van vorig jaar, waar velen van jullie aan hebben mee gedaan of hebben begeleid, bestaat nog steeds net zoals het vorige jaar. Het verschil is dat er dit jaar een inschrijfmogelijkheid is voor 200 nieuwe studenten die zich  kunnen inschrijven voor de echte introductie. Deze introductie gaat op woensdagmiddag, nadat de andere studenten klaar zijn, door naar een slaaplocatie. Op deze slaaplocatie zal de echte introductie plaatsvinden, die wij het introkamp hebben genoemd.'
                ],
                'three_routes'            => 'Als papa of mama kun je voor 3 routes kiezen;',
                'routes'                  => [
                    'Als papa/mama ben je welkom op de intro overdag, \'s avonds lig je in je eigen bed en ontmoet je de studenten de volgende dag \'s middags voor het festival.',
                    'Als papa/mama ben je welkom op de intro overdag, maar je gaat ook mee als begeleiding naar de overnachting. Hier zal je mee feesten maar ook mee helpen opruimen. De volgende dag ga je ook mee naar het festival. Afsluitend is er nog een derde dag om de slaaplocatie in orde te maken en er voor te zorgen dat de kinderen zich richting huis begeven.',
                    'Als papa/mama heb je geen voorkeur voor A of B: je bent flexibel en laat je door de feestcommissie inplannen waar nodig. (Dit geeft een hogere kans op toelating)'
                ],
                'more_content'            => [
                    'De introductie zal plaatsvinden op 22, 23 en 24 augustus. Een woensdag, donderdag en vrijdag. Het niveau is dit jaar wel drastisch anders. Er is dan ook een team nodig dat goed samenwerkt en niet de agenda of planning van de feestcommissie in twijfel trekt. Dit jaar komen wij namens Salve Mundi dan ook verantwoordelijk te staan voor de planningen wanneer mensen hiervan afwijken kunnen wij hier sancties op krijgen.',
                    'Het verschil tussen de hoeveelheid begeleiding nodig van A of B verschilt aan het aantal inschrijvingen dat we krijgen. Het introkamp gaat pas door bij een minimum van 100 inschrijvingen. Hierbij zijn er 20 B papa\'s of mama\'s nodig. Wanneer er 200 inschrijvingen zijn worden het er 40. Het kan dus zijn dat je gevraagd wordt om wat anders te doen dan dat je wens was. Wij zullen dan wel contact met je opnemen.',
                    '<u>De papa\'s en mama\'s worden gekozen door middel van loting.</u> Er zijn namelijk bepaalde factoren welke je kansen kunnen verbeteren en of je een plek kunnen garanderen. Op het inschrijfformulier zijn bepaalde velden zoals: <i>In het bezit van een actief rijbewijs</i>, <i>ik vind het niet erg om een avond nuchter te blijven wanneer dit van mij gevraagd wordt</i> en <i>ik ben in bezit van een actief bhv/EHBO-brevet</i>. Tevens tellen recente activiteiten waarin leden buiten de feestcommissie de feestcommissie wel hebben geholpen (tijdens bijvoorbeeld de februari-intro) ook mee. Voor geen papa of mama zal een vergoeding volgen in de vorm van geld. Er zal wel op de slaaplocatie korting zijn op consumpties en nog meer.'
                ],
                'requirements_for_signup' => 'Voorwaarden voor inschrijving:',
                'requirements'            => [
                    'Je bent een actief lid van Salve Mundi in het bezit van een ledenpas met een lidmaatschap geldend tot september 2018;',
                    'Je bent tenminste 18 jaar of ouder;',
                    'Je kunt leiding geven, jezelf aan een planning houden, logisch nadenken en hebt respect voor de planning georganiseerd door de feestcommissie;',
                    'Tijdens de gehele intro, wanneer je actief bent als begeleider, zal je geen drugs gebruiken',
                    'Bij aanmelding wordt er van je verwacht dat je definitief vrij bent op de data 22, 23 en 24 augustus',
                    'Je motivatie binnen de opleiding is positief en zit tenminste in semester 2 wanneer de introductie plaatsvindt',
                    'Voor B-begeleiding, welke blijft slapen, geldt ook de 20 euro borg per persoon voor de kamer. Dit wordt gedaan om een snelle opruiming te garanderen op vrijdagochtend.'
                ],
                'for_questions'           => 'Mocht je vragen hebben, stuur dan gerust een e-mail naar <a href="mailto:intro@salvemundi.nl?subject=Vragen intro begeleiding">intro@salvemundi.nl</a>.',
                'click_to_sign_up'        => 'Klik hier om je in te schrijven als intropapa of -mama'

            ],
            'signup' => [
                'title'                          => 'Aanmelden voor de intro als intropapa of -mama',
                'instructions'                   => 'Niet alle selectievakjes zijn verplicht. Vink slechts aan wat van toepassing is voor jouw situatie.',
                'member_id'                      => 'Lidnummer (zoals te vinden op je ledenpas)',
                'first_name'                     => 'Voornaam',
                'last_name'                      => 'Achternaam',
                'phone'                          => 'Telefoonnummer',
                'email'                          => 'E-mail-adres',
                'email_confirmation'             => 'Bevestig e-mail-adres',
                'age_at_intro'                   => 'Leeftijd te 22 augustus 2018',
                'shirt_size'                     => 'Welke shirtmaat heb je? (Unisex)',
                'shirt_sizes'                    => [
                    'S', 'M', 'L', 'XL', '2XL', '3XL'
                ],
                'preferred_partner_id'           => 'Lidnummer van gewenste partner (optioneel)',
                'remain_sober'                   => 'Ik vind het niet erg om op een ingedeelde avond nuchter te blijven',
                'drivers_license'                => 'Ik heb een geldig rijbewijs',
                'first_aid_license'              => 'Te 22 augustus bezit ik een actief EHBO brevet',
                'company_first_response_license' => 'Te 22 augustus bezit ik een actief BHV brevet',
                'routes'                         => ['A', 'B', 'C'],
                'genders'                        => [
                    'Papa',
                    'Mama'
                ],
                'route'                          => 'Route :route',
                'route_type'                     => 'Papa/mama type (route)',
                'remarks'                        => 'Opmerkingen',
                'remarks_placeholder'            => 'Opmerkingen (Bijvoorbeeld allergie-informatie, medicijngebruik en eetwensen)',
                'agree_salvemundi'               => 'Ik ga akkoord met <a target="_blank" href="' . asset('storage/Intro specifieke huisregels.pdf') . '">de introductie-voorwaarden</a>',
                'agree_intro_terms'              => 'Ik ga akkoord met <a target="_blank" href="' . route('intro.supervisor_info') . '">de voorwaarden gegeven op de informatiepagina</a> en heb alles goed doorgenomen',
                'privacy_terms'                  => 'Door op \'Aanmelden\' te klikken ga je akkoord met de opslag en verwerking van je persoonsgegevens volgens ons <a href="' . route('privacy') . '" target="_blank">privacybeleid</a>.',
                'sign_up'                        => 'Aanmelden',
                'completed'                      => 'Bijna klaar...',
                'email_instructions'             => 'Je aanmelding is echter nog niet bevestigd! Om hem geldig te maken moet je eerst nog de instructies volgen in een e-mail we je zojuist hebben gestuurd. Indien je niet je e-mail-adres bevestigt, zal je aanmelding niet worden gecontroleerd. Heb je na 5 minuten nog steeds geen e-mail ontvangen? Meld je dan opnieuw aan of neem anders direct contact met ons op door een e-mail te sturen naar intro@salvemundi.nl',
                'email_confirmed'                => 'Aanmelding intro-begeleider 2018 bevestigd',
                'thanks_for_confirming'          => 'Bedankt voor het bevestigen van je e-mail-adres, :name. Je aanmelding als papa of mama voor de intro van 2018 is bevestigd bij ons.',
                'email_info'                     => 'We zullen nog contact met je opnemen indien je meedoet als begeleider. We kunnen namelijk maar een beperkt aantal intro-ouders mee laten doen met de intro van 2018. Mocht je nog vragen of opmerkingen hebben dan kan je een e-mail sturen naar intro@salvemundi.nl of onze website (salvemundi.nl) bezoeken. Wij zien al uit naar een mooi feestje.'
            ]
        ],
        '2019' => [
            'info_page' => [
                'title' => 'Inschrijven Intro FHICT 2018',
                'intro' => [
                    'title' => 'Hallo nieuwe studenten!',
                    'text' => "De FHICT introductie is de leukste manier om je medestudenten te leren kennen. Het is een week vol avontuur en teambuilding in Eindhoven. Zo leer je ook de stad beter kennen. Wij vanuit Salve Mundi zijn druk bezig geweest om dit allemaal mogelijk te maken voor de nieuwe studenten. De introductie vindt plaats van maandag 26 augustus tot en met vrijdag 30 augustus. Houdt onze website en Facebook in de gaten voor updates!",
                ],
                'information' => [
                    'title' => 'Algemene informatie',
                    'text' => ' Dit jaar is de intro niet 3, maar 5 dagen! De slaaplocatie is in Mierlo. Het vervoer wordt geregeld door Salve Mundi, dus daar hoef je je niet druk om te maken. Er zijn verschillende kamers waar je met een aantal mensen kunt slapen. Ook is er een feestzaal waar een bar staat, zodat we tot in de late uurtjes door kunnen gaan. Er wordt gebruik gemaakt van consumptiebonnen voor drinken (fris, bier en wijn). De volledige planning is te vinden onder ‘planning’, maar hier is al een kleine impressie. Op maandag word je verwacht op school. ’s Avonds gaan we naar onze stam kroeg Villa Fiesta op Stratumseind. Dinsdag zijn we de hele dag op onze slaaplocatie waar verschillende activiteiten zijn. Woensdag gaan we de stad in voor het beruchte crazy 88,ja waarna we naar het stadhuisplein gaan, nog even naar Villa Fiesta en afsluiten op de slaaplocatie met een afterparty. Donderdag is pruple festival en gooien we nog een afterparty op de slaaplocatie. Vrijdag ruimen we met z’n allen op en kunnen we na een hele week gezelligheid naar huis.'
                ]
            ]
        ]
    ];