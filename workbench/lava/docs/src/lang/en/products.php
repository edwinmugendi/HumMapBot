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
            'name' => 'Get Single Promotion by id',
            'note' => 'Get a single promotion\'s details by promotion id',
            'filtered' => 1,
            'endpoint' => '/product/promotion/get/{field}/{value}',
            'httpVerb' => 'GET',
            'parameters' => array(
                array(
                    'field' => 'field',
                    'dataType' => 'string',
                    'note' => 'Must be set to \'id\'. Set this in the url not query string',
                    'required' => 1,
                ),
                array(
                    'field' => 'value',
                    'dataType' => 'integer',
                    'note' => 'Actual id. Set this in the url not query string',
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
                    'example' => '{"httpStatusCode":200,"systemCode":700,"message":"Promotion id 1 found.","data":{"id":"1","location_id":"1","code":"PROMO","description":"","type":"2","value":"0","new_customer":"1","expiry_date":"0000-00-00 00:00:00","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","field1":"","user_owns":1}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"httpStatusCode":400,"systemCode":900,"message":"Input validation failed.","data":[{"field":"promotion_id","error":"The promotion id must be an integer."}]}'
                )
            )
        ),
        array(
            'name' => 'Get All Promotion',
            'note' => 'Get all users promotions',
            'filtered' => 1,
            'endpoint' => '/product/promotion/get',
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
                    'note' => 'Promotions found',
                    'example' => '{"httpStatusCode":200,"systemCode":700,"message":"Your promotion\'s list","data":[{"id":"1","location_id":"1","code":"PROMO","description":"","type":"2","value":"0","new_customer":"1","expiry_date":"0000-00-00 00:00:00","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","user_owns":1},{"id":"4","location_id":"0","code":"PRO","description":"","type":"0","value":"0","new_customer":"0","expiry_date":"0000-00-00 00:00:00","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","user_owns":1}]}'
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
