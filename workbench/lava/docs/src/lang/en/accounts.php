<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | Accounts Language Lines
      |--------------------------------------------------------------------------
     */
    'module' => array(
        'name' => 'Accounts',
        'note' => 'Accounts module'
    ),
    'api' => array(
        array(
            'name' => 'Register User',
            'note' => 'Register a user',
            'filtered' => 1,
            'endpoint' => 'api/register_user',
            'httpVerb' => 'POST',
            'parameters' => array(
                array(
                    'field' => 'format',
                    'dataType' => 'string',
                    'note' => 'Must be \'json\'',
                    'required' => 1,
                ),
                array(
                    'field' => 'first_name',
                    'dataType' => 'string',
                    'note' => 'First name',
                    'required' => 1,
                ),
                array(
                    'field' => 'last_name',
                    'dataType' => 'string',
                    'note' => 'Last name',
                    'required' => 1,
                ),
                array(
                    'field' => 'phone',
                    'dataType' => 'string',
                    'note' => 'Phone number (Ensure it has the country code)',
                    'required' => 0,
                ),
                array(
                    'field' => 'email',
                    'dataType' => 'string',
                    'note' => 'Email address',
                    'required' => 1,
                ),
                array(
                    'field' => 'password',
                    'dataType' => 'string',
                    'note' => 'Password (Password should be more than 6 characters)',
                    'required' => 1,
                ),
                array(
                    'field' => 'location',
                    'dataType' => array(
                        array(
                            'field' => 'lat',
                            'dataType' => 'float',
                            'note' => 'Latitude : range -90 to 90',
                            'required' => 1,
                        ),
                        array(
                            'field' => 'lng',
                            'dataType' => 'float',
                            'note' => 'Latitude : range -180 to 180',
                            'required' => 1,
                        ),
                    ),
                    'note' => 'Location array',
                    'required' => 0,
                ),
            ),
            'returns' => array(
                array(
                    'action' => 'Success',
                    'httpCode' => 200,
                    'note' => 'User created',
                    'example' => '{"http_status_code":200,"system_code":700,"message":"User created","data":{"id":30}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"http_status_code":400,"system_code":900,"message":"Input validation failed.","data":[{"field":"email","error":"The email has already been taken."}]}'
                ),
            )
        ),
        array(
            'name' => 'Login with email and password',
            'note' => 'Login a user <br>'
            . '<br> For improved security a new token is generated everytime you login'
            . 'Securely save the returned <i>token</i> that will used to access all endpoints that need the user to be logged in.',
            'filtered' => 0,
            'endpoint' => 'api/login_user',
            'httpVerb' => 'POST',
            'parameters' => array(
                array(
                    'field' => 'format',
                    'dataType' => 'string',
                    'note' => 'Must be \'json\'',
                    'required' => 1,
                ),
                array(
                    'field' => 'email',
                    'dataType' => 'string',
                    'note' => 'Email address',
                    'required' => 1,
                ),
                array(
                    'field' => 'password',
                    'dataType' => 'string',
                    'note' => 'Password',
                    'required' => 1,
                ),
                array(
                    'field' => 'os',
                    'dataType' => 'String',
                    'note' => 'Can be <i>ios</i> or <i>android</i>',
                    'required' => 0,
                ),
                array(
                    'field' => 'push_token',
                    'dataType' => 'String',
                    'note' => 'Pushwoosh push token',
                    'required' => 0,
                ),
                array(
                    'field' => 'app_version',
                    'dataType' => 'String',
                    'note' => 'App version',
                    'required' => 0,
                ),
                array(
                    'field' => 'location',
                    'dataType' => array(
                        array(
                            'field' => 'lat',
                            'dataType' => 'float',
                            'note' => 'Latitude : range -90 to 90',
                            'required' => 1,
                        ),
                        array(
                            'field' => 'lng',
                            'dataType' => 'float',
                            'note' => 'Latitude : range -180 to 180',
                            'required' => 1,
                        ),
                    ),
                    'note' => 'Location array',
                    'required' => 0,
                ),
            ),
            'returns' => array(
                array(
                    'action' => 'Success',
                    'httpCode' => 200,
                    'note' => 'Logged in!',
                    'example' => '{"http_status_code":200,"system_code":700,"message":"Logged in!","data":{"id":"30","first_name":"Edwin","last_name":"Mugendi","phone":"+254722906836","dob":"0000-00-00","gender":"","email":"edwinmugendi@gmail.com","address":"","postal_code":"","token":"pjimbrfgccjbprshe7akqgxkmvuk7ouy","vrm":"","card":"","fb_uid":"","lat":"90.0000000000","lng":"11.0000000000","points":"0","notify_sms":"1","notify_push":"1","notify_email":"1","os":"","push_token":"","app_version":"","created_at":"2016-02-06 01:17:12","updated_at":"2016-02-06 01:19:09","stripe_id":"cus_7qvW8niFCRsB0W","agent":"Mozilla\/5.0 (X11; Linux x86_64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/46.0.2490.80 Safari\/537.36","ip":"127.0.0.1","logins":[]}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"http_status_code":400,"system_code":900,"message":"Input validation failed.","data":[{"field":"password","error":"The email or password you entered is incorrect."}]}'
                ),
            )
        ),
        array(
            'name' => 'Facebook Login',
            'note' => 'Login a user with Facebook Token<br>'
            . '<br> For improved security a new token is generated everytime you login'
            . 'Securely save the returned <i>token</i> that will used to access all endpoints that need the user to be logged in.',
            'filtered' => 0,
            'endpoint' => 'api/login_with_facebook',
            'httpVerb' => 'POST',
            'parameters' => array(
                array(
                    'field' => 'format',
                    'dataType' => 'string',
                    'note' => 'Must be \'json\'',
                    'required' => 1,
                ),
                array(
                    'field' => 'facebook_token',
                    'dataType' => 'string',
                    'note' => 'Token from facebook',
                    'required' => 1,
                ),
                array(
                    'field' => 'os',
                    'dataType' => 'String',
                    'note' => 'Can be <i>ios</i> or <i>android</i>',
                    'required' => 0,
                ),
                array(
                    'field' => 'push_token',
                    'dataType' => 'String',
                    'note' => 'Pushwoosh push token',
                    'required' => 0,
                ),
                array(
                    'field' => 'app_version',
                    'dataType' => 'String',
                    'note' => 'App version',
                    'required' => 0,
                ),
                array(
                    'field' => 'location',
                    'dataType' => array(
                        array(
                            'field' => 'lat',
                            'dataType' => 'float',
                            'note' => 'Latitude : range -90 to 90',
                            'required' => 1,
                        ),
                        array(
                            'field' => 'lng',
                            'dataType' => 'float',
                            'note' => 'Latitude : range -180 to 180',
                            'required' => 1,
                        ),
                    ),
                    'note' => 'Location array',
                    'required' => 0,
                ),
            ),
            'returns' => array(
                array(
                    'action' => 'Success',
                    'httpCode' => 200,
                    'note' => 'Logged in',
                    'example' => '{"http_status_code":200,"system_code":700,"message":"Logged in!","data":{"id":"34","first_name":"Donna","last_name":"Bushakman","phone":"","dob":"1980-08-08","gender":"female","email":"gkivacm_bushakman_1415013488@tfbnw.net","address":"","postal_code":"","token":"padarez8egpew0njvpqt7lcblcfrspyr7evtk2sfyfnxlirv","vrm":"","card":"","fb_uid":"1495733417344044","lat":"0.0000000000","lng":"0.0000000000","points":"0","notify_sms":"1","notify_push":"1","notify_email":"1","os":"ios","push_token":"push_token","app_version":"App Verssion","created_at":"2016-02-06 02:14:10","updated_at":"2016-02-06 02:26:08","stripe_id":"cus_7qwRvxDu44ijq7","agent":"Mozilla\/5.0 (X11; Linux x86_64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/46.0.2490.80 Safari\/537.36"}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"http_status_code":404,"system_code":904,"message":"User not found.","data":{"field":"facebook_token","type":"User","value":""}}'
                ),
            )
        ),
        array(
            'name' => 'Get User Profile',
            'note' => 'Get a logged in user\'s profile identified by the token',
            'filtered' => 1,
            'endpoint' => '/api/get_user_profile',
            'httpVerb' => 'GET',
            'parameters' => array(
                array(
                    'field' => 'format',
                    'dataType' => 'string',
                    'note' => 'Must be \'json\'',
                    'required' => 1,
                ),
                array(
                    'field' => 'token',
                    'dataType' => 'string',
                    'note' => 'User API token',
                    'required' => 1,
                )
            ),
            'returns' => array(
                array(
                    'action' => 'Success',
                    'httpCode' => 200,
                    'note' => 'Got profile',
                    'example' => '{"http_status_code":200,"system_code":700,"message":"Succeed.","data":{"id":"35","first_name":"Edwin","last_name":"Mugendi","phone":"+254722906836","dob":"0000-00-00","gender":"","email":"edwinmugendi@gmail.com","address":"","postal_code":"","token":"jdkgnjniiflbye5xojemmphpdst0bsdw","vrm":"","card":"","fb_uid":"","lat":"90.0000000000","lng":"11.0000000000","points":"0","notify_sms":"1","notify_push":"1","notify_email":"1","os":"ios","push_token":"sdfaf","app_version":"asd","created_at":"2016-02-06 02:16:38","updated_at":"2016-02-06 02:24:39","stripe_id":"cus_7qwTckPJkETZwp","agent":"Mozilla\/5.0 (X11; Linux x86_64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/46.0.2490.80 Safari\/537.36"}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"http_status_code":400,"system_code":900,"message":"Input validation failed.","data":[{"field":"token","error":"Invalid login token"}]}'
                ),
            )
        ),
        array(
            'name' => 'Update User Profile',
            'note' => 'Update a users profile<br>'
            . 'To update the password you\'ll need to provide both <i>old_password</i> and <i>new_password</i> fields',
            'filtered' => 1,
            'endpoint' => 'api/update_user',
            'httpVerb' => 'POST',
            'parameters' => array(
                array(
                    'field' => 'format',
                    'dataType' => 'string',
                    'note' => 'Must be \'json\'',
                    'required' => 1,
                ),
                array(
                    'field' => 'id',
                    'dataType' => 'integer',
                    'note' => 'User Id',
                    'required' => 1,
                ),
                array(
                    'field' => 'first_name',
                    'dataType' => 'string',
                    'note' => 'First name',
                    'required' => 0,
                ),
                array(
                    'field' => 'last_name',
                    'dataType' => 'string',
                    'note' => 'Last name',
                    'required' => 0,
                ),
                array(
                    'field' => 'phone',
                    'dataType' => 'string',
                    'note' => 'Phone number (Ensure it has the country code)',
                    'required' => 0,
                ),
                array(
                    'field' => 'email',
                    'dataType' => 'string',
                    'note' => 'Email address',
                    'required' => 0,
                ),
                array(
                    'field' => 'old_password',
                    'dataType' => 'string',
                    'note' => 'Old password',
                    'required' => 0,
                ),
                array(
                    'field' => 'new_password',
                    'dataType' => 'string',
                    'note' => 'New password (Required if <i>old_password</i> is present. Should be greater than 6 characters',
                    'required' => 2,
                ),
                array(
                    'field' => 'notify_sms',
                    'dataType' => 'boolean integer',
                    'note' => '1 or 0 to enable or disable sms notifications',
                    'required' => 0,
                ),
                array(
                    'field' => 'notify_email',
                    'dataType' => 'boolean integer',
                    'note' => '1 or 0 to enable or disable email notifications',
                    'required' => 0,
                ),
                array(
                    'field' => 'notify_push',
                    'dataType' => 'boolean integer',
                    'note' => '1 or 0 to enable or disable push notifications',
                    'required' => 0,
                ),
                array(
                    'field' => 'os',
                    'dataType' => 'String',
                    'note' => 'Can be <i>ios</i> or <i>android</i>',
                    'required' => 0,
                ),
                array(
                    'field' => 'push_token',
                    'dataType' => 'String',
                    'note' => 'Pushwoosh push token',
                    'required' => 0,
                ),
                array(
                    'field' => 'app_version',
                    'dataType' => 'String',
                    'note' => 'App version',
                    'required' => 0,
                ),
                array(
                    'field' => 'vrm',
                    'dataType' => 'String',
                    'note' => 'VRM to make default',
                    'required' => 0,
                ),
                array(
                    'field' => 'card',
                    'dataType' => 'String',
                    'note' => 'Card token to make default',
                    'required' => 0,
                ),
                array(
                    'field' => 'location',
                    'dataType' => array(
                        array(
                            'field' => 'lat',
                            'dataType' => 'float',
                            'note' => 'Latitude : range -90 to 90',
                            'required' => 1,
                        ),
                        array(
                            'field' => 'lng',
                            'dataType' => 'float',
                            'note' => 'Latitude : range -180 to 180',
                            'required' => 1,
                        ),
                    ),
                    'note' => 'Location array',
                    'required' => 0,
                ),
            ),
            'returns' => array(
                array(
                    'action' => 'Success',
                    'httpCode' => 200,
                    'note' => 'User updated',
                    'example' => '{"http_status_code":200,"system_code":700,"message":"User updated","data":{"id":"35","first_name":"Edwin","last_name":"Mugendi","phone":"+254722906836","dob":"0000-00-00","gender":"","email":"edwinmugendi@gmail.com","address":"","postal_code":"","token":"jdkgnjniiflbye5xojemmphpdst0bsdw","vrm":"","card":"","fb_uid":"","lat":"90.0000000000","lng":"11.0000000000","points":"0","notify_sms":"1","notify_push":"1","notify_email":"1","os":"ios","push_token":"sdfaf","app_version":"asd","created_at":"2016-02-06 02:16:38","updated_at":"2016-02-06 02:36:45","stripe_id":"cus_7qwTckPJkETZwp","agent":"Mozilla\/5.0 (X11; Linux x86_64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/46.0.2490.80 Safari\/537.36"}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"http_status_code":400,"system_code":900,"message":"Input validation failed.","data":[{"field":"token","error":"Invalid login token"}]}'
                ),
            )
        ),
        array(
            'name' => 'Forgot Password',
            'note' => 'Send forgot password email or SMS<br>'
            . 'if send_to parameter is an email or phone number we\'ll send the code on email or SMS and the user should use the code in the reset password screen',
            'filtered' => 0,
            'endpoint' => '/api/forgot_password',
            'httpVerb' => 'POST',
            'parameters' => array(
                array(
                    'field' => 'format',
                    'dataType' => 'string',
                    'note' => 'Must be \'json\'',
                    'required' => 1,
                ),
                array(
                    'field' => 'send_to',
                    'dataType' => 'string',
                    'note' => 'Can be either the users email or phone number',
                    'required' => 1,
                ),
            ),
            'returns' => array(
                array(
                    'action' => 'Success',
                    'httpCode' => 200,
                    'note' => 'Sent reset password',
                    'example' => '{"http_status_code":200,"system_code":700,"message":"We\'ve sent you reset email.","data":[]}'
                ),
                array(
                    'action' => 'Not found',
                    'httpCode' => 404,
                    'note' => 'User not found',
                    'example' => '{"http_status_code":404,"system_code":904,"message":"User not found.","data":{"field":"email","type":"User","value":"edwinmugendi@gmail.com1"}}'
                ),
            )
        ),
        array(
            'name' => 'Reset Password',
            'note' => 'Reset a user password',
            'filtered' => 0,
            'endpoint' => '/user/reset_password',
            'httpVerb' => 'POST',
            'parameters' => array(
                array(
                    'field' => 'email',
                    'dataType' => 'string',
                    'note' => 'Email address',
                    'required' => 1,
                ),
                array(
                    'field' => 'password',
                    'dataType' => 'string',
                    'note' => 'Password',
                    'required' => 1,
                ),
                array(
                    'field' => 'reset_code',
                    'dataType' => 'string',
                    'note' => 'Reset code',
                    'required' => 1,
                ),
            ),
            'returns' => array(
                array(
                    'action' => 'Success',
                    'httpCode' => 200,
                    'note' => 'Password reset',
                    'example' => '{"http_status_code":200,"system_code":700,"message":"Your password has been reset","data":["35"]}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation Error',
                    'example' => '{"http_status_code":400,"system_code":900,"message":"Input validation failed.","data":[{"field":"reset_code","error":"Invalid email or reset code or expired reset code (Expires after 60 minutes)"}]}'
                ),
            )
        ),
        array(
            'name' => 'Is Email Available?',
            'note' => 'Check a email address is available?<br>'
            . '<i>data</i> is 1 if email is available<br>'
            . '<i>data</i> is 0 if email is not available<br>'
            . '',
            'filtered' => 0,
            'endpoint' => '/api/is_email_available',
            'httpVerb' => 'GET',
            'parameters' => array(
                array(
                    'field' => 'email',
                    'dataType' => 'string',
                    'note' => 'Email address',
                    'required' => 1,
                )
            ),
            'returns' => array(
                array(
                    'action' => 'Success',
                    'httpCode' => 200,
                    'note' => 'Email is available or not',
                    'example' => '{"http_status_code":200,"system_code":700,"message":"Succeed.","data":0}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"http_status_code":400,"system_code":900,"message":"Input validation failed.","data":[{"field":"email","error":"The email format is invalid."}]}'
                ),
            )
        ),
        array(
            'name' => 'Add or Update Vehicle',
            'note' => 'Add or update a user\s vehicle',
            'filtered' => 1,
            'endpoint' => '/user/vehicle/add',
            'httpVerb' => 'POST',
            'parameters' => array(
                array(
                    'field' => 'vrm',
                    'dataType' => 'string',
                    'note' => 'Vehicle registration mark',
                    'required' => 1,
                ),
                array(
                    'field' => 'is_default',
                    'dataType' => 'integer boolean',
                    'note' => '1 to set VRM as default, 0 if you dont want to',
                    'required' => 1,
                ),
                array(
                    'field' => 'force',
                    'dataType' => 'integer boolean',
                    'note' => '1 to force create, 0 if you dont want to force create',
                    'required' => 1,
                ),
                array(
                    'field' => 'type',
                    'dataType' => 'string',
                    'note' => 'Set \'1\' for car and 2 for 4X4',
                    'required' => 1,
                ),
                array(
                    'field' => 'purpose',
                    'dataType' => 'string',
                    'note' => 'Set \'personal\' or \'business\' in lowercase',
                    'required' => 1,
                ),
                array(
                    'field' => 'token',
                    'dataType' => 'string',
                    'note' => 'User API token',
                    'required' => 1,
                )
            ),
            'returns' => array(
                array(
                    'action' => 'Success',
                    'httpCode' => 200,
                    'note' => 'Vehicle added',
                    'example' => '{"httpStatusCode":200,"systemCode":700,"message":"Vehicle KANa added.","data":{"id":"1","vrm":"KANa"}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"httpStatusCode":400,"systemCode":900,"message":"Input validation failed.","data":[{"field":"vrm","error":"The vrm field is required."}]}'
                ),
            )
        ),
        array(
            'name' => 'Delete Vehicle',
            'note' => 'Delete user vehicle',
            'filtered' => 1,
            'endpoint' => '/user/vehicle/delete',
            'httpVerb' => 'POST',
            'parameters' => array(
                array(
                    'field' => 'vrm',
                    'dataType' => 'string',
                    'note' => 'Vehicle registration mark',
                    'required' => 1,
                ),
                array(
                    'field' => 'token',
                    'dataType' => 'string',
                    'note' => 'User API token',
                    'required' => 1,
                )
            ),
            'returns' => array(
                array(
                    'action' => 'Success',
                    'httpCode' => 200,
                    'note' => 'Vehicle deleted',
                    'example' => '{"httpStatusCode":200,"systemCode":700,"message":"Vehicle KANa deleted","data":{"id":"1","vrm":"KANa"}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"httpStatusCode":400,"systemCode":900,"message":"Input validation failed.","data":[{"field":"vrm","error":"The vrm field is required."}]}'
                ),
                array(
                    'action' => 'Not found',
                    'httpCode' => 404,
                    'note' => 'Object not found',
                    'example' => '{"httpStatusCode":404,"systemCode":904,"message":"Vehicle with vrm \'KANaasd\' not found.","data":{"field":"vrm","type":"Vehicle","value":"KANaasd"}}'
                ),
            )
        ),
        array(
            'name' => 'Get Single Vehicle by VRM',
            'note' => 'Get a single vehicle\'s details by vrm',
            'filtered' => 1,
            'endpoint' => '/user/vehicle/get/{field}/{value}',
            'httpVerb' => 'GET',
            'parameters' => array(
                array(
                    'field' => 'field',
                    'dataType' => 'string',
                    'note' => 'Must be set to \'vrm\'. Set this in the url not query string',
                    'required' => 1,
                ),
                array(
                    'field' => 'value',
                    'dataType' => 'string',
                    'note' => 'Actual vrm value. Set this in the url not query string',
                    'required' => 1,
                ),
                array(
                    'field' => 'token',
                    'dataType' => 'string',
                    'note' => 'User API token',
                    'required' => 1,
                )
            ),
            'returns' => array(
                array(
                    'action' => 'Success',
                    'httpCode' => 200,
                    'note' => 'Vehicle found',
                    'example' => '{"httpStatusCode":200,"systemCode":700,"message":"Vehicle vrm Kana found.","data":{"id":"3","vrm":"KANa","type":"2","combined_make":"","model_range_desc":"","drive_type":"","created_at":"2014-05-30 13:13:56","updated_at":"2014-05-30 13:13:56","user_owns":1,"is_default":0}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"httpStatusCode":400,"systemCode":900,"message":"Input validation failed.","data":[{"field":"field","error":"The field field is required."}]}'
                ),
                array(
                    'action' => 'Forbidden',
                    'httpCode' => 403,
                    'note' => 'Forbidden or Don\'t Own Object',
                    'example' => '{"httpStatusCode":403,"systemCode":903,"message":"Forbidden or Don\'t own","data":{"field":"vrm","type":"Vehicle","value":"123"}}'
                ),
                array(
                    'action' => 'Not found',
                    'httpCode' => 404,
                    'note' => 'Object not found',
                    'example' => '{"httpStatusCode":404,"systemCode":904,"message":"Vehicle with vrm \'KANa11\' not found.","data":{"field":"vrm","type":"Vehicle","value":"KANa11"}}'
                ),
            )
        ),
        array(
            'name' => 'Get All Vehicle',
            'note' => 'Get all users vehicles',
            'filtered' => 1,
            'endpoint' => '/user/vehicle/get',
            'httpVerb' => 'GET',
            'parameters' => array(
                array(
                    'field' => 'token',
                    'dataType' => 'string',
                    'note' => 'User API token',
                    'required' => 1,
                )
            ),
            'returns' => array(
                array(
                    'action' => 'Success',
                    'httpCode' => 200,
                    'note' => 'Vehicles found',
                    'example' => '{"httpStatusCode":200,"systemCode":700,"message":"Your vehicles list","data":[{"id":"3","vrm":"KANa","type":"2","combined_make":"","model_range_desc":"","drive_type":"","created_at":"2014-05-30 13:13:56","updated_at":"2014-05-30 13:13:56","user_owns":1,"is_default":0}]}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"httpStatusCode":400,"systemCode":900,"message":"Input validation failed.","data":[{"field":"vrm","error":"The vrm field is required."}]}'
                ),
            )
        ),
    )
);
