<?php

\Route::group(array('before' => 'subdomain|api'), function() {
    /**
     * APP55 API's
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

    //Get all cards
    \Route::get('payment/card/get', array('as' => 'cardGetAll', 'uses' => 'Lava\Payments\CardController@getAllModelBelongingToUser'));

    //Delete Card
    \Route::post('payment/card/delete/{field}/{value}', array('as' => 'cardDelete', 'uses' => 'Lava\Payments\CardController@postDelete'));

    //Create User Page
    \Route::get('payment/card/test/create/{id}/{email}/{password}', array('as' => 'paymentApp55Create', 'uses' => 'Lava\Payments\App55Controller@createCard'));

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

    //Process Transaction with loyalty stamps
    \Route::post('payment/transaction/process/stamps', array('as' => 'paymentTransactionProcessStamps', 'uses' => 'Lava\Payments\PaymentController@processWithStamps'));

    //Get single transactions
    \Route::get('payment/transaction/get/{field}/{value}', array('as' => 'cardGetSingle', 'uses' => 'Lava\Payments\TransactionController@getModelBelongingToUser'));

    //Get all transactions
    \Route::get('payment/transaction/get', array('as' => 'cardGetAll', 'uses' => 'Lava\Payments\TransactionController@getAllModelBelongingToUser'));
});
