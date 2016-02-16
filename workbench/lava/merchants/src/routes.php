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
});


