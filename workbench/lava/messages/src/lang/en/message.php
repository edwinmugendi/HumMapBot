<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | Message Language Lines
      |--------------------------------------------------------------------------
     */
    'communication' => array(
        'transactionUserCard' => array(
            'email' => ':product bought :productName at :location. :productName',
            'sms' => 'Thanks. You bought :product for :vrm at :location on :day at :time. Ref no is :tranId. :productName',
            'push' => 'Thanks. You bought :product for :vrm at :location on :day at :time. Ref no is :tranId. :productName',
        ),
        'transactionUserStamps' => array(
            'email' => 'Product bought :productName at :location. :productName ',
            'sms' => ':tranId confirmed.  You bought :product for :vrm at :location on :day at :time. :productName',
            'push' => ':tranId confirmed.  You bought :product for :vrm at :location on :day at :time. :productName',
        ),
        'transactionMerchantCard' => array(
            'email' => ':product - :pdtId purchased by :vrm  at :location. :productName',
            'sms' => ':vrm has purchased :product for :currency :amount at :day :time. Ref no :tranId',
            'push' => ':vrm has purchased :product for :currency :amount at :day :time. Ref no :tranId',
        ),
        'transactionMerchantStamps' => array(
            'email' => 'Promotion: :product - :pdtId purchased by :vrm  at :location. :productName',
            'sms' => 'Promotion: :vrm has purchased :product for :currency :amount at :day :time. Ref no :tranId',
            'push' => 'Promotion: :vrm has purchased :product for :currency :amount at :day :time. Ref no :tranId',
        ),
        'sonicPromotion' => array(
            'email' => '',
            'sms' => ':product - You\'ve been awarded :promoCode promotion code whose value id :promoValue',
            'push' => ''
        ),
        'resetPassword' => array(
            'email' => 'Request to change your :productName account password.',
            'sms' => '',
            'push' => ''
        ),
        'forgotPassword' => array(
            'email' => 'Request to change your :productName account password.',
            'sms' => 'Dear :name, your password reset code is :resetCode',
            'push' => ''
        ),
        'welcome' => array(
            'email' => 'Welcome to :productName',
            'sms' => 'Welcome to :productName',
            'push' => ''
        )
    )
);
