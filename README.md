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

Alle `commando's` dienen, tenzij anders vermeld, uitgevoerd te worden in je terminal/commandoprompt met als huidige map die van dit project (De map waarin dit bestand staat)

* Installeer npm via de instructies op de website van NodeJS (Is nogal een gedoe met macOS High Sierra, Google is je vriend)
* Install composer via de instructies op de website van Composer (je kan ook alleen composer.phar downloaden en in deze map zetten als je hem niet in je hele systeem wil hebben, maar dan moet je wel `php composer.phar` gebruiken in plaats van slechts `composer`, bij commando's)
* `npm install`
* `composer install`
* Gebruik Homestead (vagrant) voor een lokale VM. [Zie de Laravel-documentatie](https://laravel.com/docs/5.5/homestead#per-project-installation). Kijk hierbij onder 'Per project installation'
* Stel in `Homestead.yaml` in dat de mapping van `homestead.test` gelinkt is aan `/home/vagrant/code/public` (in plaats van slechts `public` op het einde)
* `vagrant up`, wanneer draaiende gebruik `npm run watch`
* Voor Vagrant is een VM-manager nodig; Makkelijkste is Virtualbox - Deze heeft gewoon een installer voor Mac en Windows. Bij Mac is het nodig om naar Instellingen.app -> Beveiliging te gaan om onderaan in dat venster toestemming te geven aan de Virtualbox installer, nadat de installatie automatisch mislukt door geweigerde toegang.

### Bijwerken

Nadat je de bestanden hebt bijgewerkt vanuit git, is het mogelijk dat er wijzigingen zijn aangebracht in de databasestructuur. Deze kunnen automatisch worden toegepast door de volgende commando's uit te voeren:

* Als je op een lokale machine werkt, eerst `vagrant ssh` typen om in de VM te komen.
* Navigeer naar het pad van dit project (In de VM is dat `cd code/` (De locatie van het project in Vagrant is `/home/vagrant/code`).
* Voer `php artisan down` uit om het project in een onderhoudsmodus te brengen (Hoeft lokaal niet per se).
* Voer `php artisan migrate` uit om de migraties uit te voeren.
* Indien de onderhoudsmodus aanstaat, deze uitzetten via `php artisan up`.

* Database op Fontys bijwerken: `php artisan migrate --database=fontys`