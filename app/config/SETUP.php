//Composer update packages
cd workbench/lava/forms && composer update && cd ../../../ && cd workbench/lava/surveys && composer update && cd ../../../ && cd workbench/lava/accounts && composer update && cd ../../../ && cd workbench/lava/organizations && composer update && cd ../../../ && cd workbench/lava/messages && composer update && cd ../../../ && cd workbench/lava/locations && composer update && cd ../../../ && cd workbench/lava/media && composer update && cd ../../../

//Migrate 
php artisan migrate --bench="lava/forms" && php artisan migrate --bench="lava/surveys" && php artisan migrate --bench="lava/accounts"  && php artisan migrate --bench="lava/organizations" && php artisan migrate --bench="lava/messages" && php artisan migrate --bench="lava/media" && php artisan migrate --bench="lava/locations"

//SEED
php artisan db:seed --class="\Lava\Locations\LocationsSeeder"

php artisan clear-compiled && php artisan dump-autoload

cd public/media && sudo mkdir lava && cd lava && sudo mkdir upload && cd upload && sudo mkdir thumbnails && cd ../../../../
