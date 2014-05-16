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
            'endpoint' => '/product/promotion/redeem/{promotion_code}',
            'httpVerb' => 'POST',
            'parameters' => array(
                array(
                    'field' => 'promotion_code',
                    'dataType' => 'string',
                    'note' => 'Promotion Code. Set this in the url not query string',
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
                    'example' => '{"httpStatusCode":400,"systemCode":900,"message":"Input validation failed.","data":[{"field":"code","error":"You have already claimed this promotion code PRO but not used it yet"}]}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"httpStatusCode":400,"systemCode":900,"message":"Input validation failed.","data":[{"field":"code","error":"You have already claimed this promotion code PROMO but not used it yet"}]}'
                ),
                array(
                    'action' => 'Not found',
                    'httpCode' => 404,
                    'note' => 'Object not found',
                    'example' => '{"httpStatusCode":404,"systemCode":904,"message":"Promotion with code \'PROMO1\' not found.","data":{"field":"code","type":"Promotion","value":"PROMO1"}}'
                ),
            )
        ),
        array(
            'name' => 'Get Single Promotion by Promotion Id',
            'note' => 'Get a single promotion\'s details by promotion id',
            'filtered' => 1,
            'endpoint' => '/product/promotion/get/{promotion_id}',
            'httpVerb' => 'GET',
            'parameters' => array(
                array(
                    'field' => 'promotion_id',
                    'dataType' => 'integer',
                    'note' => 'Promotion id Set this in the url not query string',
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
                ),
                array(
                    'action' => 'Forbidden',
                    'httpCode' => 403,
                    'note' => 'Forbidden or Don\'t Own Object',
                    'example' => '{"httpStatusCode":403,"systemCode":903,"message":"Forbidden or Don\'t own","data":{"field":"id","type":"Promotion","value":"4"}}'
                ),
                array(
                    'action' => 'Not found',
                    'httpCode' => 404,
                    'note' => 'Object not found',
                    'example' => '{"httpStatusCode":404,"systemCode":904,"message":"Promotion with id \'12\' not found.","data":{"field":"id","type":"Promotion","value":"12"}}'
                ),
            )
        ),
        array(
            'name' => 'Get All Promotion',
            'note' => 'Get all users promotions',
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
