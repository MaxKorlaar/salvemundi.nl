<?php

    use Carbon\Carbon;

    return [
        'main_info_button' => 'Algemene informatie',
        'schedule_button'  => 'Planning',
        'sign_up_button'   => 'Inschrijven',
        'info'             => [/** @deprecated */
                               'closed_warning'    => 'Helaas is het niet meer mogelijk om je hier in te schrijven voor de introductie van MediaMeiden. Voor vragen kan je altijd contact opnemen met onze introcommissie: <a href="mailto:intro@mediameiden.korlaar.net">intro@mediameiden.korlaar.net</a>.',
                               'title'             => 'Inschrijven intro FHICT 2019',
                               'dates'             => '26 tot en met 30 augustus',
                               'click_to_sign_up'  => 'Klik hier om je in te schrijven',
                               'students_only'     => 'Deze pagina is bedoeld voor deelnemers, en niet voor begeleiding!',
                               'intro'             => [
                                   '<h4>Hallo nieuwe studenten!</h4>',
                                   'Dit jaar zal er tijdens de introductieweek de mogelijkheid zijn om te blijven overnachten. Wij vanuit MediaMeiden zijn druk bezig geweest om dit mogelijk te maken voor de nieuwe studenten. Om hier gebruik van te maken vragen wij een relatief kleine vergoeding. Nieuwe aanmeldingen dienen direct de contributie te betalen bij het verzenden van het inschrijfformulier. Hiervoor vragen wij een bedrag van 60 euro + 20 euro borg voor de slaapkamer. Na afloop krijg je deze 20 euro weer terug. De prijs is lager omdat onze school een lekkere bijdrage doet in de intro. Voor deze maximaal 60 euro krijg je: 2 nachten met vervoer van en naar de slaaplocatie, eten, een festival en veel meer. '
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
                                   'Wil jij ook graag je introductie extra leuk maken en lijkt het je leuk om je nieuwe studiegenoten alvast te leren kennen? Twijfel dan niet en meld je aan voor het introductiekamp dat plaatsvindt van 26 augustus tot en met 30 augustus!'
                               ],
                               'supervisor_signup' => 'Ook dit jaar zoeken we weer naar leden van MediaMeiden om mee te doen als intropapa of -mama! Het is dan ook <a href="' . route('intro.supervisor_info') . '">mogelijk om je aan te melden</a> als begeleider voor de intro van 2018.'

        ],
        'signup'           => [
            'title'                        => 'Inschrijven voor de intro van FHICT :year',
            'description'                  => 'De FHICT introductie is de leukste manier om je medestudenten te leren kennen. Op de website van studievereniging MediaMeiden is het mogelijk om je in te schrijven voor de introductie van dit jaar. Doe je dit, dan kom je een week lang in contact met je nieuwe studie, de studenten en de stad Eindhoven! Studievereniging MediaMeiden organiseert de introductie van Fontys Hogescholen ICT.',
            'signup_text'                  => 'Om de introductie te bekostigen vragen wij een bijdrage. Om je inschrijving te bevestigen, dien je direct na het invullen van dit formulier te betalen. Hiervoor vragen wij een bedrag van €:costs. Het is handig om jezelf zo snel mogelijk in te schrijven, er zijn namelijk slechts 200 plekken beschikbaar van de 550 studenten voor de opleiding FHICT. Indien je jezelf achteraf toch af wilt melden, doe dit dan zo snel mogelijk door <a href="https://wa.me/31636142514" target="_blank">ons een WhatsApp-berichtje te sturen</a> of een e-mail te sturen naar <a href="mailto:intro@mediameiden.korlaar.net">intro@mediameiden.korlaar.net</a>. Zo kunnen we alle beschikbare plekken opvullen met enthousiaste studenten!',
            'signup_full_warning'          => 'Alle beschikbare plekken van deze introductie zijn helaas al bezet. Je kan je wel nog aanmelden voor de reservelijst, waardoor je de mogelijkheid om te betalen alsnog krijgt mocht er een plek beschikbaar komen.',
            'signup_full_reservation_text' => '<b>Momenteel zijn alle beschikbare plekken bezet. Je kan je daarom alleen nog maar aanmelden voor de reservelijst.</b> Om de introductie te bekostigen vragen wij een bijdrage. Momenteel kan er alleen ingeschreven worden en vanaf 1 juli zullen de betaalverzoeken verstuurd worden. Bij inschrijving na 1 juli moet er direct betaald worden om je inschrijving te bevestigen. Hiervoor vragen wij een bedrag van €:costs. Het is handig om jezelf zo snel mogelijk in te schrijven, er zijn namelijk slechts 200 plekken beschikbaar van de 550 studenten voor de opleiding FHICT. Indien je jezelf achteraf toch af wilt melden, doe dit dan zo snel mogelijk door <a href="https://wa.me/31636142514" target="_blank">ons een WhatsApp-berichtje te sturen</a> of een e-mail te sturen naar <a href="mailto:intro@mediameiden.korlaar.net">intro@mediameiden.korlaar.net</a>. Zo kunnen we alle beschikbare plekken opvullen met enthousiaste studenten!',
            'signup_full_text'             => 'Alle beschikbare plekken van deze introductie zijn helaas al bezet. Het is niet mogelijk om je nog aan te melden voor deze introductie, tenzij er plekken beschikbaar komen.',
            'reservation_text'             => 'Om de introductie te bekostigen vragen wij een bijdrage. Momenteel kan er alleen ingeschreven worden en vanaf 1 juli zullen de betaalverzoeken verstuurd worden. Bij inschrijving na 1 juli moet er direct betaald worden om je inschrijving te bevestigen. Hiervoor vragen wij een bedrag van €:costs. Het is handig om jezelf zo snel mogelijk in te schrijven, er zijn namelijk slechts 200 plekken beschikbaar van de 550 studenten voor de opleiding FHICT. Indien je jezelf achteraf toch af wilt melden, doe dit dan zo snel mogelijk door <a href="https://wa.me/31636142514" target="_blank">ons een WhatsApp-berichtje te sturen</a> of een e-mail te sturen naar <a href="mailto:intro@mediameiden.korlaar.net">intro@mediameiden.korlaar.net</a>. Zo kunnen we alle beschikbare plekken opvullen met enthousiaste studenten!',
            'pcn'                          => 'Fontys PCN (Indien bekend)',
            'first_name'                   => 'Voornaam',
            'last_name'                    => 'Achternaam',
            'birthday'                     => 'Geboortedatum',
            'birthday_format'              => 'dd-mm-jjjj (' . Carbon::now()->format('d-m-Y') . ')',
            'address'                      => 'Straat en huisnummer',
            'city'                         => 'Woonplaats',
            'postal_code'                  => 'Postcode',
            'postal'                       => 'Postcode',
            'phone'                        => 'Telefoonnummer student',
            'contact_name'                 => 'Naam contactpersoon (in geval van nood)',
            'contact_relation'             => 'Relatie tot contactpersoon',
            'contact_phone'                => 'Telefoonnummer contactpersoon',
            'email'                        => 'E-mailadres',
            'email_confirmation'           => 'Bevestig je e-mailadres',
            'gender'                       => 'Geslacht',
            'genders'                      => ['Man', 'Vrouw', 'Anders'],
            'shirt_size'                   => 'Welke shirtmaat heb je? (Unisex)',
            'shirt_sizes'                  => [
                'S', 'M', 'L', 'XL', '2XL', '3XL'
            ],
            'alcohol'                      => 'Ik mag en wil alcohol nuttigen',
            'extra_shirt'                  => 'Ik wil graag een extra shirt aanschaffen (€9,-)',
            'same_sex_rooms'               => 'Ik vind het <strong>niet</strong> prettig om een kamer te delen met mensen van het andere geslacht',
            'same_sex_room'                => 'Je wordt altijd in een kamer ingedeeld met mensen van hetzelfde geslacht.',
            'allergies'                    => 'Allergieën',
            'allergies_placeholder'        => 'Heb je allergieën? Meld dit dan aan ons',
            'medication'                   => 'Medicijnen',
            'medication_placeholder'       => 'Maak je gebruik van medicijnen? Ook dit weten wij graag',
            'diet_preferences'             => 'Dieetwensen',
            'diet_preferences_placeholder' => 'Heb je speciale wensen voor het eten in verband met een dieet? Hier houden wij rekening mee',
            'remarks'                      => 'Opmerkingen',
            'remarks_placeholder'          => 'Overige opmerkingen',
            'agree_salvemundi'             => 'Ik ga akkoord met <a target="_blank" href="https://drive.google.com/uc?export=open&id=1ZGaXvr1_b0ToqtzQDqTl0YaGmoymvUpp">de voorwaarden van MediaMeiden</a> en de <a target="_blank" href="' . asset('storage/Intro huisregels.pdf') . '">intro huisregels van MediaMeiden</a>',
            'agree_buitenjan'              => 'Ik ga akkoord met <a target="_blank" href="' . asset('storage/Huisregels-Buitenjan.pdf') . '">de huisregels van De Buitenjan</a>',
            'transaction_id'               => 'Betalingskenmerk',
            'transaction_amount'           => 'Bedrag transactie',

            'privacy_terms_signup'                  => 'Door op \'Schrijf me in\' te klikken ga je akkoord met de opslag en verwerking van je persoonsgegevens volgens ons <a href="' . route('privacy') . '" target="_blank">privacybeleid</a> en zal je worden doorgestuurd naar de betalingspagina. Het is hier mogelijk om met iDeal te betalen. Indien je de betaling annuleert zullen je gegevens direct worden verwijderd en gaat je inschrijving niet door. Het is dan mogelijk om je opnieuw in te schrijven.
De contributie van de intro kost €:costs.',
            'privacy_terms_reservation'             => 'Door op \'Schrijf me in\' te klikken ga je akkoord met de opslag en verwerking van je persoonsgegevens volgens ons <a href="' . route('privacy') . '" target="_blank">privacybeleid</a>. Je zal later een betaalverzoek ontvangen voor €:costs, waarmee je je reservering omzet in een geldige aanmelding.</b>',
            'privacy_terms_signup_full_reservation' => 'Door op \'Schrijf me in\' te klikken ga je akkoord met de opslag en verwerking van je persoonsgegevens volgens ons <a href="' . route('privacy') . '" target="_blank">privacybeleid</a>. Indien er een plek beschikbaar komt, zal je een betaalverzoek ontvangen voor €:costs, waarmee je je reservering omzet in een geldige aanmelding. Je gegevens zullen na de introductie worden verwijderd.</b>',

            'sign_up'            => 'Schrijf me in',
            'terms'              => 'Akkoord voorwaarden',
            'errors'             => [
                'agree_salvemundi'                => 'Je moet akkoord gaan met de voorwaarden van MediaMeiden',
                'agree_buitenjan'                 => 'Je moet akkoord gaan met algemene voorwaarden van De Buitenjan',
                'existing_application'            => 'Er is al een aanmelding verzonden met dit PCN. Neem contact op met intro@mediameiden.korlaar.net voor vragen.',
                'all_spots_taken_no_reservations' => 'Helaas zijn zojuist alle beschikbare plekken van deze introductie ingenomen. Het is niet mogelijk om alsnog een plek te reserveren in plaats van direct in te schrijven.'
            ],
            'completed'          => [
                'signup'      => 'Aanmelding bevestigd',
                'reservation' => 'Bijna klaar...'
            ],
            'email_instructions' => [
                'signup'      => 'Bedankt voor het aanmelden voor de intro van MediaMeiden! Je betaling wordt momenteel verwerkt in ons systeem, maar zodra deze succesvol is afgerond krijg je van ons een mailtje ter bevestiging. Mocht je de email niet krijgen binnen 2 werkdagen nadat de betaling is afgerond, kijk dan in je map voor ongewenste email of neem contact met ons op.',
                'reservation' => 'Je aanmelding is echter nog niet bevestigd! Om hem geldig te maken moet je eerst nog de instructies volgen in een e-mail we je zojuist hebben gestuurd. Je aanmelding komt niet bij ons binnen indien je hem niet bevestigt via deze e-mail. Heb je na 1 werkdag nog steeds geen e-mail ontvangen? Meld je dan opnieuw aan of neem anders direct contact met ons op door <a href="https://wa.me/31636142514" target="_blank">een WhatsApp-berichtje te sturen op +31 6 36142514</a> of door een e-mail te sturen naar <a href="mailto:intro@mediameiden.korlaar.net">intro@mediameiden.korlaar.net</a>.'
            ],

            'email_confirmed'       => 'Aanmelding introductie bevestigd',
            'thanks_for_confirming' => 'Bedankt voor het bevestigen van je e-mailadres, :name. Je aanmelding voor de intro van :year is gereserveerd bij ons.',
            'instructions'          => 'Verder ontvang je binnenkort via dit e-mailadres de nieuwsbrief. In deze nieuwsbrief staat alles wat je moet weten over de intro. Dus houd je mail goed in de gaten. Mocht je nog vragen of opmerkingen hebben dan kan je <a href="https://wa.me/31636142514" target="_blank">een WhatsApp-berichtje sturen op +31 6 36142514</a>, een e-mail sturen naar intro@mediameiden.korlaar.net of onze website (mediameiden.korlaar.net) bezoeken. Wij zien al uit naar een mooi feestje.',
            'sent_email'            => 'Deze gegevens staan ook in de e-mail die je zojuist hebt ontvangen, waardoor je op deze pagina terecht kwam.',

            'email_signups_not_allowed'      => 'Aanmelding niet gelukt',
            'email_signups_check_back_later' => 'Momenteel zijn alle plekken van deze introductie helaas bezet. Als er toch plekken beschikbaar komen, gebruik dan opnieuw deze link in de e-mail die je van ons hebt ontvangen. We kunnen helaas geen plek bieden aan alle reserveringen die we krijgen.',

            // Betalingen
            'payment'                        => [
                'description'             => 'Contributie Intro FHICT :year van MediaMeiden',
                'description_extra_shirt' => 'Contributie Intro FHICT :year + extra shirt van MediaMeiden',
                'failed'                  => 'Er is iets misgegaan tijdens het verwerken van de transactie. De betaling is mogelijk geannuleerd of verlopen. Probeer je nogmaals aan te melden',
                'failed_from_mail'        => 'Er is iets misgegaan tijdens het verwerken van de transactie. De betaling is mogelijk geannuleerd of verlopen. Probeer het nogmaals door opnieuw de link te volgen in de e-mail die je hebt ontvangen.'
            ],

            'redirecting'              => 'Je wordt zo doorgestuurd...',
            'redirecting_instructions' => 'Je wordt nu naar onze betalingsprovider Mollie doorgestuurd, om de contributie voor de intro aan ons te betalen. Als je dit hebt gedaan wordt de aanmelding automatisch bevestigd. Indien je de betaling annuleert zal de aanmelding verwijderd worden.',

        ],
        'supervisor'       => [
            'info'   => [
                'title'                   => 'Aanmelden voor de intro als intropapa of -mama',
                'description'             => 'Leden van studievereniging MediaMeiden krijgen de mogelijkheid om zich aan te melden als intro-ouder voor dit jaar! We stellen hier wel een aantal eisen aan. Zonder onze leden zou de introductie niet plaats kunnen vinden. Studievereniging MediaMeiden organiseert de introductie van Fontys Hogescholen ICT.',
                'supervisors_only'        => 'Deze pagina is bedoeld voor het inschrijven als papa of mama voor de intro. <a href="' . route('intro.signup') . '">Klik hier</a> om je in te schrijven als deelnemer',
                'content'                 => [
                    'Beste (aankomende) papa’s en mama’s,<br>
Voordat jullie het weten is het alweer tijd voor de meest geweldige week van jullie schoolcarrière.
Jazeker, want van 26 t/m 30 augustus staat de allergrootste, spectaculairste, en leukste introductie van
FHICT in de planning.',
                ],
                'what_to_expect'          => 'Wat kunnen jullie verwachten?',
                'expectations'            => [
                    '3 tot 5 dagen feesten, zweten en plezier!',
                    'Toegang tot Purple Festival',
                    'Mede MediaMeiden-leden leren kennen',
                    'Een generale repetitie voor je toekomstige vader- of moederschap'
                ],
                'what_do_we_expect'       => 'Wat verwachten wij van jullie?',
                'our_expectations'        => [
                    'Dat je een actief en gemotiveerd lid bent',
                    'Dat je verschillende diensten (nuchter) zult draaien',
                    'Actieve inzet tijdens de introductie',
                    'Energie voor 5 man',
                    'Begeleiding van je kiddo’s',
                    'Een kleine bijdrage van € 30,-'
                ],
                'routes_title'            => 'Routes',
                'three_routes'            => 'Net als vorig jaar zijn er dit jaar ook weer verschillende routes waar jij
als papa of mama voor kan kiezen. Omdat het aantal aanmeldingen
waarschijnlijk hoger zal zijn dan het aantal slaapplekken, zijn er de
volgende opties opgesteld:',
                'routes'                  => [
                    'Route A: 5 dagen (ma-vr) introductie inclusief slaapplek',
                    'Route B: 3 dagen (ma, wo, do) introductie exclusief slaapplek.
(zonder een bijdrage van € 30,-)',
                    'Route C: hierbij maakt het je niet uit welke route jij wil en word
je ingedeeld voor route A of B (waar plek is)'
                ],
                'more_content'            => [
                    'Het bovenste gelezen en nog niet afgeschrikt? Dan zoeken wij jou!
Wij zoeken de meest actieve, knotsgekke, maar ook
verantwoordelijke papa’s en mama’s die MediaMeiden te bieden heeft.',
                    'Hierbij hebben wij hopelijk genoeg informatie gegeven om jullie
klaar te stomen voor de introductie van 2019. Wij hopen iedereen te
zien in augustus. Tot dan!',
                    'Groetjes,<br>
De feestcommissie'
                ],
                'requirements_for_signup' => 'Voorwaarden voor inschrijving:',
                'requirements'            => [
                    'Je bent een actief lid van MediaMeiden in het bezit van een ledenpas met een lidmaatschap geldend tot september 2018;',
                    'Je bent tenminste 18 jaar of ouder;',
                    'Je kunt leiding geven, jezelf aan een planning houden, logisch nadenken en hebt respect voor de planning georganiseerd door de feestcommissie;',
                    'Tijdens de gehele intro, wanneer je actief bent als begeleider, zal je geen drugs gebruiken',
                    'Bij aanmelding wordt er van je verwacht dat je definitief vrij bent op de data 26 tot en met 30 augustus',
                    'Je motivatie binnen de opleiding is positief en zit tenminste in semester 2 wanneer de introductie plaatsvindt',
                    'Voor B-begeleiding, welke blijft slapen, geldt ook de 20 euro borg per persoon voor de kamer. Dit wordt gedaan om een snelle opruiming te garanderen op vrijdagochtend.'
                ],
                'for_questions'           => 'Mocht je vragen hebben, stuur dan gerust een e-mail naar <a href="mailto:intro@mediameiden.korlaar.net?subject=Vragen intro begeleiding">intro@mediameiden.korlaar.net</a>.',
                'click_to_sign_up'        => 'Klik hier om je in te schrijven als intropapa of -mama',
                'closed_warning'          => 'Aanmeldingen voor deze introductie zijn momenteel gesloten.',

            ],
            'signup' => [
                'title'                          => 'Aanmelden voor de intro als intropapa of -mama',
                'description'                    => 'Leden van studievereniging MediaMeiden krijgen de mogelijkheid om zich aan te melden als intro-ouder voor dit jaar! Zonder onze leden zou de introductie niet plaats kunnen vinden. Studievereniging MediaMeiden organiseert de introductie van Fontys Hogescholen ICT.',
                'instructions'                   => 'Niet alle selectievakjes zijn verplicht. Vink slechts aan wat van toepassing is voor jouw situatie.',
                'member_id'                      => 'Lidnummer (zoals te vinden op je ledenpas)',
                'first_name'                     => 'Voornaam',
                'last_name'                      => 'Achternaam',
                'phone'                          => 'Telefoonnummer',
                'city'                           => 'Woonplaats',
                'email'                          => 'E-mailadres',
                'email_confirmation'             => 'Bevestig e-mailadres',
                'age_at_intro'                   => 'Leeftijd te 26 augustus 2019',
                'shirt_size'                     => 'Welke shirtmaat heb je? (Unisex)',
                'shirt_sizes'                    => [
                    'S', 'M', 'L', 'XL', '2XL', '3XL'
                ],
                'preferred_partner_id'           => 'Lidnummer van gewenste partner (optioneel)',
                'remain_sober'                   => 'Ik vind het niet erg om op een ingedeelde avond nuchter te blijven',
                'drivers_license'                => 'Ik heb een geldig rijbewijs',
                'first_aid_license'              => 'Te 26 augustus bezit ik een actief EHBO brevet',
                'company_first_response_license' => 'Te 26 augustus bezit ik een actief BHV brevet',
                'first_response'                 => ['Ja', 'Nee', 'Daar heb ik wel behoefte aan'],
                'previous_years'                 => ['Kind', 'Ouder', 'Niet van toepassing'],
                'active_as'                      => ['Commissielid', 'Aanwezig bij activiteiten', 'Aanwezig bij feesten', 'Anders'],
                'routes'                         => ['A', 'B', 'C'],
                'gender'                         => 'Geslacht',
                'genders'                        => [
                    'Man', 'Vrouw', 'Anders'
                ],
                'motivation'                     => 'Motivatie',
                'motivation_placeholder'         => 'Korte motivatie waarom jij mee zou mogen als intro-ouder',
                'previously_participated_as'     => 'Voorgaande jaren meegedaan als',
                'active_in_association'          => 'Ik zet mij in voor MediaMeiden op de volgende manier',
                'active_as_other'                => 'Indien anders: Leg uit',
                'route'                          => 'Route :route',
                'route_type'                     => 'Route',
                'remarks'                        => 'Opmerkingen',
                'remarks_placeholder'            => 'Opmerkingen (Bijvoorbeeld allergie-informatie, medicijngebruik en eetwensen)',
                'agree_salvemundi'               => 'Ik ga akkoord met <a target="_blank" href="' . asset('storage/Intro huisregels.pdf') . '">de huisregels van de introductie</a>',
                'agree_intro_terms'              => 'Ik ga akkoord met <a target="_blank" href="' . route('intro.supervisor_info') . '">de voorwaarden gegeven op de informatiepagina</a> en heb alles goed doorgenomen',
                'privacy_terms'                  => 'Door op \'Aanmelden\' te klikken ga je akkoord met de opslag en verwerking van je persoonsgegevens volgens ons <a href="' . route('privacy') . '" target="_blank">privacybeleid</a>.',
                'sign_up'                        => 'Aanmelden',
                'completed'                      => 'Bijna klaar...',
                'email_instructions'             => 'Je aanmelding is echter nog niet bevestigd! Om hem geldig te maken moet je eerst nog de instructies volgen in een e-mail we je zojuist hebben gestuurd. Indien je niet je e-mailadres bevestigt, zal je aanmelding niet worden gecontroleerd. Heb je na 5 minuten nog steeds geen e-mail ontvangen? Meld je dan opnieuw aan of neem anders direct contact met ons op door <a href="https://wa.me/31636142514" target="_blank">een WhatsApp-berichtje te sturen op +31 6 36142514</a> of door een e-mail te sturen naar <a href="mailto:intro@mediameiden.korlaar.net">intro@mediameiden.korlaar.net</a>.',
                'email_confirmed'                => 'Aanmelding intro-begeleider :year bevestigd',
                'thanks_for_confirming'          => 'Bedankt voor het bevestigen van je e-mailadres, :name. Je aanmelding als papa of mama voor de intro van :year is bevestigd bij ons.',
                'email_info'                     => 'Mocht je nog vragen of opmerkingen hebben dan kan je <a href="https://wa.me/31636142514" target="_blank">een WhatsApp-berichtje sturen op +31 6 36142514</a>, een e-mail sturen naar intro@mediameiden.korlaar.net of onze website (mediameiden.korlaar.net) bezoeken. Wij zien al uit naar een mooi feestje.'
            ]
        ],
        '2019'             => [
            'title'         => 'Introductie FHICT :year',
            'info_page'     => [
                'title'       => 'Introductie FHICT :year',
                'description' => 'De FHICT introductie is de leukste manier om je medestudenten te leren kennen. Het is een week vol avontuur en teambuilding in Eindhoven. Zo leer je ook de stad beter kennen. Wij vanuit MediaMeiden zijn druk bezig geweest om dit allemaal mogelijk te maken voor de nieuwe studenten. De introductie vindt plaats van maandag 26 augustus tot en met vrijdag 30 augustus. Houdt onze website en Facebook in de gaten voor updates! Studievereniging MediaMeiden organiseert de introductie van Fontys Hogescholen ICT.',
                'intro'       => [
                    'title' => 'Hallo nieuwe studenten!',
                    'text'  => "De FHICT introductie is de leukste manier om je medestudenten te leren kennen. Het is een week vol avontuur en teambuilding in Eindhoven. Zo leer je ook de stad beter kennen. Wij vanuit MediaMeiden zijn druk bezig geweest om dit allemaal mogelijk te maken voor de nieuwe studenten. De introductie vindt plaats van maandag 26 augustus tot en met vrijdag 30 augustus. Houdt onze website en Facebook in de gaten voor updates!",
                ],
                'information' => [
                    'title' => 'Algemene informatie',
                    'text'  => [
                        'Dit jaar bestaat de intro uit 5 dagen. De slaaplocatie is gemakkelijk te bereiken met het openbaar vervoer. Vanuit onze slaaplocatie worden tijdens de introductie touringcars ingezet om alle studenten bij de evenementen te krijgen. Slapen zal gebeuren in slaapzalen met stapelbedden. Naast het slapen is er een grote evenementenzaal met een bar waar zowel alcohol (18+) als frisdrank verkocht zal worden door middel van consumptiebonnen. De locatie zit bij een bosrand en een mooi open veld. Genoeg ruimte voor activiteiten dus.',
                        'Vanaf 16 februari gaan de onbetaalde inschrijvingen voor de introductie open. Dit betekent dat je je wel kan inschrijven om een plekje te reserveren, maar nog niet hoeft te betalen. Houd je mail goed in de gaten, vanaf 1 juli kun je de betaling voltooien en jezelf officieel inschrijven bij de introductie. Het afgelopen jaar duurde het 25 dagen voordat de introductie volledig was uitverkocht, ben er dus op tijd bij!'
                    ]
                ]
            ],
            'schedule_page' => [
                'title'       => 'Planning',
                'description' => 'De FHICT introductie is de leukste manier om je medestudenten te leren kennen. De introductie vindt plaats van maandag 26 augustus tot en met vrijdag 30 augustus. Op deze pagina is het mogelijk om een beknopte versie van de weekplanning te bekijken. Studievereniging MediaMeiden organiseert de introductie van Fontys Hogescholen ICT.',
                'days'        => [
                    'monday'    => [
                        'title' => 'Maandag',
                        'text'  => [
                            'Op maandag zullen jullie zelf naar de locatie komen door middel van het openbaar vervoer of gebracht worden. Er is helaas geen parkeerruimte om zelf met de auto te komen. Een auto of fiets zal tijdens de introductie ook niet nodig zijn, er wordt namelijk gebruik gemaakt van touringcars.',
                            'Na de incheck krijgt iedereen de tijd om zijn bed klaar te maken en spullen op te bergen. Na een goede maaltijd komen de bussen iedereen ophalen om naar het Stratumseind te gaan. Hier laten we jullie kennis maken met onze stamkroeg Villa Fiesta. Tijdens deze week mogen jullie mee genieten van de korting die wij als MediaMeiden bij Villa Fiesta krijgen.'
                        ]
                    ],
                    'tuesday'   => [
                        'title' => 'Dinsdag',
                        'text'  => [
                            'Na de eerste dag worden we wakker en krijgen we een stevig ontbijt. Om iedereen goed wakker te maken bestaat de ochtend uit teambuilding. Hierbij zullen jullie in groepen verdeeld worden en leuke buiten/bos activiteiten gaan doen om elkaar beter te leren kennen. De dinsdagmiddag is verder een vrij rustige middag. De energie wordt bespaard voor de woensdag en de donderdag.',
                            'Het programma speelt zich af op onze slaaplocatie en hier gaan we deze dag ook niet weg. Verder kun je activiteiten zoals een pubquiz en karaokeavond verwachten. Het eten wordt ook weer door ons verzorgd.'
                        ]
                    ],
                    'wednesday' => [
                        'title'   => 'Woensdag',
                        'youtube' => 'https://www.youtube-nocookie.com/embed/L-eHV0h-iqc',
                        'text'    => [
                            'Op woensdag gaan we ‘s ochtends naar de Rachelsmolen campus. Hier zullen jullie voor het eerst met je klas voor het eerste semester samen zijn (alle studenten moeten hierbij aanwezig zijn). Ook ontmoeten alle studenten hier zijn/haar Slb’ers (Studie Loopbaan Begeleiders).',
                            'Woensdagmiddag gaat weer door in het thema van teambuilding, maar vooral het verkennen van Eindhoven en de kortingen welke wij presenteren namens MediaMeiden. Hierna heeft Fontys een feest georganiseerd op het Stadhuisplein, gevolgd door een feest op het Stratumseind. Tot slot wordt er nog een afterparty op onze slaaplocatie gegeven, waarbij de feestbeesten dus nog door kunnen gaan, maar de wat rustigere niet verplicht zijn om mee te feesten.'
                        ]
                    ],
                    'thursday'  => [
                        'title' => 'Donderdag',
                        'text'  => [
                            'Op donderdag kunt je een klein beetje uitslapen om bij te komen van de zware woensdagavond. Wederom wordt er voor een ontbijt gezorgd. Daarna zullen de touringcars vertrekken naar Purple Festival. Purple wordt georganiseerd door Fontys en is speciaal voor alle studenten van Fontys. De entreeprijs hiervoor zit inbegrepen bij de inschrijving. Hiervoor hoeven alleen mogelijke consumpties afgerekend te worden. Tot slot om de introductie af te sluiten geven we nog een laatste feest voor de studenten die niet gestopt kunnen worden.'
                        ]
                    ],
                    'friday'    => [
                        'title' => 'Vrijdag',
                        'text'  => [
                            'Op de vrijdag ochtend moeten we al vroeg uit de veren. Iedereen moet meehelpen met opruimen zodat we op de locatie nog een jaartje langer terug mogen komen. Hierna is het terrein goed bereikbaar, en rijden er genoeg bussen om iedereen weer netjes thuis te krijgen.',
                            'Let op! Deze planning is een momentopname. Wegens omstandigheden kan deze aangepast worden. Studenten die zich hebben ingeschreven zullen hiervan op de hoogte worden gebracht.'
                        ]
                    ]
                ]
            ],
            'contact'       => [
                'title' => 'Contact',
                'text' => 'Als je vragen hebt over deze introductie of MediaMeiden, neem dan gerust contact met ons op door <a href="https://wa.me/31636142514" target="_blank">een WhatsApp-berichtje te sturen op +31 6 36142514</a> of door een e-mail te sturen naar <a href="mailto:intro@mediameiden.korlaar.net">intro@mediameiden.korlaar.net</a>.'
            ]
        ]
    ];