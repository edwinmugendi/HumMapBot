<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | Promotions Language Lines
      |--------------------------------------------------------------------------
     */
    'api' => array(
        'getSingle' => 'Promotion :field :value found.',
        'getAll' => 'Your promotion\'s list',
        'redeemPromotion'=>'Promotion code :code redeemed.'
    ),
    'validation' => array(
        "isPromotionCodeValid" => array(
            "expired" => "This promotion code :code has expired",
            "newCustomers" => "This promotion code :code is only available who have not processed a transaction",
            "redeemed" => "You have already redeemed this promotion code :code",
            "claimed" => "You have already claimed this promotion code :code but not used it yet"
        ),
    )
);
