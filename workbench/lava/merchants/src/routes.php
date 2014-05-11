<?php

\Route::group(array('before' => 'subdomain'), function() {
    //Get locations
    \Route::get('merchant/location/get/{locationId?}', array('as' => 'getLocation', 'uses' => 'Lava\Merchants\LocationController@getLocations'));
});

\Route::group(array('before' => 'subdomain|api'), function() {
    //Feel location
    \Route::post('merchant/location/feel/{locationId}', array('as' => 'feelLocation', 'uses' => 'Lava\Merchants\LocationController@postFeel'));
});

