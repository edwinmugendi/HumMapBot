<?php

\Route::group(array('before' => 'subdomain|api'), function() {
    //Redeem promtion code
    \Route::post('product/promotion/redeem/{promotionCode}', array('as' => 'redeemPromotionCode', 'uses' => 'Lava\Products\PromotionController@postRedeemPromotion'));
});


