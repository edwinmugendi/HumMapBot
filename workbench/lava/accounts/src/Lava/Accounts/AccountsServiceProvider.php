<?php

namespace Lava\Accounts;

use Illuminate\Support\ServiceProvider;

class AccountsServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot() {
        $this->package('lava/accounts');
        //Register routes
        include __DIR__ . '/../../routes.php';

        //Register extensions
        include __DIR__ . '/../../extensions.php';
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return array();
    }

}
