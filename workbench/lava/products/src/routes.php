<?php

\Route::group(array('before' => 'subdomain|api'), function() {
    //Redeem promtion code
    \Route::post('product/promotion/redeem/{promotionCode}', array('as' => 'redeemPromotionCode', 'uses' => 'Lava\Products\PromotionController@postRedeemPromotion'));

    //Get single or all promotion
    \Route::get('product/promotion/get/{card_token?}', array('as' => 'userVehicle', 'uses' => 'Lava\Products\PromotionController@getPromotion'));

});


