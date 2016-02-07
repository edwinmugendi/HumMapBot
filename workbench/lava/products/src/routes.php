<?php

//Sonic Callback
\Route::get('sonic/callback/positive', array('as' => 'sonicCallbackPositive', 'uses' => 'Lava\Products\SonicController@getCallback'));
//Sonic Callback
\Route::get('sonic/callback/negative', array('as' => 'sonicCallbackNegative', 'uses' => 'Lava\Products\SonicController@getCallback'));

//Sonic
\Route::get('sonic/sonic', array('as' => 'sonicSonic', 'uses' => 'Lava\Products\SonicController@sonic'));

\Route::group(array('before' => 'api'), function() {
    //Claim promtion code
    \Route::post('api/claim/promotion', array('as' => 'apiClaimPromotion', 'uses' => 'Lava\Products\PromotionController@postClaimPromotion'));
});


