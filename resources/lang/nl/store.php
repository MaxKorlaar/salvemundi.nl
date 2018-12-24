<?php

    return [
        'title'       => 'Merchandise',
        'info'        => [
            'title' => 'Merchandise',
            'intro' => [
                "Welkom bij de officiële merchandise pagina van Salve Mundi!",
                "Met deze merchandise kun je shinen op elke gelegenheid en laat je zien dat je onderdeel uitmaakt van de studievereniging. Op deze pagina kun je bekijken welke merchandise er beschikbaar is en kan je een bestelling plaatsen."
            ]
        ],
        'cart'        => [
            'vat'                         => 'BTW (21%)',
            'title'                       => 'Winkelmandje',
            'name'                        => 'Product',
            'variant'                     => 'Uitvoering',
            'amount'                      => 'Aantal',
            'price'                       => 'Prijs',
            'empty_cart'                  => 'Je hebt momenteel niks in je winkelmandje.',
            'total_amount'                => 'Totaalprijs',
            'subtotal'                    => 'Subtotaal',
            'order'                       => 'Bestellen',
            'item_name'                   => ':product (:variant)',
            'missing_address_information' => 'Het is niet mogelijk om te betalen, omdat een of meerdere velden van je adresgegevens ontbreken of onjuist zijn. Het betreft de volgende velden:',
            'add_address_information'     => 'Corrigeer mijn adresgegevens',
            'order_instructions'          => 'Door op bestellen te drukken, wordt je aanvraag doorgestuurd naar de mediacommissie. Zij zullen contact met je opnemen over het ophalen van je bestelling. De betaling kan met pin gedaan worden op het moment van ophalen.',
            'order_terms'                 => 'Door een bestelling te plaatsen ga je akkoord met <a href="https://drive.google.com/uc?export=open&id=1ZGaXvr1_b0ToqtzQDqTl0YaGmoymvUpp" target="_blank">de huisregels van Salve Mundi</a> en dat je gegevens worden verwerkt volgens ons <a href="' . route('privacy') . '" target="_blank">privacybeleid</a>.',
            'place_order'                 => 'Plaats bestelling',
            'pay_using_card'              => 'Pinnen bij afhalen',
            'pay_later'                   => 'Het is ook mogelijk om je bestelling te plaatsen zonder een betaling te verrichten. Je moet de betaling dan afronden bij het ophalen. Het is dan mogelijk om per betaalpas of credit card te betalen.',
            'ideal'                       => 'Betalen met iDeal',
            'choose_your_bank'            => 'Kies je bank:',
            'pay_using_ideal'             => 'Bestel en betaal met iDeal',
            'pay_online'                  => 'Betaal direct online voor je bestelling. Je moet de bestelling nog wel komen afhalen, maar hoeft dan niet meer te betalen.',
            'payment_title'               => 'Online betalen',
            'payment_description'         => 'Bestelling van Salve Mundi webshop',
            'redirecting'                 => 'Je wordt zo doorgestuurd...',
            'redirecting_instructions'    => 'Je wordt nu naar onze betalingsprovider Mollie doorgestuurd, om voor je bestelling te betalen.',
            'payment_confirmation'        => [
                'title'              => 'Betaling voltooid',
                'completed'          => 'Bedankt voor je bestelling!',
                'email_instructions' => 'Bedankt voor het plaatsen van je bestelling. Je bestelling wordt automatisch in behandeling genomen wanneer de betaling succesvol is. Je krijgt automatisch een e-mail wanneer de betaling is gelukt.'
            ]

        ],
        'order'       => [
            'confirmation' => [
                'title'              => 'Bestelling geplaatst',
                'order_placed'       => 'We hebben je bestelling ontvangen',
                'email_instructions' => 'Bedankt voor het plaatsen van je bestelling bij Salve Mundi! We hebben je bestelling ontvangen en nemen binnenkort contact met je op. Meer informatie over je bestelling is zojuist naar je e-mail-adres toegestuurd.'
            ]
        ],
        'item'        => [
            'variant'      => 'Uitvoering',
            'no_stock'     => 'Geen op voorraad',
            'not_in_stock' => 'Niet meer op voorraad? Niet getreurd! Houd deze pagina in de gaten om op de hoogte blijven wanneer het product weer op voorraad is. Ook is het mogelijk om een mail naar media@salvemundi.nl te sturen om aan te geven dat jij interesse hebt in dit product!'
        ],
        'collections' => [
            'title' => "Bekijk hieronder de Salve Mundi merchandise collectie",
        ],
    ];