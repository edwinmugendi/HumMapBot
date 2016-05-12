<?php

\Route::group(array('before' => 'api'), function() {
    
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
});


