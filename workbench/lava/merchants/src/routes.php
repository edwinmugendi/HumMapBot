<?php

//Get locations
\Route::get('api/get/location_when_not_logged_in', array('as' => 'apiGetLocationWhenNotLoggedIn', 'uses' => 'Lava\Merchants\LocationController@getList'));

\Route::group(array('before' => 'api'), function() {

    //Get locations
    \Route::get('api/get/location_when_logged_in', array('as' => 'apiGetLocationWhenLoggedIn', 'uses' => 'Lava\Merchants\LocationController@getList'));

    //Feel location
    \Route::post('api/feel/location', array('as' => 'feelLocation', 'uses' => 'Lava\Merchants\FeelController@postFeel'));

    //Unfeel location
    \Route::post('api/unfeel/location', array('as' => 'unfeelLocation', 'uses' => 'Lava\Merchants\FeelController@postUnfeel'));
});


