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

        if ($this->subdomain == 'api') {//From API
            //Get success message
            $message = \Lang::get($this->package . '::' . $this->controller . '.api.getAll');
            //Define relation array
            $relationArray = array();
            foreach ($userModel->$relation->toArray() as $singleRelation) {//Loop through the relations
                $relationArray[] = $this->prepareModelToReturn($singleRelation);
            }//E# foreach statement
            //Throw 200 Exception
            throw new \Api200Exception($relationArray, $message);
        }//E# if else statement
    }

//E# getLocations() function

    /**
     * S# getLocations() function
     * 
     * Get location details or search location by lat and long
     * 
     * @param int $id Location id
     * 
     * @return array Location
     */
    public function getLocations($id = null) {
        if (is_null($id)) {//Get List of locations
            $this->validationRules = array(
                'location' => 'required|latLng',
                'radius' => 'required'
            );
            //Validate location
            $this->isInputValid();

            //Define parameter
            $parameters = array(
                floatval($this->input['location']['lat']),
                floatval($this->input['location']['lng']),
                floatval($this->input['location']['lat']),
                floatval($this->input['radius'] / 1000)//Convert to meters
            );

            //Build notification
            $this->notification = array(
                'location' => array(
                    'lat' => floatval($this->input['location']['lat']),
                    'lng' => floatval($this->input['location']['lng']),
                )
            );
            //Get locations within radius
            $fluentLocations = \DB::select(\DB::raw("SELECT *, (6371 * acos(cos(radians(?)) * cos(radians(lat)) * cos( radians(lng) - radians(?)) + sin(radians(?)) * sin(radians(lat)))) AS distance FROM sp_mct_locations Having distance < ? ORDER BY distance"), $parameters);

            if ($fluentLocations) {//Locations found
                //Get location ids
                $locationIds = array_fetch($fluentLocations, 'id');

                //Fields to select
                $fields = array('*');

                //Build where clause
                $whereClause = array(
                    array(
                        'where' => 'whereIn',
                        'column' => 'id',
                        'operator' => '=',
                        'operand' => $locationIds
                    ),
                    array(
                        'where' => 'where',
                        'column' => 'status',
                        'operator' => '=',
                        'operand' => 1
                    )
                );

                //Implode the location id's
                $orderIds = implode(',', $locationIds);

                //Build parameters
                $parameters = array(
                    'orderByRaw' => array(
                        "FIELD(id, $orderIds)"
                    )
                );

                //Set per page to parameters
                $parameters['paginate'] = isset($this->input['per_page']) ? (int) $this->input['per_page'] : 30;

                //Get location model
                $locationModel = $this->select($fields, $whereClause, 2, $parameters);

                //Location array
                $locationArray = array();

                foreach ($locationModel as $singleLocation) {//Loop via the locations
                    ///Prepare Model
                    $locationArray[] = $this->prepareModelToReturn($singleLocation);
                }//E# foreach statement
                //Set merchants
                $this->notification['list'] = $locationArray;

                //Build notification
                $this->notification = array(
                    'list' => $locationArray,
                    'pagination' => array(
                        'page' => $locationModel->getCurrentPage(),
                        'last_page' => $locationModel->getLastPage(),
                        'per_page' => $locationModel->getPerPage(),
                        'total' => $locationModel->getTotal(),
                        'from' => $locationModel->getFrom(),
                        'to' => $locationModel->getTo(),
                        'count' => $locationModel->count()
                    )
                );
            } else {
                //Set merchants
                $this->notification['list'] = array();
            }//E# if else statement
            //Get success message
            $message = \Lang::get($this->package . '::' . $this->controller . '.api.getAll', array('field' => 'id', 'value' => $id));

            //Throw 200 Exception
            throw new \Api200Exception($this->notification, $message);

            //TODO Radius search
        } else {//Get a single location
            //Add location id to inputs for validation
            $this->input['id'] = $id;

            $this->validationRules = array(
                'id' => 'required|integer'
            );
            //Validate location
            $this->isInputValid();

            //Lazy load
            $parameters['lazyLoad'] = array('products', 'ratings');

            $locationModel = $this->getModelByField('id', $id, $parameters);

            if ($locationModel) {
                $locationArray = $locationModel->toArray();

                $locationArray['no_thumbnails'] = 1;

                //Prepare model
                $locationArray = $this->prepareModelToReturn($locationArray);

                //Get success message
                $message = \Lang::get($this->package . '::' . $this->controller . '.api.getSingle', array('field' => 'id', 'value' => $id));

                //Throw 200 Exception
                throw new \Api200Exception($locationArray, $message);
            } else {
                //Set notification
                $this->notification = array(
                    'field' => 'id',
                    'type' => 'Location',
                    'value' => $id,
                        //'error' => $this->message
                );

                //Throw Locationf not found error
                throw new \Api404Exception($this->notification);
            }
        }
    }

//E# getLocations() function

    /**
     * S# prepareModelToReturn() function
     * Build locations open times
     * @param array $locationArray Location array
     * 
     */
    public function prepareModelToReturn($locationArray) {
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
            $daysArray[$day]['open'] = $locationArray[$day . '_open'];
            $daysArray[$day]['close'] = $locationArray[$day . '_close'];

            //Remove them from the 
            unset($locationArray[$day . '_open']);
            unset($locationArray[$day . '_close']);
        }//E# foreach statement
        //Url
        $url = array_key_exists('no_thumbnails', $locationArray) ? 'media/lava/upload/' : 'media/lava/upload/thumbnails/';

        //Image
        $locationArray['image_url'] = $locationArray['image'] ? asset($url . $locationArray['image']) : "";

        //Set the days array as times key to the location array
        $locationArray['times'] = $daysArray;

        unset($locationArray['ratings']);
        unset($locationArray['pivot']);

        return $locationArray;
    }

//E#prepareModelToReturn() function
}

//E# LocationController() function