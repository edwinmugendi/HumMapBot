<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | Message Language Lines
      |--------------------------------------------------------------------------
     */
    'communication' => array(
        'transaction' => array(
            'email' => 'Transaction confirmed :productName',
            'sms' => ':tranId confirmed. :name has purchase :currency :amount of :product - :productId  for :vrm on :day at :time. :productName',
            'push' => ':tranId confirmed. :name has purchase :currency :amount of :product - :productId  for :vrm on :day at :time. :productName',
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
