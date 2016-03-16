<?php

//Refered
\Route::get('referral', array('as' => 'referral', 'uses' => 'Lava\Products\ReferralController@awardReferral'));

//Sonic Callback
\Route::get('sonic/callback/positive', array('as' => 'sonicCallbackPositive', 'uses' => 'Lava\Products\SonicController@getCallback'));
//Sonic Callback
\Route::get('sonic/callback/negative', array('as' => 'sonicCallbackNegative', 'uses' => 'Lava\Products\SonicController@getCallback'));

//Sonic
\Route::get('sonic/sonic', array('as' => 'sonicSonic', 'uses' => 'Lava\Products\SonicController@sonic'));

\Route::group(array('before' => 'api'), function() {
    //Refered
    \Route::post('api/referred_by', array('as' => 'apiReferredBy', 'uses' => 'Lava\Products\ReferralController@postReferredBy'));

    //Claim promtion code
    \Route::post('api/claim/promotion', array('as' => 'apiClaimPromotion', 'uses' => 'Lava\Products\PromotionController@postClaimPromotion'));

    //Get users promotions
    \Route::get('api/get/promotion', array('as' => 'apiGetPromotion', 'uses' => 'Lava\Products\PromotionController@getList'));
});

\Route::group(array('before' => 'auth'), function() {

    /**
     * Product routes
     */
    //Detailed product
    \Route::get('products/detailed/product/{id}', array('as' => 'productsDetailedProduct', 'uses' => 'Lava\Products\ProductController@getDetailed'));

    //List product
    \Route::get('products/list/product', array('as' => 'productsListProduct', 'uses' => 'Lava\Products\ProductController@getList'));

    //Post product
    \Route::get('products/post/product/{id?}', array('as' => 'productsPostProduct', 'uses' => 'Lava\Products\ProductController@getPost'));

    //Create a product
    \Route::post('products/create/product', array('as' => 'productsCreateProduct', 'before' => 'csrf', 'uses' => 'Lava\Products\ProductController@postCreate'));

    //Update a product
    \Route::post('products/update/product', array('as' => 'productsUpdateProduct', 'before' => 'csrf', 'uses' => 'Lava\Products\ProductController@postUpdate'));

    //Delete product
    \Route::post('products/delete/product', array('as' => 'productsDeleteProduct', 'uses' => 'Lava\Products\ProductController@postDelete'));

    //Un-Delete product
    \Route::post('products/undelete/product', array('as' => 'productsUndeleteProduct', 'uses' => 'Lava\Products\ProductController@postUndelete'));

    /**
     * Promotion routes
     */
    //Detailed promotion
    \Route::get('products/detailed/promotion/{id}', array('as' => 'productsDetailedPromotion', 'uses' => 'Lava\Products\PromotionController@getDetailed'));

    //List promotion
    \Route::get('products/list/promotion', array('as' => 'productsListPromotion', 'uses' => 'Lava\Products\PromotionController@getList'));

    //Post promotion
    \Route::get('products/post/promotion/{id?}', array('as' => 'productsPostPromotion', 'uses' => 'Lava\Products\PromotionController@getPost'));

    //Create a promotion
    \Route::post('products/create/promotion', array('as' => 'productsCreatePromotion', 'before' => 'csrf', 'uses' => 'Lava\Products\PromotionController@postCreate'));

    //Update a promotion
    \Route::post('products/update/promotion', array('as' => 'productsUpdatePromotion', 'before' => 'csrf', 'uses' => 'Lava\Products\PromotionController@postUpdate'));

    //Delete promotion
    \Route::post('products/delete/promotion', array('as' => 'productsDeletePromotion', 'uses' => 'Lava\Products\PromotionController@postDelete'));

    //Un-Delete promotion
    \Route::post('products/undelete/promotion', array('as' => 'productsUndeletePromotion', 'uses' => 'Lava\Products\PromotionController@postUndelete'));

    /**
     * Referral routes
     */
    //Detailed referral
    \Route::get('products/detailed/referral/{id}', array('as' => 'productsDetailedReferral', 'uses' => 'Lava\Products\ReferralController@getDetailed'));

    //List referral
    \Route::get('products/list/referral', array('as' => 'productsListReferral', 'uses' => 'Lava\Products\ReferralController@getList'));

    //Post referral
    \Route::get('products/post/referral/{id?}', array('as' => 'productsPostReferral', 'uses' => 'Lava\Products\ReferralController@getPost'));

    //Create a referral
    \Route::post('products/create/referral', array('as' => 'productsCreateReferral', 'before' => 'csrf', 'uses' => 'Lava\Products\ReferralController@postCreate'));

    //Update a referral
    \Route::post('products/update/referral', array('as' => 'productsUpdateReferral', 'before' => 'csrf', 'uses' => 'Lava\Products\ReferralController@postUpdate'));

    //Delete referral
    \Route::post('products/delete/referral', array('as' => 'productsDeleteReferral', 'uses' => 'Lava\Products\ReferralController@postDelete'));

    //Un-Delete referral
    \Route::post('products/undelete/referral', array('as' => 'productsUndeleteReferral', 'uses' => 'Lava\Products\ReferralController@postUndelete'));
});
