## Salvemundi.nl

Deze website is gemaakt middels het Laravel-framework. Max Korlaar is verantwoordelijk voor het back-end op het moment.

Het is **belangrijk** om de Laravel-documentatie goed door te lezen alvorens aan de slag te gaan met dit project, zowel front- als backend. Kom je hier niet uit, vraag het dan aan Max / iemand die hier verstand van heeft binnen de mediacommissie.


### Frontend

Voor het front-end wordt er gebruik gemaakt van Webpack om SASS en ES6 JavaScript te compileren tot bestanden die menig browser begrijpt. Kennis van SASS is handig. We maken gebruik van Sassy CSS (.scss bestanden).
Voor de pagina's zelf maken we niet alleen gebruik van HTML maar ook de templating-language Twig. Het is een bekende en goede taal om gemakkelijk templates mee te schrijven. Het is belangrijk dat je bekend bent met [de documentatie](https://twig.symfony.com/doc/2.x/).

Voor Laravel zijn er extra Twig-functies aanwezig: https://github.com/rcrowe/TwigBridge#functionsfiltersvariables. Waar deze functies op slaan is te vinden in de Laravel-documentatie.


### Aangeraden instellingen

Het gebruik van PHPStorm als IDE wordt sterk aangeraden. Andere IDEs worden niet gedocumenteerd hier. Gebruik waar mogelijk de volgende plugins:


* Laravel plugin
* Symfony plugin (Laravel draait deels op Symfony + Twig ondersteuning)
* .ignore plugin
* PHP Toolbox


Schakel de plugins in voor dit project.

### Lokaal instellen

* `npm install`
* `composer install`
* Gebruik Homestead (vagrant) voor een lokale VM. [Zie de Laravel-documentatie](https://laravel.com/docs/5.5/homestead#per-project-installation).
* `vagrant up`, wanneer draaiende gebruik `npm run watch`