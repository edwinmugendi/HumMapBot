<?php

//Get locations
\Route::get('api/get/location', array('as' => 'getLocation', 'uses' => 'Lava\Merchants\LocationController@getList'));

\Route::group(array('before' => 'api'), function() {

    //Feel location
    \Route::post('api/feel/location', array('as' => 'feelLocation', 'uses' => 'Lava\Merchants\FeelController@postFeel'));

    //Unfeel location
    \Route::post('api/unfeel/location', array('as' => 'unfeelLocation', 'uses' => 'Lava\Merchants\FeelController@postUnfeel'));

});

