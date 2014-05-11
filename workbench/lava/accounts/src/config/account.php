<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | Product Name
      |--------------------------------------------------------------------------
      | The name of the product
      |
     */
    'name' => 'Lava app',
    /*
      |--------------------------------------------------------------------------
      | Login attempts
      |--------------------------------------------------------------------------
      | The number of login attempt before the account is suspended
      |
     */
    'loginAttempts' => 4,
    /*
      |--------------------------------------------------------------------------
      | Password minimum characters
      |--------------------------------------------------------------------------
      |
     */
    'passwordMinCharacters' => 6,
    /*
      |--------------------------------------------------------------------------
      | Lock out
      |--------------------------------------------------------------------------
      | The number of lock out time in minutes
      |
     */
    'lockOut' => 30,
    /*
      |--------------------------------------------------------------------------
      | Reset timeout
      |--------------------------------------------------------------------------
      | The number of minutes before the reset code expires
      |
     */
    'resetCodeTimeout' => 60,
    /*
      |--------------------------------------------------------------------------
      | Facebook SDK
      |--------------------------------------------------------------------------
      | Facebook SDK credentials
      |
     */
    'facebook' => array(
        'app_id' => '291512857637270',
        'app_secret' => '1c4a3dcef631bf5104ed9f8239bfb139',
        "scope" => "email,user_birthday"
    )
);
