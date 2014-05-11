<?php

use Illuminate\Support\ServiceProvider;
use \UtilFacade;

class UtilLibraryServiceProvider extends ServiceProvider {

    public function register() {

        // Register 'Util' instance container to our UtilLibrary object
        $this->app['Util'] = $this->app->share(function($app) {
            return new UtilLibrary;
        });

        $this->app->booting(function() {
            $loader = Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Util', 'UtilFacade');
        });
    }

}
