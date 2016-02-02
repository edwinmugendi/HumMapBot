//Composer update packages
cd workbench/lava/accounts && composer update && cd ../../../ && cd workbench/lava/docs && composer update && cd ../../../ && cd workbench/lava/merchants && composer update && cd ../../../ && cd workbench/lava/messages && composer update && cd ../../../ && cd workbench/lava/payments && composer update && cd ../../../ && cd workbench/lava/products && composer update && cd ../../../ 

//Migrate 
php artisan migrate --bench="lava/accounts" && php artisan migrate --bench="lava/docs" && php artisan migrate --bench="lava/merchants" && php artisan migrate --bench="lava/messages" && php artisan migrate --bench="lava/payments" && php artisan migrate --bench="lava/products"
//SEED
php artisan db:seed --class="\Erp\Locations\LocationsSeeder"
        
php artisan clear-compiled && php artisan dump-autoload
