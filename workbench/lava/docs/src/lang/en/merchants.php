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
            'endpoint' => '/merchant/location/get/{id}',
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
                    'required' => 0,
                )
            ),
            'returns' => array(
                array(
                    'action' => 'Success',
                    'httpCode' => 200,
                    'note' => 'Location found',
                    'example' => '{"httpStatusCode":200,"systemCode":700,"message":"Location id 1 found.","data":{"id":"1","merchant_id":"1","name":"Kikuyu","fax":"","address":"10016 Nakuru","postal_code":"","lat":"0.000000","lng":"0.000000","loyalty_stamps":"5","image":"","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","currency":"GBP","surcharge":"1.22","star_rating":"","image_url":"http:\/\/api.lv.dev\/media\/upload\/merchant\/thumbnails","favoured":"1","rated":"0","rating_count":"0","user_stamps":"27","products":[{"id":"1","location_id":"1","name":"Sapama","description":"Test","price_1":"7.99","price_2":"10.66","loyable":"1","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","currency":"GBP","price":"Free"}],"times":{"monday":{"open":"","close":""},"tuesday":{"open":"","close":""},"wednesday":{"open":"","close":""},"thursday":{"open":"","close":""},"friday":{"open":"","close":""},"saturday":{"open":"","close":""},"sunday":{"open":"","close":""},"holiday":{"open":"","close":""}}}}'
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
            'name' => 'Get Merchants within radius',
            'note' => 'Get Merchants withing a given radius',
            'filtered' => 0,
            'endpoint' => '/merchant/location/get',
            'httpVerb' => 'GET',
            'parameters' => array(
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
                array(
                    'field' => 'radius',
                    'dataType' => 'integer',
                    'note' => 'Radius in meters',
                    'required' => 1,
                ),
                array(
                    'field' => 'radius',
                    'dataType' => 'integer',
                    'note' => 'Radius in meters',
                    'required' => 1,
                ),
                array(
                    'field' => 'per_page',
                    'dataType' => 'integer',
                    'note' => 'Number of locations to return in a given page eg return 20 locations (Defaults to 30)',
                    'required' => 0,
                ),
                array(
                    'field' => 'page',
                    'dataType' => 'integer',
                    'note' => 'The page of the pagination to return eg page 1, 2',
                    'required' => 0,
                ),
                array(
                    'field' => 'token',
                    'dataType' => 'string',
                    'note' => 'User API token',
                    'required' => 0,
                )
            ),
            'returns' => array(
                array(
                    'action' => 'Success',
                    'httpCode' => 200,
                    'note' => 'Location found',
                    'example' => '{"httpStatusCode":200,"systemCode":700,"message":"Locations list","data":{"list":[{"id":"3","merchant_id":"1","name":"Product 1","fax":"","address":"","postal_code":"","lat":"1.0000000000","lng":"1.0000000000","loyalty_stamps":"0","currency":"","surcharge":"0.00","image":"","created_at":"-0001-11-30 00:00:00","updated_at":"-0001-11-30 00:00:00","times":{"monday":{"open":"","close":""},"tuesday":{"open":"","close":""},"wednesday":{"open":"","close":""},"thursday":{"open":"","close":""},"friday":{"open":"","close":""},"saturday":{"open":"","close":""},"sunday":{"open":"","close":""},"holiday":{"open":"","close":""}},"star_rating":"","image_url":"http:\/\/api.lv.dev\/media\/upload\/merchant\/thumbnails","favoured":"-1","rated":"-1","rating_count":"0","user_stamps":"0"}],"pagination":{"page":1,"last_page":9,"per_page":1,"total":9,"from":1,"to":1,"count":1}}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"httpStatusCode":400,"systemCode":900,"message":"Input validation failed.","data":[{"field":"id","error":"The id must be an integer."}]}'
                )
            )
        ),
        array(
            'name' => 'Get User Favoured Locations',
            'note' => 'Get User Favoured Locations',
            'filtered' => 1,
            'endpoint' => '/merchant/location/user/favoured',
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
                    'note' => 'Location found',
                    'example' => '{"httpStatusCode":200,"systemCode":700,"message":"Locations list","data":{"location":{"lat":-1.28333,"long":-1.28333},"merchants":[{"id":"1","merchant_id":"0","name":"Kikuyu","fax":"","address":"","postal_code":"","lat":"0.000000","lng":"0.000000","loyalty_stamps":"0","monday_open":"","monday_close":"","tuesday_open":"","tuesday_close":"","wednesday_open":"","wednesday_close":"","thursday_open":"","thursday_close":"","friday_open":"","friday_close":"","saturday_open":"","saturday_close":"","sunday_open":"","sunday_close":"","holiday_open":"","holiday_close":"","image":"","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","rating":2,"image_url":"http:\/\/api.lv.dev\/media\/upload\/merchant\/thumbnails","favoured":0,"rated":0}]}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"httpStatusCode":400,"systemCode":900,"message":"Input validation failed.","data":[{"field":"id","error":"The id must be an integer."}]}'
                )
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
                    'note' => 'Required if <i>type</i> is 2 & between 1 and 5 inclusive.',
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
            'name' => 'Un feel a location or Delete location\'s favourite, rate, review)',
            'note' => 'Delete a favourite, rate or review of a location',
            'filtered' => 1,
            'endpoint' => '/merchant/location/unfeel/{id}',
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
                    'field' => 'review_id',
                    'dataType' => 'integer',
                    'note' => 'Review id. Required if <i>type</i> is 3',
                    'required' => 0,
                ), array(
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
                    'example' => '{"httpStatusCode":200,"systemCode":700,"message":"Location id 1 unfavoured","data":{"id":"7"}}'
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
                    'example' => '{"httpStatusCode":404,"systemCode":904,"message":"Favourites with id \'1\' not found.","data":{"field":"id","type":"Favourites","value":"1"}}'
                ),
            )
        ),
    )
);
