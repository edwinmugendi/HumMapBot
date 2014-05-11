<?php

\Route::group(array('before' => 'subdomain|api'), function() {
    /**
     * APP55 API's
     * 
     */
    //Sync Card Page
    \Route::post('payment/app55/sync', array('as' => 'paymentApp55Sync', 'uses' => 'Lava\Payments\App55Controller@app55Sync'));

    //Create User Page
    \Route::get('payment/app55/test/create/{id}/{email}/{password}', array('as' => 'paymentApp55Create', 'uses' => 'Lava\Payments\App55Controller@createUser'));

    //Create Card Page
    \Route::get('payment/app55/test/create/card', array('as' => 'paymentApp55CreateCard', 'uses' => 'Lava\Payments\App55Controller@createCard'));

    //Delete Card Page
    \Route::get('payment/app55/test/delete/card/{app55UserId}/{token}', array('as' => 'paymentApp55DeleteCard', 'uses' => 'Lava\Payments\App55Controller@deleteCard'));

    /**
     * TRANSACTIONS API's
     * 
     */
    //Prepare transaction 
    \Route::post('payment/transaction/prepare', array('as' => 'paymentTransactionPrepare', 'uses' => 'Lava\Payments\PaymentController@prepare'));

    //Process Transaction
    \Route::post('payment/transaction/process', array('as' => 'paymentTransactionProcess', 'uses' => 'Lava\Payments\PaymentController@process'));
});