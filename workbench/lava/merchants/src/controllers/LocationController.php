<?php

namespace Lava\Merchants;

/**
 * S# LocationController() function
 * Locations controller
 * @author Edwin Mugendi
 */
class LocationController extends MerchantsBaseController {

    //Controller
    public $controller = 'location';
    //Lazy load
    public $lazyLoad = array('products');
    public $imageable = true;
    public $mappable = true;

    /**
     * S# roleBasedWhereClause() function
     * @author Edwin Mugendi
     * Build where clause based on role
     * 
     * @param array $fields Fields
     * @param array $where_clause Where clause
     * @param array $parameters Parameters
     */
    public function roleBasedWhereClause($fields, &$where_clause, &$parameters) {
        if ($this->user['role_id'] == 2) {//Merchant
            $where_clause[] = array(
                'where' => 'where',
                'column' => 'merchant_id',
                'operator' => '=',
                'operand' => $this->merchant['id']
            );
        }
    }

    //E# roleBasedWhereClause() function

    /**
     * S# injectDataSources() function
     * @author Edwin Mugendi
     * Inject data source. This are mainly select
     * 
     * @param array $dataSource Data source
     */
    public function injectDataSources() {

        //Get this organization merchant id
        $this->view_data['dataSource']['merchant_id'] = $this->appGetCustomMerchantHtmlSelect();

        //Get and set country options for this country
        $this->view_data['dataSource']['country_id'] = $this->callController(\Util::buildNamespace('locations', 'country', 1), 'getSelectOptions');

        //Get and set timezone options for this country
        $this->view_data['dataSource']['timezone_id'] = $this->callController(\Util::buildNamespace('locations', 'timezone', 1), 'getSelectOptions');

        //Get and set currency options for this country
        $this->view_data['dataSource']['currency_id'] = $this->callController(\Util::buildNamespace('locations', 'currency', 1), 'getSelectOptions');

        //Get and set workflow options to data source
        $this->view_data['dataSource']['workflow'] = \Lang::get($this->package . '::' . $this->controller . '.data.workflow');

        //Get and set yes no options to data source
        $this->view_data['dataSource']['pay_location'] = $this->view_data['dataSource']['is_monday_open'] = $this->view_data['dataSource']['is_tuesday_open'] = $this->view_data['dataSource']['is_wednesday_open'] = $this->view_data['dataSource']['is_thursday_open'] = $this->view_data['dataSource']['is_friday_open'] = $this->view_data['dataSource']['is_saturday_open'] = $this->view_data['dataSource']['is_sunday_open'] = $this->view_data['dataSource']['is_holiday_open'] = \Lang::get($this->package . '::' . $this->controller . '.data.yes_no');

        //Get and set hours options to data source
        $this->view_data['dataSource']['monday_opens_at'] = $this->view_data['dataSource']['monday_closes_at'] = $this->view_data['dataSource']['tuesday_opens_at'] = $this->view_data['dataSource']['tuesday_closes_at'] = $this->view_data['dataSource']['wednesday_opens_at'] = $this->view_data['dataSource']['wednesday_closes_at'] = $this->view_data['dataSource']['thursday_opens_at'] = $this->view_data['dataSource']['thursday_closes_at'] = $this->view_data['dataSource']['friday_opens_at'] = $this->view_data['dataSource']['friday_closes_at'] = $this->view_data['dataSource']['saturday_opens_at'] = $this->view_data['dataSource']['saturday_closes_at'] = $this->view_data['dataSource']['sunday_opens_at'] = $this->view_data['dataSource']['sunday_closes_at'] = $this->view_data['dataSource']['holiday_opens_at'] = $this->view_data['dataSource']['holiday_closes_at'] = \Lang::get($this->package . '::' . $this->controller . '.data.hours');

        //Get and set loyalty_stamps options to data source
        $this->view_data['dataSource']['loyalty_stamps'] = \Lang::get($this->package . '::' . $this->controller . '.data.loyalty_stamps');

        //Get and set date format options to data source
        $this->view_data['dataSource']['date_format'] = \Lang::get($this->package . '::' . $this->controller . '.data.date_format');
    }

//E# injectDataSources() function


    /*     * *
     * Location Search
     * Location search API is used to get perform 3 types of searches
     * 1. Spatial Search - This is search using lat, long and radius
     * 2. single - Search by id
     * 3. felt - Search locations that the user reviews, rates or favourites. This requires the user to be logged in
     */

    /**
     * S# controllerSpecificWhereClause() function
     * @author Edwin Mugendi
     * 
     * Set controller specific where clause
     * @param array $fields Fields
     * @param array $where_clause Where clause
     * @param array $parameters Parameters
     */
    public function controllerSpecificWhereClause(&$fields, &$where_clause, &$parameters) {

        if (array_key_exists('format', $this->input) && ($this->input['format'] == 'json')) {//API
            $this->validationRules = array(
                'get_type' => 'required|in:spatial,single,felt', //Check description above
            );

            //Validate location
            $this->isInputValid();

            if ($this->input['get_type'] == 'spatial') {//Geo spatial search
                $this->validationRules = array(
                    'location' => 'required|latLng',
                    'radius' => 'required'
                );
                //Validate location
                $this->isInputValid();

                //Define parameter
                $geo_parameters = array(
                    floatval($this->input['location']['lat']),
                    floatval($this->input['location']['lng']),
                    floatval($this->input['location']['lat']),
                    floatval($this->input['radius'] / 1000)//Convert to kilometer
                );

                //Get locations within radius
                $fluent_locations = \DB::select(\DB::raw("SELECT *, (6371 * acos(cos(radians(?)) * cos(radians(lat)) * cos( radians(lng) - radians(?)) + sin(radians(?)) * sin(radians(lat)))) AS distance FROM sp_mct_locations Having distance < ? ORDER BY distance"), $geo_parameters);

                $locations_found = count($fluent_locations);

                $user_id = \Auth::check() ? $this->user['id'] : 1; //If 1 it means that the user is not logged in

                $search_array = array(
                    'user_id' => $user_id,
                    'lat' => $this->input['location']['lat'],
                    'lng' => $this->input['location']['lng'],
                    'radius' => $this->input['radius'],
                    'locations_found' => $locations_found,
                    'ip' => $this->input['ip'],
                    'agent' => $this->input['agent'],
                    'status' => 1,
                    'created_by' => $user_id,
                    'updated_by' => $user_id
                );

                //Create search
                $search_model = $this->callController(\Util::buildNamespace('merchants', 'search', 1), 'createIfValid', array($search_array, true));

                if ($locations_found) {//Locations found
                    //Get location ids
                    $location_ids = array_fetch($fluent_locations, 'id');

                    //Build where clause
                    $where_clause[] = array(
                        'where' => 'whereIn',
                        'column' => 'id',
                        'operator' => '=',
                        'operand' => $location_ids
                    );

                    $where_clause[] = array(
                        'where' => 'where',
                        'column' => 'workflow',
                        'operator' => '=',
                        'operand' => 1
                    );

                    //Implode the location id's
                    $order_ids = implode(',', $location_ids);

                    //Build parameters
                    $parameters['orderByRaw'] = array(
                        "FIELD(id, $order_ids)"
                    );
                } else {
                    //Build where clause
                    $where_clause[] = array(
                        'where' => 'whereIn',
                        'column' => 'id',
                        'operator' => '=',
                        'operand' => array(0)
                    );
                }//E# if else statement
            } else if ($this->input['get_type'] == 'felt') {//Felt
                $this->validationRules = array(
                    'feel_type' => 'required|integer|between:1,4',
                );

                //Validate location
                $this->isInputValid();

                //Fields to select
                $fields_feel = array('*');

                //Set where clause
                $where_clause_feel = array(
                    array(
                        'where' => 'where',
                        'column' => 'user_id',
                        'operator' => '=',
                        'operand' => $this->user['id']
                    ),
                    array(
                        'where' => 'where',
                        'column' => 'type',
                        'operator' => '=',
                        'operand' => $this->input['feel_type']
                    )
                );

                //Set per page to parameters
                $parameters_feel['scope'] = array('statusOne');

                //Order by id in descending order
                $parameters_feel['orderBy'][] = array('created_at' => 'desc');

                //Get feel
                $feel_model = $this->callController(\Util::buildNamespace('merchants', 'feel', 1), 'select', array($fields_feel, $where_clause_feel, 2, $parameters_feel));

                if ($feel_model) {//Locations found
                    //Get location ids
                    $location_ids = $feel_model->lists('location_id');

                    //Build where clause
                    $where_clause[] = array(
                        'where' => 'whereIn',
                        'column' => 'id',
                        'operator' => '=',
                        'operand' => $location_ids
                    );

                    $where_clause[] = array(
                        'where' => 'where',
                        'column' => 'workflow',
                        'operator' => '=',
                        'operand' => 1
                    );
                } else {
                    //Build where clause
                    $where_clause[] = array(
                        'where' => 'whereIn',
                        'column' => 'id',
                        'operator' => '=',
                        'operand' => array(0)
                    );
                }//E# if else statement
            } else if ($this->input['get_type'] == 'single') {//Single
                $this->validationRules = array(
                    'id' => 'required',
                );
                //Validate location
                $this->isInputValid();

                //Fields to select
                $fields = array('*');

                //Set where clause
                $where_clause = array(
                    array(
                        'where' => 'where',
                        'column' => 'id',
                        'operator' => '=',
                        'operand' => $this->input['id']
                    ),
                    array(
                        'where' => 'where',
                        'column' => 'workflow',
                        'operator' => '=',
                        'operand' => 1
                    )
                );

                //Set parameters
                $parameters['scope'] = array('statusOne');

                //Get model by id
                $location_model = $this->select($fields, $where_clause, 2, $parameters);

                if (!count($location_model)) {

                    //Set notification
                    $this->notification = array(
                        'field' => 'location_id',
                        'type' => 'Vehicle',
                        'value' => $this->input['id'],
                    );

                    //Throw Vehicle not found error
                    throw new \Api404Exception($this->notification);
                }//E# if else statement
            }//E# if statement
        }//E# if statement
    }

//E# controllerSpecificWhereClause() function

    /**
     * S# getLocations() function
     * 
     * Get location details or search location by lat and long
     * 
     * @param int $id Location id
     * 
     * @return array Location
     */
    public function getFavouredLocations() {
        //Build relation
        $relation = 'favourites';

        //Lazy load to load
        $parameters['lazyLoad'] = array($relation);

        //Get user by id
        $userModel = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getModelByField', array('id', $this->user['id'], $parameters));

        if (array_key_exists('format', $this->input) && ($this->input['format'] == 'json')) {//API
            //Get success message
            $message = \Lang::get($this->package . '::' . $this->controller . '.notification.list');
            //Define relation array
            $relationArray = array();
            foreach ($userModel->$relation->toArray() as $singleRelation) {//Loop through the relations
                $relationArray[] = $this->beforeViewing($singleRelation);
            }//E# foreach statement
            //Throw 200 Exception
            throw new \Api200Exception($relationArray, $message);
        }//E# if else statement
    }

//E# getLocations() function

    
}

//E# LocationController() function