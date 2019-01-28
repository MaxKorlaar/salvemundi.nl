<?php

    return [
        'nav'          => [
            'welcome'   => 'Welkom, :name',
            'log_out'   => 'Log uit',
            'version'   => '0.5.0',
            'load_time' => 'Laadtijd: :secondss',
            'credit'    => 'Verenigingadministratiesysteem door <a target="_blank" href="//maxkorlaar.nl">Max Korlaar</a>'
        ],
        'transactions' => [
            'id'                 => 'ID',
            'transaction_id'     => 'Transactie-id',
            'transaction_status' => 'Status',
            'status'             => [
                'paid'      => 'Betaald',
                'open'      => 'Betaling bezig',
                'cancelled' => 'Geannuleerd',
                'canceled'  => 'Geannuleerd',
                'failed'    => 'Betaling mislukt',
                'expired'   => 'Betaling verlopen',
                'refunded'  => 'Teruggestort',
                'n/a'       => 'Fout (status onbekend)',
            ],
            'transaction_amount' => 'Bedrag',
            'created_at'         => 'Aangemaakt op',
            'updated_at'         => 'Bijgewerkt op'
        ],

        'memberships' => [
            'id'                => 'ID',
            'transaction'       => 'Transactie',
            'no_transaction'    => 'Geen transactie gekoppeld',
            'valid_from'        => 'Geldig vanaf',
            'valid_until'       => 'Geldig tot',
            'created_at'        => 'Aangemaakt op',
            'create'            => [
                'title'  => 'Lidmaatschap aanmaken',
                'create' => 'Aanmaken'
            ],
            'create_membership' => 'Voeg lidmaatschap handmatig toe'
        ],
        'camping'     => [
            'title'          => 'Kamp',
            'id'             => 'ID',
            'camping_id'     => 'Kamp',
            'year'           => 'Jaar',
            'price'          => 'Prijs',
            'new'            => 'Nieuw kamp',
            'edit_camp'      => 'Kamp bewerken',
            'signups'        => 'Aanmeldingen',
            'signup_open'    => 'Inschrijvingen geopend',
            'signup_close'   => 'Inschrijvingen gesloten',
            'transaction'    => 'Transactie',
            'no_transaction' => 'Geen transactie gekoppeld',
            'created_at'     => 'Aangemaakt op',
            'updated_at'     => 'Bijgewerkt op',
            'details'        => 'Details',
            'count'          => ':count kamp|:count kampen',
            'member_count'   => ':count aanmelding|:count aanmeldingen',
            'show'           => [
                'title' => 'Kamp: :year'
            ],
            'edit'           => [
                'title' => 'Kamp bewerken: :year',
                'save'  => 'Opslaan',
                'back'  => 'Terug'
            ],
            'create'         => [
                'title'  => 'Kamp aanmaken',
                'create' => 'Aanmaken',
            ],
            'applications'   => [
                'title'          => 'Aanmeldingen',
                'id'             => 'ID',
                'member_name'    => 'Lid',
                'transaction'    => 'Transactie',
                'no_transaction' => 'Geen transactie gekoppeld',
                'created_at'     => 'Aangemaakt op',
                'updated_at'     => 'Bijgewerkt op',
            ]
        ],
        'members'     => [
            'title'                 => 'Ledenadministratie',
            'details'               => 'Details',
            'id'                    => 'ID',
            'leave_id_empty'        => 'Laat leeg om automatisch te genereren',
            'member_from'           => 'Lid sinds',
            'member_until'          => 'Lid tot',
            'member_id'             => 'Lidnummer',
            'edit_member'           => 'Gegevens bewerken',
            'delete_member'         => 'Lid verwijderen',
            'pcn'                   => 'PCN',
            'last_name'             => 'Achternaam',
            'first_name'            => 'Voornaam',
            'address'               => 'Adres',
            'city'                  => 'Woonplaats',
            'postal'                => 'Postcode',
            'country'               => 'Land',
            'none_given'            => 'Geen land opgegeven!',
            'birthday'              => 'Geboortedatum',
            'phone'                 => 'Telefoonnummer',
            'email'                 => 'E-mailadres',
            'transaction_id'        => 'Transactie-id',
            'transaction_amount'    => 'Bedrag transactie',
            'transaction_status'    => 'Transactie-status',
            'website_account'       => 'Websitegebruiker',
            'no_user'               => 'Geen account',
            'card'                  => 'Ledenpas',
            'delete_all_inactive'   => 'Verwijder alle inactieve leden',
            'view_spreadsheet'      => 'Bekijk spreadsheet',
            'temporary_card_number' => 'Tijdelijke pas',
            'card_status'           => [
                'received'      => 'In ontvangst genomen',
                'unprocessed'   => 'Nog niet verwerkt',
                'processed'     => 'Verwerkt',
                'not_picked_up' => 'Niet opgehaald',
                'no_card'       => 'Geen ledenpas'
            ],
            'import'                => [
                'import' => 'Importeren'
            ],
            'created_at'            => 'Aangemaakt op',
            'updated_at'            => 'Bijgewerkt op',
            'count'                 => ':count lid|:count leden',
            'new'                   => 'Nieuw lid',
            'transactions'          => 'Transacties',
            'memberships'           => 'Lidmaatschappen',
            'campings'              => 'Kampen',
            'orders'                => 'Bestellingen',
            'not_a_member'          => 'Dit lid heeft momenteel geen actief lidmaatschap',
            'no_valid_membership'   => 'Lidmaatschap verlopen',
            'email_invalid_members' => 'E-mail leden zonder lidmaatschap',
            'email_members'         => 'E-mail leden met lidmaatschap',
            'create'                => [
                'title'        => 'Nieuw lid',
                'create'       => 'Aanmaken',
                'picture_help' => 'Afbeelding mag maximaal 5 MB groot zijn.'
            ],
            'edit'                  => [
                'title'        => 'Lid bewerken',
                'edit'         => 'Opslaan',
                'picture_help' => 'Afbeelding mag maximaal 5 MB groot zijn en zal de vorige afbeelding overschrijven.'
            ],
            'delete'                => [
                'title'                 => 'Lid verwijderen',
                'are_you_sure'          => 'Weet je het zeker?',
                'delete'                => 'Lid verwijderen',
                'delete_inactive'       => 'Bovenstaande leden verwijderen',
                'inactive_confirmation' => 'Leden met een verlopen lidmaatschap verwijderen',
                'following_members'     => 'De volgende leden zullen worden verwijderd uit het ledensysteem. Hun gebruikersaccounts worden verwijderd en zij kunnen hierdoor niet meer inloggen. Dit betekent ook dat ze niet meer hun lidmaatschap kunnen verlengen. Hiervoor moet een lid op tijd worden hersteld of moet een lid zichzelf opnieuw inschrijven.',
                'inactive_deleted'      => ':count leden met een verlopen lidmaatschap zijn verwijderd'
            ],
            'send_email'            => [
                'title'                       => 'Leden mailen',
                'title_invalid'               => 'Leden met verlopen lidmaatschap mailen',
                'subject'                     => 'Onderwerp',
                'message_content_placeholder' => 'Typ hier je bericht. Het gebruik van HTML is toegestaan, al wordt het wel afgeraden. Berichten met minder opmaak hebben over het algemeen succes bij gebruikers: https://blog.chamaileon.io/choosing-between-plain-text-html-email/.',
                'content'                     => "Beste {voornaam},\n\n(Jouw bericht hier)",
                'help_text'                   => 'Het is mogelijk om de voor- en achternaam van de ontvanger in het bericht te plaatsen. Gebruik \'{voornaam}\' en \'{achternaam}\', deze zullen automatisch vervangen worden door de juiste naam.',
                'preview'                     => 'Bekijk voorbeeld van de e-mail',
                'send'                        => 'Stuur email naar :count leden',
                'email_sent'                  => 'E-mail verstuurd naar :members leden.'
            ]
        ],
        'intro'       => [
            'title'                  => 'Introducties',
            'generate_tokens'        => 'Genereer betaalverzoeken en verstuur ze per mail',
            'send_email_reminders'   => 'Stuur herinneringen naar onbevestigde email-adressen',
            'send_payment_reminders' => 'Stuur herinneringen naar aanmeldingen met betaalverzoek',
            'reminders_sent'         => 'Er is een herinnering gestuurd naar :count van de :unconfirmed_count onbevestigde email-adressen. Er werden alleen herinneringen gestuurd naar aanmeldingen die het laatst bijgewerkt zijn voor :date of een laatste herinnering kregen voor :date.',
            'payment_reminders_sent' => 'Er is een herinnering gestuurd naar :actual_count van de :count aanmeldingen die reeds een betaalverzoek hebben ontvangen. Er werden alleen herinneringen gestuurd naar aanmeldingen die het laatst bijgewerkt zijn voor :date of een laatste herinnering kregen voor :date.',
            'tokens_generated'       => 'Voor alle bevestigde e-mailadressen zonder betaalverzoeken zijn :count unieke betaalverzoeken gegenereerd en verstuurd per mail. Ik hoop dat je niet per ongeluk op de knop drukte want holy shit deze emails gaan we dus allemaal niet meer terugkrijgen en dan zijn we flink genaaid.',

            'id'                             => 'ID',
            'year'                           => 'Jaar',
            'price'                          => 'Prijs',
            'max_signups'                    => 'Aanmeldingslimiet',
            'allow_reservations_after_limit' => 'Sta reserveringen toe nadat het aanmeldingslimiet is bereikt',
            'allow_reservations_help'        => 'Indien het maximum aantal betaalde aanmeldingen is bereikt, is het mogelijk om studenten zich alsnog te laten inschrijven. Hun inschrijving wordt dan aangemeld als een reservering, en werkt hetzelfde als andere reserveringen.',
            'signups'                        => 'Aanmeldingen',
            'reservations_open'              => 'Reserveren vanaf',
            'mail_reservations'              => 'Stuur automatisch een e-mail met het verzoek om te betalen',
            'mail_reservations_help'         => 'Indien ingeschakeld zal er op de dag waarop het aanmelden mogelijk is om 09.00 een e-mail worden verstuurd naar alle studenten die een plek gereserveerd hebben voor deze introductie. Dit gebeurt eenmalig.',
            'signup_open'                    => 'Aanmelden vanaf',
            'signup_close'                   => 'Aanmelden tot',
            'created_at'                     => 'Gemaakt op',
            'updated_at'                     => 'Bijgewerkt op',
            'count'                          => ':count introductie|:count introducties',
            'yes'                            => 'Ja',
            'no'                             => 'Nee',
            'new'                            => 'Nieuwe introductie',
            'edit_introduction'              => 'Introductie bewerken',
            'anonymisation_warning'          => 'Let op: Alle aanmeldingen zullen automatisch worden geanonimiseerd 2 maanden na het verstrijken van de uiterlijke aanmelddatum. Dit kan niet worden uitgeschakeld.',
            'create'                         => [
                'title'  => 'Nieuwe introductie',
                'create' => 'Aanmaken'
            ],
            'show'                           => [
                'title' => 'Introductie :year'
            ],
            'edit'                           => [
                'title' => 'Introductie :year bewerken',
                'save'  => 'Opslaan',
                'back'  => 'Terug'
            ],
            'spreadsheet'                    => [
                'title' => 'Introductie :year spreadsheet'
            ],

            'applications' => [
                'title'                            => 'Aanmeldingen',
                'amount'                           => 'Aanmeldingen',
                'reservations_amount'              => 'Reserveringen',
                'confirmed_amount'                 => 'Betaalde aanmeldingen',
                'confirmed_percentage'             => 'Bereikt van :max_signups',
                'id'                               => 'ID',
                'status'                           => 'Status',
                'transaction'                      => 'Transactie',
                'status_paid'                      => 'Betaald',
                'status_reserved'                  => 'Niet betaald/Gereserveerd',
                'status_email_unconfirmed'         => 'E-mail niet bevestigd',
                'status_see_transaction'           => 'Zie transactie',
                'status_refunded'                  => 'Teruggestort',
                'no_mail'                          => 'Geen betaalverzoek',
                'last_name'                        => 'Achternaam',
                'first_name'                       => 'Voornaam',
                'pcn'                              => 'PCN',
                'birthday'                         => 'Geboortedatum',
                'address'                          => 'Straat en huisnummer',
                'city'                             => 'Woonplaats',
                'postal'                           => 'Postcode',
                'phone'                            => 'Telefoonnummer student',
                'contact_phone'                    => 'Telefoonnummer contactpersoon',
                'email'                            => 'E-mailadres',
                'gender'                           => 'Geslacht',
                'shirt_size'                       => 'Shirtmaat (Unisex)',
                'same_sex_rooms'                   => 'Kamer delen met alleen zelfde geslacht',
                'created_at'                       => 'Aangemaakt op',
                'updated_at'                       => 'Bijgewerkt op',
                'remarks'                          => 'Opmerkingen',
                'internal_transaction_id'          => 'Transactie-ID (intern)',
                'transaction_status'               => 'Transactiestatus',
                'transaction_id'                   => 'Transactie-ID',
                'transaction_amount'               => 'Bedrag transactie',
                'details'                          => 'Details',
                'delete_application'               => 'Aanmelding verwijderen',
                'not_applicable'                   => 'n.v.t.',
                'cannot_send_mails_right_now'      => 'Het is momenteel niet mogelijk om e-mails te sturen naar :first_name :last_name, aangezien de aanmelding al een bevestigd e-mailadres heeft of reeds een betaling heeft voltooid.',
                'cannot_send_mails_signups_closed' => 'Het is niet mogelijk om een betaalverzoek te sturen naar :first_name :last_name, aangezien de uiterlijke aanmelddatum van deze introductie verstreken is.',
                'cannot_send_mails_signups_full'   => 'Het is niet mogelijk om een betaalverzoek te sturen naar :first_name :last_name, aangezien het aanmeldingslimiet van deze introductie bereikt is. Transacties die momenteel verwerkt worden tellen ook voor het aanmeldingslimiet.',
                'count'                            => ':count aanmelding|:count aanmeldingen, waarvan :confirmed betaald zijn en :email_unconfirmed geen bevestigd email-adres hebben',
                'back_to_index'                    => 'Terug naar overzicht',
                'view_spreadsheet'                 => 'Bekijk spreadsheet',
                'delete'                           => [
                    'are_you_sure' => 'Weet je zeker dat je deze aanmelding wil verwijderen? Dit kan <b>niet</b> ongedaan worden gemaakt. Alle gegevens gerelateerd aan deze aanmelding zullen onherstelbaar worden verwijderd. Mocht deze aanmelding gekoppeld zijn aan een Mollie-betaling, dan zal deze betaling blijven bestaan in Mollie.',
                    'delete'       => 'Verwijder aanmelding permanent',
                    'deleted'      => 'De aanmelding is permanent verwijderd uit het systeem'
                ]
            ]

        ],
        'store'       => [
            'orders' => [
                'id'             => 'ID',
                'current_status' => 'Status',
                'transaction'    => 'Transactie',
                'created_at'     => 'Aangemaakt op',
                'no_transaction' => 'Geen transactie (handmatig)',
                'status'         => [
                    'see_transaction' => 'Zie transactie',
                    'open'            => 'Open'
                ]
            ],
            'items'  => [
                'title'       => 'Winkel-items',
                'id'          => 'ID',
                'name'        => 'Naam',
                'description' => 'Beschrijving',
                'in_stock'    => 'Op voorraad',
                'created_at'  => 'Aangemaakt op',
                'new'         => 'Nieuw item',
                'details'     => 'Details',
                'create'      => [
                    'title'  => 'Item aanmaken',
                    'create' => 'Opslaan'
                ],
                'edit'        => [
                    'save'   => 'Opslaan',
                    'title'  => 'Item bewerken: :name',
                    'delete' => 'Item verwijderen'
                ],
                'delete'      => [
                    'title'        => ':item verwijderen',
                    'are_you_sure' => 'Weet je zeker dat je dit item wil verwijderen? Dit kan niet ongedaan worden gemaakt.',
                    'delete'       => 'Permanent verwijderen'
                ],
                'stock'       => [
                    'title'                => 'Voorraad',
                    'id'                   => 'ID',
                    'name'                 => 'Naam',
                    'name_variant'         => 'Naam/Variant/Versie',
                    'price'                => 'Prijs',
                    'description'          => 'Beschrijving',
                    'description_optional' => 'Beschrijving (optioneel)',
                    'in_stock'             => 'Voorraad',
                    'images'               => 'Afbeeldingen',
                    'images_multiple'      => 'Afbeeldingen (meerdere toegestaan)',
                    'details'              => 'Bewerken',
                    'new'                  => 'Nieuwe voorraad',
                    'create'               => [
                        'title'  => 'Voorraad aanmaken voor :item',
                        'create' => 'Opslaan'
                    ],
                    'edit'                 => [
                        'title'  => 'Voorraad bewerken voor :item',
                        'save'   => 'Opslaan',
                        'delete' => 'Voorraad verwijderen',
                        'back'   => 'Terug naar item'
                    ],
                    'delete'               => [
                        'title'        => 'Voorraad verwijderen van :item',
                        'are_you_sure' => 'Weet je zeker dat je deze voorraad wil verwijderen? Dit kan niet ongedaan worden gemaakt.',
                        'delete'       => 'Verwijderen'
                    ]
                ]
            ]
        ]
    ];
