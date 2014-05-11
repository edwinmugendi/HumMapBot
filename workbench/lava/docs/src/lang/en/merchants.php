<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | Payments Language Lines
      |--------------------------------------------------------------------------
     */
    'module' => array(
        'name' => 'Merchants',
        'note' => 'Merchants module'
    ),
    'api' => array(
        array(
            'name' => 'Get Single Location',
            'note' => 'Get a location by id',
            'filtered' => 1,
            'endpoint' => 'user/vehicle/get/{id}',
            'httpVerb' => 'GET',
            'parameters' => array(
                array(
                    'field' => 'id',
                    'dataType' => 'integer',
                    'note' => 'Location id Set this in the url not query string',
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
                    'note' => 'Location found',
                    'example' => '{"httpStatusCode":200,"systemCode":700,"message":"Location id 1 found.","data":{"id":"1","merchant_id":"1","name":"Deluxe","fax":"","address":"","postal_code":"","latitude":"0.000000","longitude":"0.000000","loyalty_stamps":"0","image":"","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","total_reviews":0,"star_rating":0,"image_url":"http:\/\/api.lv.dev\/media\/upload\/merchant\/thumbnails","is_favourite":0,"is_rated":0,"products":[{"id":"1","location_id":"1","name":"Delux","description":"Delux","price_4X2":"12.00","price_4X4":"12","loyable":"0","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00"}],"times":{"monday":{"open":"","close":""},"tuesday":{"open":"","close":""},"wednesday":{"open":"","close":""},"thursday":{"open":"","close":""},"friday":{"open":"","close":""},"saturday":{"open":"","close":""},"sunday":{"open":"","close":""},"holiday":{"open":"","close":""}}}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"httpStatusCode":400,"systemCode":900,"message":"Input validation failed.","data":[{"field":"id","error":"The id must be an integer."}]}'
                ),
                array(
                    'action' => 'Not found',
                    'httpCode' => 404,
                    'note' => 'Object not found',
                    'example' => '{"httpStatusCode":404,"systemCode":904,"message":"Location with id \'122\' not found.","data":{"field":"id","type":"Location","value":"122"}}'
                ),
            )
        ),
        array(
            'name' => 'Feel location (Favourite, Rate, Review)',
            'note' => 'Favourite, rate or review a location',
            'filtered' => 1,
            'endpoint' => '/merchant/location/feel/{id}',
            'httpVerb' => 'POST',
            'parameters' => array(
                array(
                    'field' => 'id',
                    'dataType' => 'integer',
                    'note' => 'Location id Set this in the url not query string',
                    'required' => 1,
                ),
                array(
                    'field' => 'type',
                    'dataType' => 'integer',
                    'note' => 'Set 1 to favourite<br> 2 to rate <br> 3 to review',
                    'required' => 1,
                ), array(
                    'field' => 'rate',
                    'dataType' => 'integer',
                    'note' => 'Required if <i>type</i> is 2 & between 1 and 5 inclusive',
                    'required' => 0,
                ), array(
                    'field' => 'review',
                    'dataType' => 'string',
                    'note' => 'Required if <i>type</i> is 3',
                    'required' => 0,
                ), array(
                    'field' => 'token',
                    'dataType' => 'string',
                    'note' => 'User API token',
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
                    'note' => 'Location found',
                    'example' => '{"httpStatusCode":200,"systemCode":700,"message":"Location id 1 found.","data":{"id":"1","merchant_id":"1","name":"Deluxe","fax":"","address":"","postal_code":"","latitude":"0.000000","longitude":"0.000000","loyalty_stamps":"0","image":"","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","total_reviews":0,"star_rating":0,"image_url":"http:\/\/api.lv.dev\/media\/upload\/merchant\/thumbnails","is_favourite":0,"is_rated":0,"products":[{"id":"1","location_id":"1","name":"Delux","description":"Delux","price_4X2":"12.00","price_4X4":"12","loyable":"0","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00"}],"times":{"monday":{"open":"","close":""},"tuesday":{"open":"","close":""},"wednesday":{"open":"","close":""},"thursday":{"open":"","close":""},"friday":{"open":"","close":""},"saturday":{"open":"","close":""},"sunday":{"open":"","close":""},"holiday":{"open":"","close":""}}}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"httpStatusCode":400,"systemCode":900,"message":"Input validation failed.","data":[{"field":"id","error":"The id must be an integer."}]}'
                ),
                array(
                    'action' => 'Not found',
                    'httpCode' => 404,
                    'note' => 'Object not found',
                    'example' => '{"httpStatusCode":404,"systemCode":904,"message":"Location with id \'122\' not found.","data":{"field":"id","type":"Location","value":"122"}}'
                ),
            )
        ),
    )
);
