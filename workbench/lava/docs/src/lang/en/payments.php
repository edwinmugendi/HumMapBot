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
            'name' => 'Create card',
            'note' => 'Delete card on Stripe and our database<br>'
            . 'Go to this link \'' . \URL::to('card/test/form') . '\' to generate test stripe token',
            'filtered' => 1,
            'endpoint' => 'api/create/card',
            'httpVerb' => 'POST',
            'parameters' => array(
                array(
                    'field' => 'stripe_token',
                    'dataType' => 'string',
                    'note' => 'Stripe token<br> Add the card to Stripe from the app and get a token. Use this token<br>'
                    . 'Go to this link \'' . \URL::to('card/test/form') . '\' to generate test stripe token',
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
                    'note' => 'Card deleted',
                    'example' => '{"http_status_code":200,"system_code":700,"message":"Card created","data":{"user_id":"35","gateway":"stripe","token":"card_17bxGUHoXD8pWa1AENveEDFi","brand":"visa","last4":"4242","exp_month":12,"exp_year":2020,"address_city":"","address_zip":"","address_country":"","address_line1":"","status":1,"updated_at":"2016-02-07 18:28:19","created_at":"2016-02-07 18:28:19","id":28,"is_default":0,"stripe_id":"cus_7qwTckPJkETZwp","user":{"id":"35","first_name":"Edwin","last_name":"Mugendi","phone":"+254722906836","dob":"0000-00-00","gender":"","email":"edwinmugendi@gmail.com","address":"","postal_code":"","token":"jdkgnjniiflbye5xojemmphpdst0bsdw","vrm":"","card":"","fb_uid":"","lat":"90.0000000000","lng":"11.0000000000","points":"0","notify_sms":"1","notify_push":"1","notify_email":"1","os":"ios","device_token":"sdfaf","app_version":"asd","created_at":"2016-02-06 02:16:38","updated_at":"2016-02-07 10:07:26","stripe_id":"cus_7qwTckPJkETZwp","agent":"Mozilla\/5.0 (X11; Linux x86_64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/46.0.2490.80 Safari\/537.36"}}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"http_status_code":400,"system_code":900,"message":"Input validation failed.","data":[{"field":"token","error":"Invalid login token"}]}'
                ),
                array(
                    'action' => 'Server Error',
                    'httpCode' => 500,
                    'note' => '3rd party or internal server',
                    'example' => '{"http_status_code":500,"system_code":1000,"message":"Error while communicating with one of our backends.  Sorry about that!  We have been notified of the problem.  If you have any questions, we can help at https:\/\/support.stripe.com\/.","data":[]}'
                ),
            )
        ),
        array(
            'name' => 'Delete Card by Id',
            'note' => 'Delete card on Stripe and database',
            'filtered' => 1,
            'endpoint' => 'api/delete/card',
            'httpVerb' => 'POST',
            'parameters' => array(
                array(
                    'field' => 'id',
                    'dataType' => 'integer',
                    'note' => 'Lava Card id and not token',
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
                    'note' => 'Card deleted',
                    'example' => '{"http_status_code":200,"system_code":700,"message":"Card deleted","data":{"id":"28"}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"http_status_code":404,"system_code":904,"message":"Card not found.","data":{"field":"id","type":"Card","value":"22323"}}'
                ),
            )
        ),
        array(
            'name' => 'Get Single Card by Id',
            'note' => 'Get a single card\'s details by id',
            'filtered' => 1,
            'endpoint' => '/api/get/card',
            'httpVerb' => 'GET',
            'parameters' => array(
                array(
                    'field' => 'id',
                    'dataType' => 'integer',
                    'note' => 'Id of the card',
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
                    'example' => '{"http_status_code":200,"system_code":700,"message":"Card list","data":{"id":"28","user_id":"35","gateway":"stripe","exp_month":"12","exp_year":"2020","last4":"4242","brand":"visa","address_city":"","address_zip":"","address_country":"","address_line1":"","token":"card_17bxGUHoXD8pWa1AENveEDFi","status":"1","created_at":"2016-02-07 18:28:19","updated_at":"2016-02-07 18:31:04","deleted_on_stripe":"1","is_default":0,"stripe_id":"cus_7qwTckPJkETZwp"}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation Error',
                    'example' => '{"http_status_code":400,"system_code":900,"message":"Input validation failed.","data":[{"field":"token","error":"Invalid login token"}]}'
                ), array(
                    'action' => 'Not found',
                    'httpCode' => 404,
                    'note' => 'Card not found',
                    'example' => '{"http_status_code":404,"system_code":904,"message":"Card not found.","data":{"field":"card_id","type":"Card","value":"28"}}'
                )
            )
        ),
        array(
            'name' => 'Get All Card',
            'note' => 'Get all users cards',
            'filtered' => 1,
            'endpoint' => 'api/get/card',
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
                    'example' => '{"http_status_code":200,"system_code":700,"message":"Card list","data":{"total":2,"per_page":1,"current_page":1,"last_page":2,"from":1,"to":1,"data":[{"id":"29","user_id":"35","gateway":"stripe","exp_month":"12","exp_year":"2020","last4":"4242","brand":"visa","address_city":"","address_zip":"","address_country":"","address_line1":"","token":"card_17bxTBHoXD8pWa1A4K6dgQSg","status":"1","created_at":"2016-02-07 18:41:33","updated_at":"2016-02-07 18:41:33","deleted_on_stripe":"0","is_default":0,"stripe_id":"cus_7qwTckPJkETZwp","user":{"id":"35","first_name":"Edwin","last_name":"Mugendi","phone":"+254722906836","dob":"0000-00-00","gender":"","email":"edwinmugendi@gmail.com","address":"","postal_code":"","token":"jdkgnjniiflbye5xojemmphpdst0bsdw","vrm":"","card":"","fb_uid":"","lat":"90.0000000000","lng":"11.0000000000","points":"0","notify_sms":"1","notify_push":"1","notify_email":"1","os":"ios","device_token":"sdfaf","app_version":"asd","created_at":"2016-02-06 02:16:38","updated_at":"2016-02-07 10:07:26","stripe_id":"cus_7qwTckPJkETZwp","agent":"Mozilla\/5.0 (X11; Linux x86_64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/46.0.2490.80 Safari\/537.36"}}]}}'
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
            'name' => 'Get Single Transaction by Id',
            'note' => 'Get a single transaction\'s details by id',
            'filtered' => 1,
            'endpoint' => '/api/get/transaction',
            'httpVerb' => 'GET',
            'parameters' => array(
                array(
                    'field' => 'id',
                    'dataType' => 'string',
                    'note' => 'Id of the transaction',
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
                    'note' => 'Transaction found',
                    'example' => '{"http_status_code":200,"system_code":700,"message":"Transaction list","data":{"id":"4","user_id":"35","product_id":"1","location_id":"1","promotion_id":"0","amount":"2.00","refund":"0.00","currency_id":"USD","description":"Product 1 Location 1","card_used":"","card_token":"","vehicle_id":"9","vrm":"KANa","stamps_issued":"0","lat":"0.0000000000","lng":"0.0000000000","gateway":"","gateway_tran_id":"","gateway_code":"","user_smsed":"0","user_emailed":"0","user_pushed":"0","merchant_smsed":"0","merchant_emailed":"0","agent":"Mozilla\/5.0 (X11; Linux x86_64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/46.0.2490.80 Safari\/537.36","workflow":"0","created_at":"2016-02-05 20:47:30","updated_at":"2016-02-05 20:47:30","loc":{"name":"Location 1","address":""}}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"http_status_code":400,"system_code":900,"message":"Input validation failed.","data":[{"field":"token","error":"Invalid login token"}]}'
                ),
                array(
                    'action' => 'Not found',
                    'httpCode' => 404,
                    'note' => 'Transaction not found',
                    'example' => '{"http_status_code":404,"system_code":904,"message":"Transaction not found.","data":{"field":"transaction_id","type":"Transaction","value":"4"}}'
                )
            )
        ),
        array(
            'name' => 'Get All Users Transaction',
            'note' => 'Get all users transactions',
            'filtered' => 1,
            'endpoint' => 'api/get/transaction',
            'httpVerb' => 'GET',
            'parameters' => array(
                array(
                    'field' => 'page',
                    'dataType' => 'integer',
                    'note' => 'Pagination page',
                    'required' => 0,
                ),
                array(
                    'field' => 'per_page',
                    'dataType' => 'integer',
                    'note' => 'No of transactions to return. Defaults to 30',
                    'required' => 0,
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
                    'note' => 'Transactions found',
                    'example' => '{"http_status_code":200,"system_code":700,"message":"Transaction list","data":{"total":1,"per_page":30,"current_page":1,"last_page":1,"from":1,"to":1,"data":[{"id":"4","user_id":"35","product_id":"1","location_id":"1","promotion_id":"0","amount":"2.00","refund":"0.00","currency_id":"USD","description":"Product 1 Location 1","card_used":"","card_token":"","vehicle_id":"9","vrm":"KANa","stamps_issued":"0","lat":"0.0000000000","lng":"0.0000000000","gateway":"","gateway_tran_id":"","gateway_code":"","user_smsed":"0","user_emailed":"0","user_pushed":"0","merchant_smsed":"0","merchant_emailed":"0","agent":"Mozilla\/5.0 (X11; Linux x86_64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/46.0.2490.80 Safari\/537.36","workflow":"0","created_at":"2016-02-05 20:47:30","updated_at":"2016-02-05 20:47:30","loc":{"name":"Location 1","address":""}}]}}'
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
            'name' => 'Prepare Transaction',
            'note' => 'Prepare a transaction',
            'filtered' => 1,
            'endpoint' => 'api/prepare/transaction',
            'httpVerb' => 'POST',
            'parameters' => array(
                array(
                    'field' => 'product_id',
                    'dataType' => 'integer',
                    'note' => 'Product integer id',
                    'required' => 1,
                ),
                array(
                    'field' => 'vehicle_id',
                    'dataType' => 'integer',
                    'note' => 'Actual id of the vehicle and not VRM',
                    'required' => 0,
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
                    'example' => '{"http_status_code":200,"system_code":700,"message":"Transaction prepared","data":{"card":{"id":"29","gateway":"stripe","exp_month":"12","exp_year":"2020","last4":"4242","brand":"visa","token":"card_17bxTBHoXD8pWa1A4K6dgQSg"},"vehicle":{"vehicle_id":"20","type":"2"},"transaction":{"amount":"3.00","currency_id":"USD","surcharge":"0.00","promotions":[{"price":"2","id":"1","description":"Promotion 1","expiry_date":"2016-02-20 00:00:00","code":"PROMO","type":"1","value":"1.00"}]}}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"http_status_code":400,"system_code":900,"message":"Input validation failed.","data":[{"field":"token","error":"Invalid login token"}]}'
                ),
                array(
                    'action' => 'Not found',
                    'httpCode' => 404,
                    'note' => 'Object not found',
                    'example' => '{"http_status_code":404,"system_code":904,"message":"Product not found.","data":{"field":"id","type":"Product","value":"234"}}'
                ),
            ),
        ),
        array(
            'name' => 'Process Transaction',
            'note' => 'Process a transaction',
            'filtered' => 1,
            'endpoint' => 'api/process/transaction',
            'httpVerb' => 'POST',
            'parameters' => array(
                array(
                    'field' => 'product_id',
                    'dataType' => 'integer',
                    'note' => 'Product integer id',
                    'required' => 1,
                ),
                array(
                    'field' => 'vehicle_id',
                    'dataType' => 'integer',
                    'note' => 'Actual id of the vehicle and not VRM',
                    'required' => 1,
                ),
                array(
                    'field' => 'promition_id',
                    'dataType' => 'integer',
                    'note' => 'Promotion integer id',
                    'required' => 1,
                ),
                array(
                    'field' => 'card_token',
                    'dataType' => 'string',
                    'note' => 'Card token to be used',
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
                    'required' => 1,
                ),
            ),
            'returns' => array(
                array(
                    'action' => 'Success',
                    'httpCode' => 200,
                    'note' => 'Transaction processed',
                    'example' => '{"http_status_code":200,"system_code":700,"message":"Transaction successful","data":{"gateway":{"status":1,"message":"Transaction successful"},"transaction":{"vehicle_id":"20","vrm":"KANa","user_id":"35","description":"Product 1 Location 1","product_id":"1","location_id":"1","agent":"Mozilla\/5.0 (X11; Linux x86_64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/46.0.2490.80 Safari\/537.36","amount":"2","currency_id":"USD","stamps_issued":1,"updated_at":"2016-02-07 19:27:14","created_at":"2016-02-07 19:27:02","id":27,"lat":"-1.3920700000","lng":"36.8219500000","gateway":"stripe","workflow":1,"gateway_tran_id":"ch_17byBaHoXD8pWa1Ab0VuEpA2","promotion_id":"1","card_used":"visa XXX 4242","card_token":"card_17byAnHoXD8pWa1AEbP9694K","merchant_emailed":1,"merchant_smsed":1,"user_pushed":1,"user_smsed":1,"user_emailed":1,"loc":{"name":"Location 1","address":""}},"stamps":{"issued":1,"user_total":1,"location_stamps":2}}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"http_status_code":400,"system_code":900,"message":"Input validation failed.","data":[{"field":"token","error":"Invalid login token"}]}'
                ),
                array(
                    'action' => 'Not found',
                    'httpCode' => 404,
                    'note' => 'Object not found',
                    'example' => '{"http_status_code":404,"system_code":904,"message":"Product not found.","data":{"field":"id","type":"Product","value":"2"}}'
                ),
                array(
                    'action' => 'Not allowed',
                    'httpCode' => 403,
                    'note' => 'Not allowed',
                    'example' => '{"http_status_code":403,"system_code":903,"message":"Your not close enough to the Car Wash to process a transaction. Please attempt again when at the location.","data":{"field":"gps","type":"Distance","value":"Invalid"}}'
                ),
                array(
                    'action' => 'Internal server error',
                    'httpCode' => 500,
                    'note' => 'Internal Sever Error',
                    'example' => '{"http_status_code":500,"system_code":1000,"message":"Lost connection to the database","data":[]}'
                ),
            ),
        ),
        array(
            'name' => 'Process Transaction with Loyalty Stamps',
            'note' => 'Process a transaction with Loyalty stamps',
            'filtered' => 1,
            'endpoint' => 'api/process/transaction_with_loyalty_stamps',
            'httpVerb' => 'POST',
            'parameters' => array(
                array(
                    'field' => 'product_id',
                    'dataType' => 'integer',
                    'note' => 'Product integer id',
                    'required' => 1,
                ),
                array(
                    'field' => 'vehicle_id',
                    'dataType' => 'integer',
                    'note' => 'Actual id of the vehicle and not VRM',
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
                    'required' => 1,
                ),
            ),
            'returns' => array(
                array(
                    'action' => 'Success',
                    'httpCode' => 200,
                    'note' => 'Transaction processed',
                    'example' => '{"http_status_code":200,"system_code":700,"message":"Transaction successful","data":{"gateway":{"status":1,"message":"Transaction successful"},"transaction":{"vehicle_id":"20","vrm":"KANa","gateway":"stamps","amount":"3.00","currency_id":"USD","description":"Free Stamp Wash","user_id":"35","product_id":"1","location_id":"1","agent":"Mozilla\/5.0 (X11; Linux x86_64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/46.0.2490.80 Safari\/537.36","stamps_issued":0,"workflow":3,"lat":"-1.3920700000","lng":"36.8219500000","updated_at":"2016-02-07 19:35:16","created_at":"2016-02-07 19:35:06","id":29,"merchant_emailed":1,"merchant_smsed":1,"user_pushed":1,"user_smsed":1,"user_emailed":1,"loc":{"name":"Location 1","address":""}},"stamps":{"issued":0,"user_total":0,"location_stamps":"2"}}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"http_status_code":400,"system_code":900,"message":"Input validation failed.","data":[{"field":"vehicle_id","error":"Product 1 requires 2 but you have 0"}]}'
                ),
                array(
                    'action' => 'Not found',
                    'httpCode' => 404,
                    'note' => 'Object not found',
                    'example' => '{"http_status_code":404,"system_code":904,"message":"Product not found.","data":{"field":"id","type":"Product","value":"4"}}'
                ),
                array(
                    'action' => 'Not allowed',
                    'httpCode' => 403,
                    'note' => 'Not allowed',
                    'example' => '{"http_status_code":403,"system_code":903,"message":"Your not close enough to the Car Wash to process a transaction. Please attempt again when at the location.","data":{"field":"gps","type":"Distance","value":"Invalid"}}'
                ),
                array(
                    'action' => 'Internal server error',
                    'httpCode' => 500,
                    'note' => 'Internal Sever Error',
                    'example' => '{"http_status_code":500,"system_code":1000,"message":"Lost connection to the database","data":[]}'
                ),
            ),
        ),
    )
);
