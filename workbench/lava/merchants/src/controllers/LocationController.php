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
     * @param array $whereClause Where clause
     * @param array $parameters Parameters
     */
    public function controllerSpecificWhereClause(&$fields, &$whereClause, &$parameters) {

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

                //dd($fluent_locations);
                if ($fluent_locations) {//Locations found
                    //Get location ids
                    $location_ids = array_fetch($fluent_locations, 'id');

                    //Build where clause
                    $whereClause[] = array(
                        'where' => 'whereIn',
                        'column' => 'id',
                        'operator' => '=',
                        'operand' => $location_ids
                    );

                    //Implode the location id's
                    $order_ids = implode(',', $location_ids);

                    //Build parameters
                    $parameters['orderByRaw'] = array(
                        "FIELD(id, $order_ids)"
                    );
                } else {
                    //Build where clause
                    $whereClause[] = array(
                        'where' => 'whereIn',
                        'column' => 'id',
                        'operator' => '=',
                        'operand' => array(0)
                    );
                }//E# if else statement
            } else if ($this->input['get_type'] == 'felt') {//Felt
                
                $this->validationRules = array(
                    'feel_type' => 'required|integer|between:1,3',
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
                    $whereClause[] = array(
                        'where' => 'whereIn',
                        'column' => 'id',
                        'operator' => '=',
                        'operand' => $location_ids
                    );
                } else {
                    //Build where clause
                    $whereClause[] = array(
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

    /**
     * S# beforeViewing() function
     * 
     * Prepare fields for list view
     * 
     */
    public function beforeViewing(&$singleModel) {
        //Define days
        $days = array(
            'monday',
            'tuesday',
            'wednesday',
            'thursday',
            'friday',
            'saturday',
            'sunday',
            'holiday',
        );
        //Days array
        $daysArray = array();
        foreach ($days as $key => $day) {//Loop via the days
            //Set day to days array
            $daysArray[$day]['open'] = $singleModel[$day . '_open'];
            $daysArray[$day]['close'] = $singleModel[$day . '_close'];

            //Remove them from the 
            unset($singleModel[$day . '_open']);
            unset($singleModel[$day . '_close']);
        }//E# foreach statement
        //Url
        $url = array_key_exists('no_thumbnails', $singleModel) ? 'media/lava/upload/' : 'media/lava/upload/thumbnails/';

        //Image
        $singleModel['image_url'] = $singleModel['image'] ? asset($url . $singleModel['image']) : "";

        //Set the days array as times key to the location array
        $singleModel['times'] = $daysArray;

        unset($singleModel['ratings']);
        unset($singleModel['pivot']);
    }

//E#beforeViewing() function
}

//E# LocationController() function