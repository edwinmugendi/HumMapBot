<?php

\Route::group(array('before' => 'subdomain'), function() {
    //Get locations
    \Route::get('merchant/location/get/{locationId?}', array('as' => 'getLocation', 'uses' => 'Lava\Merchants\LocationController@getLocations'));
});


\Route::group(array('before' => 'subdomain|api'), function() {
    //Get locations
    \Route::get('merchant/location/user/favoured', array('as' => 'getLocationFavoured', 'uses' => 'Lava\Merchants\LocationController@getFavouredLocations'));

    //Feel location
    \Route::post('merchant/location/feel/{locationId}', array('as' => 'feelLocation', 'uses' => 'Lava\Merchants\FeelController@postFeel'));

    //Unfeel location
    \Route::post('merchant/location/unfeel/{locationId}', array('as' => 'unfeelLocation', 'uses' => 'Lava\Merchants\FeelController@postUnfeel'));

    //Get location feel
    \Route::post('merchant/location/feel/{locationId}/get/{type}', array('as' => 'feelLocationGet', 'uses' => 'Lava\Merchants\LocationController@getFeel'));
});

