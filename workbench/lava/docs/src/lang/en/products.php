<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | Payments Language Lines
      |--------------------------------------------------------------------------
     */
    'module' => array(
        'name' => 'Products',
        'note' => 'Products module'
    ),
    'api' => array(
        array(
            'name' => 'Claim Promotion',
            'note' => 'Claim a promotion code',
            'filtered' => 1,
            'endpoint' => 'api/claim/promotion',
            'httpVerb' => 'POST',
            'parameters' => array(
                array(
                    'field' => 'promotion_code',
                    'dataType' => 'string',
                    'note' => 'Promotion Code.',
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
                    'note' => 'Promotion claimed',
                    'example' => '{"http_status_code":200,"system_code":700,"message":"Promotion code PROMO redeemed.","data":{"id":"1"}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"http_status_code":400,"system_code":900,"message":"Input validation failed.","data":[{"field":"promotion_code","error":"You have already redeemed this promotion code PROMO"}]}'
                ),
                array(
                    'action' => 'Not found',
                    'httpCode' => 404,
                    'note' => 'Object not found',
                    'example' => '{"http_status_code":404,"system_code":904,"message":"Promotion not found.","data":{"field":"code","type":"Promotion","value":"PROMOa"}}'
                ),
            )
        ),
        array(
            'name' => 'Get Single Promotion by Id',
            'note' => 'Get a single promotion\'s details by id',
            'filtered' => 1,
            'endpoint' => '/api/get/promotion',
            'httpVerb' => 'GET',
            'parameters' => array(
                array(
                    'field' => 'id',
                    'dataType' => 'string',
                    'note' => 'Id of the promotion',
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
                    'note' => 'Promotion found',
                    'example' => '{"http_status_code":200,"system_code":700,"message":"Promotion list","data":{"id":"4","location_id":"0","code":"PROMO","description":"PROMO","type":"1","value":"10.00","new_customer":"0","expiry_date":"2016-03-05","status":"1","created_by":"36","updated_by":"36","created_at":"2016-03-04 11:42:11","updated_at":"2016-03-04 11:42:11","organization_id":"1","ip":"127.0.0.1","agent":"Mozilla\/5.0 (X11; Linux x86_64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/46.0.2490.80 Safari\/537.36","user_owns":1}}'
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
                    'note' => 'Promotion not found',
                    'example' => '{"http_status_code":404,"system_code":904,"message":"Promotion not found.","data":{"field":"promotion_code","type":"Promotion","value":"PROMOasda"}}'
                )
            )
        ),
        array(
            'name' => 'Get All Users Promotion',
            'note' => 'Get all users promotions',
            'filtered' => 1,
            'endpoint' => 'api/get/promotion',
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
                    'note' => 'No of promotions to return. Defaults to 30',
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
                    'note' => 'Promotions found',
                    'example' => '{"http_status_code":200,"system_code":700,"message":"Promotion list","data":{"total":1,"per_page":30,"current_page":1,"last_page":1,"from":1,"to":1,"data":[{"id":"4","location_id":"0","code":"PROMO","description":"PROMO","type":"1","value":"10.00","new_customer":"0","expiry_date":"2016-03-05","status":"1","created_by":"36","updated_by":"36","created_at":"2016-03-04 11:42:11","updated_at":"2016-03-04 11:42:11","organization_id":"1","ip":"127.0.0.1","agent":"Mozilla\/5.0 (X11; Linux x86_64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/46.0.2490.80 Safari\/537.36","user_owns":1}]}}'
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
            'name' => 'Referred by',
            'note' => 'When sign up, specify who referred you',
            'filtered' => 1,
            'endpoint' => 'api/referred_by',
            'httpVerb' => 'POST',
            'parameters' => array(
                array(
                    'field' => 'referral_code',
                    'dataType' => 'string',
                    'note' => 'Referral Code.',
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
                    'note' => 'Referral created',
                    'example' => '{"http_status_code":200,"system_code":700,"message":"Referral created","data":{"id":7}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"http_status_code":400,"system_code":900,"message":"Input validation failed.","data":[{"field":"promotion_code","error":"You have already redeemed this promotion code PROMO"}]}'
                ),
                array(
                    'action' => 'Not found',
                    'httpCode' => 404,
                    'note' => 'Object not found',
                    'example' => '{"http_status_code":404,"system_code":904,"message":"Referral code not found.","data":{"field":"referral_code","type":"Referral code","value":"edwin456212"}}'
                ),
            )
        ),
    )
);
