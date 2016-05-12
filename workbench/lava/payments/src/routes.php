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


\Route::group(array('before' => 'auth'), function() {

    /**
     * Transaction routes
     */
    //Detailed transaction
    \Route::get('payments/detailed/transaction/{id}', array('as' => 'paymentsDetailedTransaction', 'uses' => 'Lava\Payments\TransactionController@getDetailed'));

    //List transaction
    \Route::get('payments/list/transaction', array('as' => 'paymentsListTransaction', 'uses' => 'Lava\Payments\TransactionController@getList'));

    //Post transaction
    \Route::get('payments/post/transaction/{id?}', array('as' => 'paymentsPostTransaction', 'uses' => 'Lava\Payments\TransactionController@getPost'));

    //Create a transaction
    \Route::post('payments/create/transaction', array('as' => 'paymentsCreateTransaction', 'before' => 'csrf', 'uses' => 'Lava\Payments\TransactionController@postCreate'));

    //Update a transaction
    \Route::post('payments/update/transaction', array('as' => 'paymentsUpdateTransaction', 'before' => 'csrf', 'uses' => 'Lava\Payments\TransactionController@postUpdate'));

    //Delete transaction
    \Route::post('payments/delete/transaction', array('as' => 'paymentsDeleteTransaction', 'uses' => 'Lava\Payments\TransactionController@postDelete'));

    //Un-Delete transaction
    \Route::post('payments/undelete/transaction', array('as' => 'paymentsUndeleteTransaction', 'uses' => 'Lava\Payments\TransactionController@postUndelete'));
});
