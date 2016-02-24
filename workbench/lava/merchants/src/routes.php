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

\Route::group(array('before' => 'auth'), function() {

    /**
     * Merchant routes
     */
    //Change a merchant
    \Route::post('merchants/change/merchant', array('as' => 'merchantsChangeMerchant', 'uses' => 'Lava\Merchants\MerchantController@postChangeMerchant'));

    //Detailed merchant
    \Route::get('merchants/detailed/merchant/{id}', array('as' => 'merchantsDetailedMerchant', 'uses' => 'Lava\Merchants\MerchantController@getDetailed'));

    //List merchant
    \Route::get('merchants/list/merchant', array('as' => 'merchantsListMerchant', 'uses' => 'Lava\Merchants\MerchantController@getList'));

    //Post merchant
    \Route::get('merchants/post/merchant/{id?}', array('as' => 'merchantsPostMerchant', 'uses' => 'Lava\Merchants\MerchantController@getPost'));

    //Create a merchant
    \Route::post('merchants/create/merchant', array('as' => 'merchantsCreateMerchant', 'before' => 'csrf', 'uses' => 'Lava\Merchants\MerchantController@postCreate'));

    //Update a merchant
    \Route::post('merchants/update/merchant', array('as' => 'merchantsUpdateMerchant', 'before' => 'csrf', 'uses' => 'Lava\Merchants\MerchantController@postUpdate'));

    //Delete merchant
    \Route::post('merchants/delete/merchant', array('as' => 'merchantsDeleteMerchant', 'uses' => 'Lava\Merchants\MerchantController@postDelete'));

    //Un-Delete merchant
    \Route::post('merchants/undelete/merchant', array('as' => 'merchantsUndeleteMerchant', 'uses' => 'Lava\Merchants\MerchantController@postUndelete'));

    /**
     * Location routes
     */
    //Detailed location
    \Route::get('merchants/detailed/location/{id}', array('as' => 'merchantsDetailedLocation', 'uses' => 'Lava\Merchants\LocationController@getDetailed'));

    //List location
    \Route::get('merchants/list/location', array('as' => 'merchantsListLocation', 'uses' => 'Lava\Merchants\LocationController@getList'));

    //Post location
    \Route::get('merchants/post/location/{id?}', array('as' => 'merchantsPostLocation', 'uses' => 'Lava\Merchants\LocationController@getPost'));

    //Create a location
    \Route::post('merchants/create/location', array('as' => 'merchantsCreateLocation', 'before' => 'csrf', 'uses' => 'Lava\Merchants\LocationController@postCreate'));

    //Update a location
    \Route::post('merchants/update/location', array('as' => 'merchantsUpdateLocation', 'before' => 'csrf', 'uses' => 'Lava\Merchants\LocationController@postUpdate'));

    //Delete location
    \Route::post('merchants/delete/location', array('as' => 'merchantsDeleteLocation', 'uses' => 'Lava\Merchants\LocationController@postDelete'));

    //Un-Delete location
    \Route::post('merchants/undelete/location', array('as' => 'merchantsUndeleteLocation', 'uses' => 'Lava\Merchants\LocationController@postUndelete'));
});


