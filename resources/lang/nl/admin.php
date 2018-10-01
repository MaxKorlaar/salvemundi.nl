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
                'failed'    => 'Betaling mislukt',
                'expired'   => 'Betaling verlopen',
                'refunded'  => 'Teruggestort'
            ],
            'transaction_amount' => 'Bedrag',
            'created_at'         => 'Aangemaakt op',
            'updated_at'         => 'Bijgewerkt op'
        ],
        'memberships'  => [
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
        'camping'      => [
            'title'          => 'Kamp',
            'id'             => 'ID',
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
        'members'      => [
            'title'                 => 'Ledenadministratie',
            'details'               => 'Details',
            'id'                    => 'ID',
            'leave_id_empty'        => 'Laat leeg om automatisch te genereren',
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
            'birthday'              => 'Geboortedatum',
            'phone'                 => 'Telefoonnummer',
            'email'                 => 'E-mail-adres',
            'transaction_id'        => 'Transactie-id',
            'transaction_amount'    => 'Bedrag transactie',
            'transaction_status'    => 'Transactie-status',
            'website_account'       => 'Websitegebruiker',
            'no_user'               => 'Geen account',
            'card'                  => 'Ledenpas',
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
            'not_a_member'          => 'Dit lid heeft momenteel geen actief lidmaatschap',
            'no_valid_membership'   => 'Lidmaatschap verlopen',
            'email_invalid_members' => 'E-mail leden zonder lidmaatschap',
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
                'title'        => 'Lid verwijderen',
                'are_you_sure' => 'Weet je het zeker?',
                'delete'       => 'Lid permanent verwijderen'
            ],
            'send_email'            => [
                'title'                       => 'Leden mailen',
                'subject'                     => 'Onderwerp',
                'message_content_placeholder' => 'Typ hier je bericht. Het gebruik van HTML is toegestaan, al wordt het wel afgeraden. Berichten met minder opmaak hebben over het algemeen succes bij gebruikers: https://blog.chamaileon.io/choosing-between-plain-text-html-email/.',
                'content'                     => "Beste {voornaam},\n\n(Jouw bericht hier)",
                'help_text'                   => 'Het is mogelijk om de voor- en achternaam van de ontvanger in het bericht te plaatsen. Gebruik \'{voornaam}\' en \'{achternaam}\', deze zullen automatisch vervangen worden door de juiste naam.',
                'preview'                     => 'Bekijk voorbeeld van de e-mail',
                'send'                        => 'Stuur email naar :count leden',
                'email_sent'                  => 'E-mail verstuurd naar :members leden.'
            ]
        ],
        'intro'        => [
            'title'                    => 'FHICT Introductie 2018',
            'amount'                   => 'Aanmeldingen',
            'confirmed_amount'         => 'Betaalde aanmeldingen',
            'generate_tokens'          => 'Genereer betaalverzoeken en verstuur ze per mail',
            'send_email_reminders'     => 'Stuur herinneringen naar onbevestigde email-adressen',
            'send_payment_reminders'   => 'Stuur herinneringen naar aanmeldingen met betaalverzoek',
            'reminders_sent'           => 'Er is een herinnering gestuurd naar :count van de :unconfirmed_count onbevestigde email-adressen. Er werden alleen herinneringen gestuurd naar aanmeldingen die het laatst bijgewerkt zijn voor :date of een laatste herinnering kregen voor :date.',
            'payment_reminders_sent'   => 'Er is een herinnering gestuurd naar :actual_count van de :count aanmeldingen die reeds een betaalverzoek hebben ontvangen. Er werden alleen herinneringen gestuurd naar aanmeldingen die het laatst bijgewerkt zijn voor :date of een laatste herinnering kregen voor :date.',
            'tokens_generated'         => 'Voor alle bevestigde e-mail-adressen zonder betaalverzoeken zijn :count unieke betaalverzoeken gegenereerd en verstuurd per mail. Ik hoop dat je niet per ongeluk op de knop drukte want holy shit deze emails gaan we dus allemaal niet meer terugkrijgen en dan zijn we flink genaaid.',
            'id'                       => 'ID',
            'status'                   => 'Status',
            'status_approved'          => 'Betaald',
            'status_new'               => 'Niet betaald',
            'status_email_unconfirmed' => 'E-mail niet bevestigd',
            'status_on_hold'           => 'Transactie bezig',
            'status_under_review'      => 'Teruggestort',
            'no_mail'                  => 'Geen betaalverzoek',
            'last_name'                => 'Achternaam',
            'first_name'               => 'Voornaam',
            'pcn'                      => 'PCN',
            'birthday'                 => 'Geboortedatum',
            'address'                  => 'Straat en huisnummer',
            'city'                     => 'Woonplaats',
            'postal'                   => 'Postcode',
            'phone'                    => 'Telefoonnummer student',
            'contact_phone'            => 'Telefoonnummer contactpersoon',
            'email'                    => 'E-mail-adres',
            'gender'                   => 'Geslacht',
            'shirt_size'               => 'Shirtmaat (Unisex)',
            'same_sex_rooms'           => 'Kamer delen met alleen zelfde geslacht',
            'created_at'               => 'Aangemaakt op',
            'updated_at'               => 'Bijgewerkt op',
            'remarks'                  => 'Opmerkingen',
            'transaction_status'       => 'Transactiestatus',
            'transaction_id'           => 'Transactie-ID',
            'transaction_amount'       => 'Bedrag transactie',
            'details'                  => 'Details',
            'delete_application'       => 'Aanmelding verwijderen',
            'count'                    => ':count aanmelding|:count aanmeldingen, waarvan :confirmed betaald zijn en :email_unconfirmed geen bevestigd email-adres hebben',
            'back_to_index'            => 'Terug naar overzicht',
            'view_spreadsheet'         => 'Bekijk spreadsheet',
            'delete'                   => [
                'are_you_sure' => 'Weet je zeker dat je deze aanmelding wil verwijderen? Dit kan <b>niet</b> ongedaan worden gemaakt. Alle gegevens gerelateerd aan deze aanmelding zullen onherstelbaar worden verwijderd. Mocht deze aanmelding gekoppeld zijn aan een Mollie-betaling, dan zal deze betaling blijven bestaan in Mollie.',
                'delete'       => 'Verwijder aanmelding permanent',
                'deleted'      => 'De aanmelding is permanent verwijderd uit het systeem'
            ]
        ]
    ];
