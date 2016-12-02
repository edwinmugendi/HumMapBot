# HumMapBot
Humanitarian Response Knowledge

HumMapBot is a Telegram Bot that humanitarian workers can ask question and get answers on potential solution and tools that they could use.

To test the bot, install instagram and go to <strong>@HumMapBot</strong>

It uses API.AI for Natural Language Processing and then the data is retrieved from https://airtable.com/tblUipcy7ixUIEjYF

HumMapBot is built using Laravel 4.2 PHP framework.

It integrates to 3 API's:<br>
1. Telegram Bot API<br>
2. API.AI API<br>
3. Airtable API<br>

How to setup HumMapBot.<br>
1. Clone the repo<br>
2. Run "composer install" inthe command line.<br>
3. Create a database and update this file /app/config/prod/database.php accordingly<br>
   Also update this file /bootstrap/start.php with the correct environment <br>
4. Open /app/config/SETUP.php file and run the commands in this file in your command line.<br>
5. If you are using your own bot, API.API, or API.AI, you'll need to change the API keys in this file /app/config/thirdParty.php to yours.<br>
6. I've made a change to the Airtable API library to support getting single record. Kindly run this line to overwrite the libraries Airtable file<br>
 ```php rm vendor/armetiz/airtable-php/src/Airtable.php && cp workbench/lava/surveys/src/controllers/Airtable.php vendor/armetiz/airtable-php/src/Airtable.php```
<p>Kindly contact me on edwinmugendi@gmail.com for any assistance.

