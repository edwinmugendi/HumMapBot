<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | Payments Language Lines
      |--------------------------------------------------------------------------
     */
    'module' => array(
        'name' => 'Payments',
        'note' => 'Payments module'
    ),
    'api' => array(
        array(
            'name' => 'Sync Cards',
            'note' => 'Sync cards on App55',
            'filtered' => 1,
            'endpoint' => '/payment/app55/sync',
            'httpVerb' => 'POST',
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
                    'note' => 'Card\'s synced',
                    'example' => '{"httpStatusCode":200,"systemCode":700,"message":"Card\'s synced.","data":["NTQGu","Bulan"]}'
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
            'name' => 'Prepare Transaction',
            'note' => 'Prepare a transaction',
            'filtered' => 1,
            'endpoint' => '/payment/transaction/prepare',
            'httpVerb' => 'POST',
            'parameters' => array(
                array(
                    'field' => 'product_id',
                    'dataType' => 'integer',
                    'note' => 'Product integer id',
                    'required' => 1,
                ),
                array(
                    'field' => 'vrm',
                    'dataType' => 'string',
                    'note' => 'Vehicle Registration Mark',
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
                    'note' => 'Transaction prepared',
                    'example' => '{"httpStatusCode":200,"systemCode":700,"message":"Transaction prepared","data":{"card":{"id":"1","user_id":"1","gateway_id":"1","name":"","number":"442244******4444","address_street":"test address","address_city":"manchester","address_postal_code":"m13df","address_country":"GB","token":"NTQGu","expiry":"0000-00-00 00:00:00","created_at":"2014-05-07 17:08:35","updated_at":"2014-05-07 17:08:35"},"promotions":[{"id":"1","type":"2","value":"0"}],"vehicle":{"vrm":"KANa","drive_type":"4X2"},"product":{"id":"1","price_4X2":"12.00","price_4X4":"12"},"transaction":{"surcharge":"1.00","currency":"GBP"}}}'
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
                    'example' => '{"httpStatusCode":404,"systemCode":904,"message":"Product with id \'121\' not found.","data":{"field":"id","type":"Product","value":"121"}}'
                ),
            ),
        ),
        array(
            'name' => 'Process Transaction',
            'note' => 'Process a transaction',
            'filtered' => 1,
            'endpoint' => '/payment/transaction/process',
            'httpVerb' => 'POST',
            'parameters' => array(
                array(
                    'field' => 'product_id',
                    'dataType' => 'integer',
                    'note' => 'Product integer id',
                    'required' => 1,
                ),
                array(
                    'field' => 'vrm',
                    'dataType' => 'string',
                    'note' => 'Vehicle Registration Mark',
                    'required' => 1,
                ),
                array(
                    'field' => 'promition_id',
                    'dataType' => 'integer',
                    'note' => 'Promotion integer id',
                    'required' => 1,
                ),
                array(
                    'field' => 'amount',
                    'dataType' => 'float (2 Decimal place)',
                    'note' => 'Calculated amount',
                    'required' => 1,
                ),
                array(
                    'field' => 'currency',
                    'dataType' => 'string',
                    'note' => '3 letter currency code',
                    'required' => 1,
                ),
                array(
                    'field' => 'card_token',
                    'dataType' => 'string',
                    'note' => 'Card to be used',
                    'required' => 1,
                ),
                array(
                    'field' => 'token',
                    'dataType' => 'string',
                    'note' => 'User API token',
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
                    'note' => 'Transaction processed',
                    'example' => '{"httpStatusCode":200,"systemCode":700,"message":["id"],"data":{"gateway_tran_id":"140511172721_11582","gateway_code":"06603","amount":"12","currency":"GBP","description":"1","user_id":"1","product_id":"1","lat":"90","lng":"90","promotion_id":"1","updated_at":"2014-05-11 17:27:21","created_at":"2014-05-11 17:27:21","id":3}}'
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
                    'example' => '{"httpStatusCode":404,"systemCode":904,"message":"Product with id \'121\' not found.","data":{"field":"id","type":"Product","value":"121"}}'
                ),
            ),
        ),
        array(
            'name' => 'Get Single Card by Card Token',
            'note' => 'Get a single card\'s details by card token',
            'filtered' => 1,
            'endpoint' => '/payment/app55/get/{card_token}',
            'httpVerb' => 'GET',
            'parameters' => array(
                array(
                    'field' => 'card_token',
                    'dataType' => 'string',
                    'note' => 'Card token Set this in the url not query string',
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
                    'note' => 'Card found',
                    'example' => '{"httpStatusCode":200,"systemCode":700,"message":"Card token NTQGu found.","data":{"id":"1","user_id":"1","gateway_id":"1","name":"","number":"442244******4444","address_street":"test address","address_city":"manchester","address_postal_code":"m13df","address_country":"GB","token":"NTQGu","expiry":"0000-00-00 00:00:00","created_at":"2014-05-07 17:08:35","updated_at":"2014-05-07 17:08:35"}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"httpStatusCode":400,"systemCode":900,"message":"Input validation failed.","data":[{"field":"token","error":"Invalid login token"}]}'
                ),
                array(
                    'action' => 'Forbidden',
                    'httpCode' => 403,
                    'note' => 'Forbidden or Don\'t Own Object',
                    'example' => '{"httpStatusCode":403,"systemCode":903,"message":"Forbidden or Don\'t own","data":{"field":"token","type":"Card","value":"NTQGu"}}'
                ),
                array(
                    'action' => 'Not found',
                    'httpCode' => 404,
                    'note' => 'Object not found',
                    'example' => '{"httpStatusCode":404,"systemCode":904,"message":"Card with token \'XYZ\' not found.","data":{"field":"token","type":"Card","value":"XYZ"}}'
                ),
            )
        ),
        array(
            'name' => 'Get All Card',
            'note' => 'Get all users cards',
            'filtered' => 1,
            'endpoint' => '/payment/app55/get',
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
                    'note' => 'Cards found',
                    'example' => '{"httpStatusCode":200,"systemCode":700,"message":"Card\'s list","data":[{"id":"1","user_id":"1","gateway_id":"1","name":"","number":\"442244******4444","address_street":"test address","address_city":"manchester","address_postal_code":"m13df","address_country":"GB","token":"NTQGu","expiry":"0000-00-00 00:00:00","created_at":"2014-05-07 17:08:35","updated_at":"2014-05-07 17:08:35"},{"id":"2","user_id":"1","gateway_id":"1","name":"","number":"447815******2688","address_street":"Nairobi","address_city":"Nairobi","address_postal_code":"00200","address_country":"UG","token":"Bulan","expiry":"0000-00-00 00:00:00","created_at":"2014-05-07 17:08:35","updated_at":"2014-05-07 17:08:35"}]}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"httpStatusCode":400,"systemCode":900,"message":"Input validation failed.","data":[{"field":"token","error":"Invalid login token"}]}'
                ),
            )
        ),
    )
);
