<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | Vehicle Language Lines
      |--------------------------------------------------------------------------
     */
    'api' => array(
        'prepareTransaction' => 'Transaction prepared',
        'freeStampWash' => 'Free Stamp Wash'
    ),
    'validation' => array(
        'prepareTransaction' => array(
            'noCard' => 'User has not added a card',
            'dbError' => 'Lost connection to the database',
            'transaction' => array(
                1 => 'Transaction succeeded',
                0 => 'Transaction declined',
            )
        ),
        //validation.processTransaction.notNearEnough
        'processTransaction' => array(
            'notNearEnough' => 'Your not close enough to the Car Wash to process a transaction. Please attempt again when at the location.',
            'dbError' => 'Lost connection to the database',
            'transaction' => array(
                1 => 'Transaction successful',
                0 => 'Transaction declined',
            )
        ),
        'processTransactionWithStamps' => array(
            'notNearEnough' => 'Your not close enough to the Car Wash to process a transaction. Please attempt again when at the location.',
            'productNotLoyable' => ':name cannot be paid with loyalty stamps',
            'insufficientStamps' => ':name requires :locationStamps but you have :userStamps',
            'dbError' => 'Lost connection to the database',
            'transaction' => array(
                1 => 'Transaction successful',
            )
        ),
    )
);
