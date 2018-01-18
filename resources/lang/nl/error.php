<?php
    $randomStrings = [
        '(Nina, probeer de boel heel te houden)',
        '(Is Fontys Café 040 al geopend?)',
        '(Koffie halen duurt lang.)',
        '(Max, schiet eens op!)',
        '(Is er een nieuw seizoen van Black Mirror?)',
    ];
    return [
        '400'                => 'Ongeldige aanvraag',
        '403'                => 'Toegang geweigerd',
        '404'                => 'Niet gevonden',
        'method_not_allowed' => 'Aanvraagmethode niet toegestaan',
        'something_went_wrong' => 'Er ging iets mis.',
        'file_not_found' => 'De opgevraagde pagina kon niet worden gevonden',
        '503' => 'Onderhoud',
        '500' => 'Serverfout',
        'website_comment' => 'Vraag of opmerking over de website?',
        'be_right_back' => "Hoi, we hebben de boel eventjes platgegooid voor onderhoud!\nWe zijn zo weer terug, en altijd te bereiken via info@salvemundi.nl.\n" .
            $randomStrings[rand(0, count($randomStrings) - 1)]
    ];