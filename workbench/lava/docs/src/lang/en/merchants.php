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
            'name' => 'Get Car wash by id when user NOT logged in',
            'note' => 'Get Car wash by id. The returned json has a property \'products\' which are the products offered by that car wash',
            'filtered' => 0,
            'endpoint' => 'api/get/location_when_not_logged_in',
            'httpVerb' => 'GET',
            'parameters' => array(
                array(
                    'field' => 'get_type',
                    'dataType' => 'string',
                    'note' => 'Must be set to \'single\'',
                    'required' => 1,
                ),
                array(
                    'field' => 'id',
                    'dataType' => 'integer',
                    'note' => 'Id of the location',
                    'required' => 1,
                )
            ),
            'returns' => array(
                array(
                    'action' => 'Success',
                    'httpCode' => 200,
                    'note' => 'Location found',
                    'example' => '{"http_status_code":200,"system_code":700,"message":"Location list","data":{"total":1,"per_page":30,"current_page":1,"last_page":1,"from":1,"to":1,"data":[{"id":"1","merchant_id":"1","name":"Location 1","fax":"","address":"","postal_code":"","lat":"-1.3920700000","lng":"36.8219500000","loyalty_stamps":"2","currency_id":"USD","surcharge":"0.00","image":"","created_at":"-0001-11-30 00:00:00","updated_at":"-0001-11-30 00:00:00","image_url":"","times":{"monday":{"open":"","close":""},"tuesday":{"open":"","close":""},"wednesday":{"open":"","close":""},"thursday":{"open":"","close":""},"friday":{"open":"","close":""},"saturday":{"open":"","close":""},"sunday":{"open":"","close":""},"holiday":{"open":"","close":""}},"star_rating":"5","favoured":"0","rated":"0","rating_count":"1","user_stamps":"0","products":[{"id":"1","location_id":"1","name":"Product 1","description":"Product 1","price_1":"1.00","price_2":"3.00","loyable":"1","created_at":"-0001-11-30 00:00:00","updated_at":"-0001-11-30 00:00:00","merchant_id":"1","currency":null,"price":"1.00"}]}]}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"http_status_code":400,"system_code":900,"message":"Input validation failed.","data":[{"field":"id","error":"The id field is required."}]}'
                ),
                array(
                    'action' => 'Not found',
                    'httpCode' => 404,
                    'note' => 'Object not found',
                    'example' => '{"http_status_code":404,"system_code":904,"message":"Vehicle not found.","data":{"field":"location_id","type":"Vehicle","value":"123"}}'
                ),
            )
        ),
        array(
            'name' => 'Get Car washes within radius when user NOT logged in',
            'note' => 'If no car wash is found, Lava will still return success but the \'data\' array will be empty or have 0 car washes<br>',
            'filtered' => 0,
            'endpoint' => 'api/get/location_when_not_logged_in',
            'httpVerb' => 'GET',
            'parameters' => array(
                array(
                    'field' => 'get_type',
                    'dataType' => 'string',
                    'note' => 'Must be set to \'spatial\'',
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
                )
            ),
            'returns' => array(
                array(
                    'action' => 'Success',
                    'httpCode' => 200,
                    'note' => 'Location found',
                    'example' => '{"http_status_code":200,"system_code":700,"message":"Location list","data":{"total":2,"per_page":1,"current_page":1,"last_page":2,"from":1,"to":1,"data":[{"id":"2","merchant_id":"1","name":"Location 1","fax":"","address":"","postal_code":"","lat":"-1.3920700000","lng":"36.8219500000","loyalty_stamps":"0","currency_id":"USD","surcharge":"0.00","image":"","created_at":"-0001-11-30 00:00:00","updated_at":"-0001-11-30 00:00:00","image_url":"","times":{"monday":{"open":"","close":""},"tuesday":{"open":"","close":""},"wednesday":{"open":"","close":""},"thursday":{"open":"","close":""},"friday":{"open":"","close":""},"saturday":{"open":"","close":""},"sunday":{"open":"","close":""},"holiday":{"open":"","close":""}},"star_rating":"","favoured":"0","rated":"0","rating_count":"0","user_stamps":"0","products":[]}]}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"http_status_code":400,"system_code":900,"message":"Input validation failed.","data":[{"field":"location","error":"Latitude (range -90 to 90) or longitude (range 180 to -180) missing or not valid"}]}'
                )
            )
        ),
        array(
            'name' => 'Get felt car wash when user NOT logged in',
            'note' => 'Felt car wash means car wash that are either \'favoured, rated or reviews\'<br>'
            . 'If no car wash is found, Lava will still return success but the \'data\' array will be empty or have 0 car washes<br>',
            'filtered' => 1,
            'endpoint' => 'api/get/location_when_not_logged_in',
            'httpVerb' => 'GET',
            'parameters' => array(
                array(
                    'field' => 'get_type',
                    'dataType' => 'string',
                    'note' => 'Must be set to \'felt\'',
                    'required' => 1,
                ),
                array(
                    'field' => 'feel_type',
                    'dataType' => 'integer',
                    'note' => 'Must be set to <br>'
                    . '1 = for favoured car washes <br>'
                    . '2 = for rated car washes<br>'
                    . '3 = for reviewed car washes<br>'
                    . '4 = for car wash with loyalty stamps',
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
                )
            ),
            'returns' => array(
                array(
                    'action' => 'Success',
                    'httpCode' => 200,
                    'note' => 'Location found',
                    'example' => '{"http_status_code":200,"system_code":700,"message":"Location list","data":{"total":2,"per_page":1,"current_page":1,"last_page":2,"from":1,"to":1,"data":[{"id":"2","merchant_id":"1","name":"Location 1","fax":"","address":"","postal_code":"","lat":"-1.3920700000","lng":"36.8219500000","loyalty_stamps":"0","currency_id":"USD","surcharge":"0.00","image":"","created_at":"-0001-11-30 00:00:00","updated_at":"-0001-11-30 00:00:00","image_url":"","times":{"monday":{"open":"","close":""},"tuesday":{"open":"","close":""},"wednesday":{"open":"","close":""},"thursday":{"open":"","close":""},"friday":{"open":"","close":""},"saturday":{"open":"","close":""},"sunday":{"open":"","close":""},"holiday":{"open":"","close":""}},"star_rating":"","favoured":"0","rated":"0","rating_count":"0","user_stamps":"0","products":[]}]}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"http_status_code":400,"system_code":900,"message":"Input validation failed.","data":[{"field":"feel_type","error":"The feel type field is required."}]}'
                )
            )
        ),
        array(
            'name' => 'Get Car wash by id when user is logged in',
            'note' => 'Get Car wash by id. The returned json has a property \'products\' which are the products offered by that car wash',
            'filtered' => 0,
            'endpoint' => 'api/get/location_when_logged_in',
            'httpVerb' => 'GET',
            'parameters' => array(
                array(
                    'field' => 'get_type',
                    'dataType' => 'string',
                    'note' => 'Must be set to \'single\'',
                    'required' => 1,
                ),
                array(
                    'field' => 'id',
                    'dataType' => 'integer',
                    'note' => 'Id of the location',
                    'required' => 1,
                )
            ),
            'returns' => array(
                array(
                    'action' => 'Success',
                    'httpCode' => 200,
                    'note' => 'Location found',
                    'example' => '{"http_status_code":200,"system_code":700,"message":"Location list","data":{"total":1,"per_page":30,"current_page":1,"last_page":1,"from":1,"to":1,"data":[{"id":"1","merchant_id":"1","name":"Location 1","fax":"","address":"","postal_code":"","lat":"-1.3920700000","lng":"36.8219500000","loyalty_stamps":"2","currency_id":"USD","surcharge":"0.00","image":"","created_at":"-0001-11-30 00:00:00","updated_at":"-0001-11-30 00:00:00","image_url":"","times":{"monday":{"open":"","close":""},"tuesday":{"open":"","close":""},"wednesday":{"open":"","close":""},"thursday":{"open":"","close":""},"friday":{"open":"","close":""},"saturday":{"open":"","close":""},"sunday":{"open":"","close":""},"holiday":{"open":"","close":""}},"star_rating":"5","favoured":"0","rated":"0","rating_count":"1","user_stamps":"0","products":[{"id":"1","location_id":"1","name":"Product 1","description":"Product 1","price_1":"1.00","price_2":"3.00","loyable":"1","created_at":"-0001-11-30 00:00:00","updated_at":"-0001-11-30 00:00:00","merchant_id":"1","currency":null,"price":"1.00"}]}]}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"http_status_code":400,"system_code":900,"message":"Input validation failed.","data":[{"field":"id","error":"The id field is required."}]}'
                ),
                array(
                    'action' => 'Not found',
                    'httpCode' => 404,
                    'note' => 'Object not found',
                    'example' => '{"http_status_code":404,"system_code":904,"message":"Vehicle not found.","data":{"field":"location_id","type":"Vehicle","value":"123"}}'
                ),
            )
        ),
        array(
            'name' => 'Get Car washes within radius when user is logged in',
            'note' => 'If no car wash is found, Lava will still return success but the \'data\' array will be empty or have 0 car washes<br>',
            'filtered' => 0,
            'endpoint' => 'api/get/location_when_logged_in',
            'httpVerb' => 'GET',
            'parameters' => array(
                array(
                    'field' => 'get_type',
                    'dataType' => 'string',
                    'note' => 'Must be set to \'spatial\'',
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
                )
            ),
            'returns' => array(
                array(
                    'action' => 'Success',
                    'httpCode' => 200,
                    'note' => 'Location found',
                    'example' => '{"http_status_code":200,"system_code":700,"message":"Location list","data":{"total":2,"per_page":1,"current_page":1,"last_page":2,"from":1,"to":1,"data":[{"id":"2","merchant_id":"1","name":"Location 1","fax":"","address":"","postal_code":"","lat":"-1.3920700000","lng":"36.8219500000","loyalty_stamps":"0","currency_id":"USD","surcharge":"0.00","image":"","created_at":"-0001-11-30 00:00:00","updated_at":"-0001-11-30 00:00:00","image_url":"","times":{"monday":{"open":"","close":""},"tuesday":{"open":"","close":""},"wednesday":{"open":"","close":""},"thursday":{"open":"","close":""},"friday":{"open":"","close":""},"saturday":{"open":"","close":""},"sunday":{"open":"","close":""},"holiday":{"open":"","close":""}},"star_rating":"","favoured":"0","rated":"0","rating_count":"0","user_stamps":"0","products":[]}]}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"http_status_code":400,"system_code":900,"message":"Input validation failed.","data":[{"field":"location","error":"Latitude (range -90 to 90) or longitude (range 180 to -180) missing or not valid"}]}'
                )
            )
        ),
        array(
            'name' => 'Get felt car wash when user is logged in',
            'note' => 'Felt car wash means car wash that are either \'favoured, rated or reviews\'<br>'
            . 'If no car wash is found, Lava will still return success but the \'data\' array will be empty or have 0 car washes<br>',
            'filtered' => 1,
            'endpoint' => 'api/get/location_when_logged_in',
            'httpVerb' => 'GET',
            'parameters' => array(
                array(
                    'field' => 'get_type',
                    'dataType' => 'string',
                    'note' => 'Must be set to \'felt\'',
                    'required' => 1,
                ),
                array(
                    'field' => 'feel_type',
                    'dataType' => 'integer',
                    'note' => 'Must be set to <br>'
                    . '1 = for favoured car washes <br>'
                    . '2 = for rated car washes<br>'
                    . '3 = for reviewed car washes<br>'
                    . '4 = for car wash with loyalty stamps',
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
                )
            ),
            'returns' => array(
                array(
                    'action' => 'Success',
                    'httpCode' => 200,
                    'note' => 'Location found',
                    'example' => '{"http_status_code":200,"system_code":700,"message":"Location list","data":{"total":2,"per_page":1,"current_page":1,"last_page":2,"from":1,"to":1,"data":[{"id":"2","merchant_id":"1","name":"Location 1","fax":"","address":"","postal_code":"","lat":"-1.3920700000","lng":"36.8219500000","loyalty_stamps":"0","currency_id":"USD","surcharge":"0.00","image":"","created_at":"-0001-11-30 00:00:00","updated_at":"-0001-11-30 00:00:00","image_url":"","times":{"monday":{"open":"","close":""},"tuesday":{"open":"","close":""},"wednesday":{"open":"","close":""},"thursday":{"open":"","close":""},"friday":{"open":"","close":""},"saturday":{"open":"","close":""},"sunday":{"open":"","close":""},"holiday":{"open":"","close":""}},"star_rating":"","favoured":"0","rated":"0","rating_count":"0","user_stamps":"0","products":[]}]}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"http_status_code":400,"system_code":900,"message":"Input validation failed.","data":[{"field":"feel_type","error":"The feel type field is required."}]}'
                )
            )
        ),
        array(
            'name' => 'Feel location (Favourite, Rate, Review)',
            'note' => 'Favourite, rate or review a location',
            'filtered' => 1,
            'endpoint' => 'api/feel/location',
            'httpVerb' => 'POST',
            'parameters' => array(
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
                    'example' => '{"http_status_code":200,"system_code":700,"message":"Location rated","data":{"id":"20"}}'
                ),
                array(
                    'action' => 'Error',
                    'httpCode' => 400,
                    'note' => 'Validation error',
                    'example' => '{"http_status_code":400,"system_code":900,"message":"Input validation failed.","data":[{"field":"type","error":"The type field is required."}]}'
                ),
                array(
                    'action' => 'Not found',
                    'httpCode' => 404,
                    'note' => 'Object not found',
                    'example' => '{"http_status_code":400,"system_code":900,"message":"Input validation failed.","data":[{"field":"location_id","error":"The selected location id does not exist."}]}'
                ),
            )
        ),
        array(
            'name' => 'Un feel a location or Delete location\'s favourite, rate, review)',
            'note' => 'Delete a favourite, rate or review of a location',
            'filtered' => 1,
            'endpoint' => 'api/unfeel/location',
            'httpVerb' => 'POST',
            'parameters' => array(
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
                    'example' => '{"http_status_code":200,"system_code":700,"message":"Location de-rated","data":{"id":"20"}}'
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
                    'example' => '{"http_status_code":400,"system_code":900,"message":"Input validation failed.","data":[{"field":"location_id","error":"The selected location id does not exist."}]}'
                ),
            )
        ),
    )
);
