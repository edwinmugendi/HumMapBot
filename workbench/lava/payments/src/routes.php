<?php

\Route::group(array('before' => 'api'), function() {
    /**
     * Card API's
     * 
     */
    //Create Card
    \Route::post('api/create/card', array('as' => 'createCard', 'uses' => 'Lava\Payments\CardController@postCreate'));

    //Stripe Test Form Page
    \Route::get('card/test/form', array('as' => 'testForm', 'uses' => 'Lava\Payments\CardController@getTestForm'));

    //Delete card
    \Route::post('api/delete/card', array('as' => 'deleteCard', 'uses' => 'Lava\Payments\CardController@postDrop'));

    //Get card
    \Route::get('api/get/card', array('as' => 'Get Card', 'uses' => 'Lava\Payments\CardController@getList'));

    /**
     * TRANSACTIONS API's
     * 
     */
    //Prepare transaction 
    \Route::post('api/prepare/transaction', array('as' => 'paymentTransactionPrepare', 'uses' => 'Lava\Payments\PaymentController@prepare'));

    //Process Transaction
    \Route::post('api/process/transaction', array('as' => 'paymentTransactionProcess', 'uses' => 'Lava\Payments\PaymentController@process'));

    //Process Transaction with loyalty stamps
    \Route::post('api/process/transaction_with_loyalty_stamps', array('as' => 'paymentTransactionProcessStamps', 'uses' => 'Lava\Payments\PaymentController@processWithStamps'));

    //Get users transaction
    \Route::get('api/get/transaction', array('as' => 'apiGetTransaction', 'uses' => 'Lava\Payments\TransactionController@getList'));
});
