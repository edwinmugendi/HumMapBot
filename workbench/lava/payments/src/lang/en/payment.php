<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | Vehicle Language Lines
      |--------------------------------------------------------------------------
     */
    'data' => array(
        'workflow' => array(
            0 => 'Failed',
            1 => 'Processed',
            2 => 'Promotion',
            3 => 'Stamps',
            4 => 'Refunded',
        )
    ),
    'api' => array(
        'prepareTransaction' => 'Transaction prepared',
        'freeStampWash' => 'Free Stamp Wash'
    ),
    'validation' => array(
        'prepareTransaction' => array(
            'success' => 'Transaction prepared',
            'noCard' => 'User has not added a card',
            'dbError' => 'Lost connection to the database',
            'transaction' => array(
                1 => 'Transaction succeeded',
                0 => 'Transaction declined',
            )
        ),
        //validation.processTransaction.notNearEnough
        'processTransaction' => array(
            'notNearEnough' => 'You need to be within a 500 metre range from the carwash to make a purchase.',
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
