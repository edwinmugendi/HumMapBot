//Composer update packages
cd workbench/lava/accounts && composer update && cd ../../../ && cd workbench/lava/docs && composer update && cd ../../../ && cd workbench/lava/merchants && composer update && cd ../../../ && cd workbench/lava/messages && composer update && cd ../../../ && cd workbench/lava/payments && composer update && cd ../../../ && cd workbench/lava/products && composer update && cd ../../../ && cd workbench/lava/locations && composer update && cd ../../../ && cd workbench/lava/media && composer update && cd ../../../ 

//Migrate 
php artisan migrate --bench="lava/accounts" && php artisan migrate --bench="lava/docs" && php artisan migrate --bench="lava/merchants" && php artisan migrate --bench="lava/messages" && php artisan migrate --bench="lava/payments" && php artisan migrate --bench="lava/products" && php artisan migrate --bench="lava/media" && php artisan migrate --bench="lava/locations"
//SEED
php artisan db:seed --class="\Lava\Locations\LocationsSeeder"

php artisan clear-compiled && php artisan dump-autoload

cd public/media && sudo mkdir lava && cd lava && sudo mkdir upload && cd upload && sudo mkdir thumbnails && cd ../../../../

GetPesa
//Composer update packages
cd workbench/lava/loans && composer update && cd ../../../ && cd workbench/lava/accounts && composer update && cd ../../../ && cd workbench/lava/docs && composer update && cd ../../../ && cd workbench/lava/merchants && composer update && cd ../../../ && cd workbench/lava/messages && composer update && cd ../../../ && cd workbench/lava/payments && composer update && cd ../../../ && cd workbench/lava/products && composer update && cd ../../../ && cd workbench/lava/locations && composer update && cd ../../../ && cd workbench/lava/media && composer update && cd ../../../ 

//Migrate 
php artisan migrate --bench="lava/loans" && php artisan migrate --bench="lava/accounts" && php artisan migrate --bench="lava/docs" && php artisan migrate --bench="lava/merchants" && php artisan migrate --bench="lava/messages" && php artisan migrate --bench="lava/payments" && php artisan migrate --bench="lava/products" && php artisan migrate --bench="lava/media" && php artisan migrate --bench="lava/locations"
