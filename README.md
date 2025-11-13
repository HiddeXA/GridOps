# GridOps

## instalatie instructies

## Benodigde software
- Local MySQL server
- Database manager
- Herd (Optioneel)
- PHP 8.4
- Node 22
- Composer 2.2.6+

## Stappen

- Maak een nieuwe database aan in mysql met een database manager
- Kopieer en hernoem de .env.example naar .env
- Zet op regel 23 t/m 28 in de .env de database gegevens van de aangemaakte database
- Run in de terminal de volgende commands `composer i` `npm i` `php artisan key:generate`
- Hierna run `php artisan migrate:fresh --seed` (De seed tag mag weggelaten worden indien er geen test data nodig is)
- Nu kan `npm run dev` in de terminal worden gerund op het project op te starten
- click op de gridops.test link om de pagina te openen

Tot slot kan er ingelogd worden met een test account namelijk

Email: test@example.com

WW: password
