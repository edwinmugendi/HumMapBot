<?php

use Illuminate\Support\ServiceProvider;
use \FormFacade as FormFacade;

class FormLibraryServiceProvider extends ServiceProvider {

    public function register() {

        // Register Form instance container to our FormLibrary object
        $this->app['Form'] = $this->app->share(function($app) {
            $form = new FormLibrary($app['html'], $app['url'], $app['session.store']->getToken());
            return $form->setSessionStore($app['session.store']);
        });

        $this->app->booting(function() {
            $loader = Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Form', 'FormFacade');
        });
    }

}
