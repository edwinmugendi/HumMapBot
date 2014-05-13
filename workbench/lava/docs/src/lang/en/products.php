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
    )
);
