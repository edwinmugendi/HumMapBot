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
        'processTransaction' => array(
            'notNearEnough' => 'You have to be within 500 metre to process a payment',
            'dbError' => 'Lost connection to the database',
            'transaction' => array(
                1 => 'Transaction successful',
                0 => 'Transaction declined',
            )
        ),
        'processTransactionWithStamps' => array(
            'notNearEnough' => 'You have to be within 500 metre to process a payment',
            'productNotLoyable' => ':name cannot be paid with loyalty stamps',
            'insufficientStamps' => ':name requires :locationStamps but you have :userStamps',
            'dbError' => 'Lost connection to the database',
            'transaction' => array(
                1 => 'Transaction successful',
            )
        ),
    )
);
