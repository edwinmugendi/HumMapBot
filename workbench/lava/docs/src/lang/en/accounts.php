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
            'endpoint' => '/user/register',
            'httpVerb' => 'POST',
            'parameters' => array(
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
                    'note' => 'Password',
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
                    'note' => 'User created succefully',
                    'example' => '{"httpStatusCode":200,"systemCode":700,"message":"Your account has been created on Lava app","data":{"id":48}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"httpStatusCode":200,"systemCode":700,"message":"Your account has been created on Lava app","data":{"id":48}}'
                ),
            )
        ),
        array(
            'name' => 'Login',
            'note' => 'Login a user <br>'
            . '<br> For improved security a new token is generated everytime you login'
            . 'Securely save the returned <i>token</i> that will used to access all endpoints that need the user to be logged in.',
            'filtered' => 0,
            'endpoint' => '/user/login',
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
                )
            ),
            'returns' => array(
                array(
                    'action' => 'Success',
                    'httpCode' => 200,
                    'note' => 'Logged in',
                    'example' => '{"httpStatusCode":200,"systemCode":700,"message":"Logged in","data":{"token":"jdkgnjniiflbye5xojemmphpdst0bsdw"}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"httpStatusCode":400,"systemCode":900,"message":"Input validation failed.","data":[{"field":"password","error":"The email or password you entered is incorrect."}]}'
                ),
            )
        ),
        array(
            'name' => 'Facebook Login',
            'note' => 'Login a user <br>'
            . '<br> For improved security a new token is generated everytime you login'
            . 'Securely save the returned <i>token</i> that will used to access all endpoints that need the user to be logged in.',
            'filtered' => 0,
            'endpoint' => '/user/facebook_login',
            'httpVerb' => 'POST',
            'parameters' => array(
                array(
                    'field' => 'facebook_token',
                    'dataType' => 'string',
                    'note' => 'Token from facebook',
                    'required' => 1,
                )
            ),
            'returns' => array(
                array(
                    'action' => 'Success',
                    'httpCode' => 200,
                    'note' => 'Logged in',
                    'example' => '{"httpStatusCode":200,"systemCode":700,"message":"Logged in","data":{"token":"l4tjo9l165qx01i3ak8uupmbr6ueaosp"}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"httpStatusCode":400,"systemCode":900,"message":"Input validation failed.","data":[{"field":"facebook_token","error":"No user found on Facebook with such token"}]}'
                ),
            )
        ),
        array(
            'name' => 'Get Profile',
            'note' => 'Get a logged in user\'s profile identified by the token',
            'filtered' => 1,
            'endpoint' => '/user/profile',
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
                    'note' => 'Got profile',
                    'example' => '{"httpStatusCode":200,"systemCode":700,"message":"Succeed.","data":{"id":"1","first_name":"Edwin","last_name":"Mugendi","phone":"+254722906836","dob":"2014-12-12 00:00:00","gender":"","email":"edwinmugendi@gmail.com","address":"2014-12-12","postal_code":"","token":"jdkgnjniiflbye5xojemmphpdst0bsdw","default_vrm":"KANa","fb_uid":"0","lat":"12.00","lng":"0.00","card":"NTQGu","created_at":"2014-04-17 06:30:21","updated_at":"2014-05-09 10:27:35","push_attempts":"0","role_id":"0"}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"httpStatusCode":400,"systemCode":900,"message":"Input validation failed.","data":[{"field":"token","error":"Invalid login token"}]}'
                ),
            )
        ),
        array(
            'name' => 'Update User Profile',
            'note' => 'Update a users profile',
            'filtered' => 1,
            'endpoint' => '/user/update',
            'httpVerb' => 'POST',
            'parameters' => array(
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
                    'field' => 'password',
                    'dataType' => 'string',
                    'note' => 'Password',
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
                    'example' => '{"httpStatusCode":200,"systemCode":700,"message":"Your details have been updated","data":{"id":"1","first_name":"Edwin","last_name":"Mugendi","phone":"+254722906836","dob":"2014-12-12 00:00:00","gender":"","email":"edwinmugendi@gmail.com","address":"2014-12-12","postal_code":"","token":"jdkgnjniiflbye5xojemmphpdst0bsdw","default_vrm":"KANa","fb_uid":"0","lat":"12.00","lng":"0.00","card":"NTQGu","created_at":"2014-04-17 06:30:21","updated_at":"2014-05-09 12:55:42","push_attempts":"0","role_id":"0"}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"httpStatusCode":400,"systemCode":900,"message":"Input validation failed.","data":[{"field":"location","error":"Latitude (range -90 to 90) or longitude (range 180 to -180) missing or not valid"}]}'
                ),
            )
        ),
        array(
            'name' => 'Forgot Password',
            'note' => 'Send forgot password email',
            'filtered' => 0,
            'endpoint' => '/user/forgot_password',
            'httpVerb' => 'POST',
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
                    'note' => 'Sent reset password',
                    'example' => '{"httpStatusCode":200,"systemCode":700,"message":"We\'ve sent you reset email.","data":{"reset_code":"sj0lcsq18r"}}'
                ),
                array(
                    'action' => 'Not found',
                    'httpCode' => 404,
                    'note' => 'Object not found',
                    'example' => '{"httpStatusCode":404,"systemCode":904,"message":"User with email \'john.doe@gmail.com\' not found.","data":{"field":"email","type":"User","value":"edwinmugendi@gmail.com1"}}'
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
                    'example' => '{"httpStatusCode":200,"systemCode":700,"message":"Your password has been reset","data":["1"]}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation Error',
                    'example' => '{"httpStatusCode":400,"systemCode":900,"message":"Input validation failed.","data":[{"field":"reset_code","error":"Invalid email or reset code or expired reset code (Expires after 60 minutes)"}]}'
                ),
            )
        ),
        array(
            'name' => 'Is Email Available?',
            'note' => 'Check a email address is available?<br>'
            . '<i></i> is 1 if email is available<br>'
            . '<i></i> is 0 if email is not available<br>'
            . '',
            'filtered' => 0,
            'endpoint' => '/user/is_email_available',
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
                    'example' => '{"httpStatusCode":200,"systemCode":700,"message":"Succeed.","data":0}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"httpStatusCode":400,"systemCode":900,"message":"Input validation failed.","data":[{"field":"email","error":"The email field is required."}]}'
                ),
            )
        ),
        array(
            'name' => 'Add Vehicle',
            'note' => 'Add user vehicle',
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
                    'field' => 'check_registry',
                    'dataType' => 'integer boolean',
                    'note' => '1 to check car registry, 0 if you dont want to',
                    'required' => 1,
                ),
                array(
                    'field' => 'purpose',
                    'dataType' => 'string',
                    'note' => 'Set \'personal\' or \'business\'',
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
            'endpoint' => '/user/vehicle/get/{vrm}',
            'httpVerb' => 'GET',
            'parameters' => array(
                array(
                    'field' => 'vrm',
                    'dataType' => 'string',
                    'note' => 'VRM Set this in the url not query string',
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
                    'example' => '{"httpStatusCode":200,"systemCode":700,"message":"Vehicle vrm KANa found.","data":{"id":"1","vrm":"KANa","created_at":"2014-04-22 09:03:13","updated_at":"2014-04-22 09:03:13","drive_type":"4X2","user_owns":1,"pivot":{"user_id":"1","vehicle_id":"1"}}}'
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
                    'example' => '{"httpStatusCode":200,"systemCode":700,"message":"Your vehicles list","data":[{"id":"1","vrm":"KANa","created_at":"2014-04-22 09:03:13","updated_at":"2014-04-22 09:03:13","drive_type":"4X2","user_owns":1,"pivot":{"user_id":"1","vehicle_id":"1"}},{"id":"2","vrm":"KANaa","created_at":"2014-04-22 09:59:00","updated_at":"2014-04-22 09:59:00","drive_type":"","user_owns":1,"pivot":{"user_id":"1","vehicle_id":"2"}},{"id":"4","vrm":"123","created_at":"2014-05-09 10:35:52","updated_at":"2014-05-09 10:35:52","drive_type":"","user_owns":1,"pivot":{"user_id":"1","vehicle_id":"4"}}]}'
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
