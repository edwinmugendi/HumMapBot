<?php

//Sonic Callback
\Route::get('sonic/callback/positive', array('as' => 'sonicCallbackPositive', 'uses' => 'Lava\Products\SonicController@getCallback'));
//Sonic Callback
\Route::get('sonic/callback/negative', array('as' => 'sonicCallbackNegative', 'uses' => 'Lava\Products\SonicController@getCallback'));

\Route::group(array('before' => 'subdomain|api'), function() {
    //Redeem promtion code
    \Route::post('product/promotion/redeem/{promotionCode}', array('as' => 'redeemPromotionCode', 'uses' => 'Lava\Products\PromotionController@postRedeemPromotion'));

    //Get single promotion
    \Route::get('product/promotion/get/{field}/{value}', array('as' => 'promotionGetSingle', 'uses' => 'Lava\Products\PromotionController@getManyModelBelongingToUser'));

    //Get all promotion
    \Route::get('product/promotion/get', array('as' => 'promotionGetAll', 'uses' => 'Lava\Products\PromotionController@getAllManyModelBelongingToUser'));
});


