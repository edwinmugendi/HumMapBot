<?php

\Route::group(array('before' => 'subdomain|api'), function() {
    /**
     * APP55 API's
     * 
     */
    //Sync Card Page
    \Route::post('payment/card/sync', array('as' => 'cardSync', 'uses' => 'Lava\Payments\CardController@postSync'));

    //Get single or all cards
    \Route::get('payment/card/get/{card_token?}', array('as' => 'cardGet', 'uses' => 'Lava\Payments\CardController@getCard'));

    //Delete Card
    \Route::post('payment/card/delete/{card_token}', array('as' => 'cardDelete', 'uses' => 'Lava\Payments\CardController@deleteCard'));

    //Create User Page
    \Route::get('payment/card/test/create/{id}/{email}/{password}', array('as' => 'paymentApp55Create', 'uses' => 'Lava\Payments\App55Controller@createUser'));

    //Create Card Page
    \Route::get('payment/card/test/create/card', array('as' => 'paymentApp55CreateCard', 'uses' => 'Lava\Payments\App55Controller@createCard'));

    /**
     * TRANSACTIONS API's
     * 
     */
    //Prepare transaction 
    \Route::post('payment/transaction/prepare', array('as' => 'paymentTransactionPrepare', 'uses' => 'Lava\Payments\PaymentController@prepare'));

    //Process Transaction
    \Route::post('payment/transaction/process', array('as' => 'paymentTransactionProcess', 'uses' => 'Lava\Payments\PaymentController@process'));
});
