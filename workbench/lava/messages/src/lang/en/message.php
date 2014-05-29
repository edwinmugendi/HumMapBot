<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | Message Language Lines
      |--------------------------------------------------------------------------
     */
    'communication' => array(
        'transactionUser' => array(
            'email' => 'Product bought :productName',
            'sms' => ':tranId confirmed.  You bought :product for :vrm at :location on :day at :time. :productName',
            'push' => ':tranId confirmed.  You bought :product for :vrm at :location on :day at :time. :productName',
        ),
        'transactionMerchant' => array(
            'email' => ':product - :pdtId purchased by :name :productName',
            'sms'=>'LAVA TRANSACTION - :vrm Has purchased :product for :currency :amount at :day :time.',
//            'sms' => ':tranId confirmed. :name has purchased :currency :amount of :product for :vrm on :day at :time. :productName',
            'push'=>'LAVA TRANSACTION - :vrm Has purchased :product for :currency :amount at :day :time.',
        ),
        'resetPassword' => array(
            'email' => 'Request to change your :productName account password.',
            'sms' => '',
            'push' => ''
        ),
        'welcome' => array(
            'email' => 'Welcome to :productName',
            'sms' => 'Welcome to :productName',
            'push' => ''
        )
    )
);
