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

    //TODO Number of loyalty stamps – how many loyalty stamps the user has at that location
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
                    'long' => floatval($this->input['location']['lat']),
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
                    )
                );
                
                //Implode the location id's
                $orderIds = implode(',', $locationIds);
                
                //Build parameters
                $parameters = array(
                    'orderByRaw'=>array(
                        "FIELD(id, $orderIds)"
                    )
                );
                
                //Get location model
                $locationModel = $this->select($fields, $whereClause, 2,$parameters);

                //Location array
                $locationArray = $locationModel->toArray();

                foreach ($locationArray as $singleLocation) {//Loop via the locations
                    //Prepare Model
                    $this->prepareModelToReturn($singleLocation);
                }//E# foreach statement
                //Set merchants
                $this->notification['list'] = $locationArray;
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
            $parameters['lazyLoad'] = array('products');

            $locationModel = $this->getModelByField('id', $id, $parameters);

            if ($locationModel) {
                //Total reviews
                //$totalReviews =  $locationModel->total_reviews;
                $locationArray = $locationModel->toArray();

                //Prepare model
                $this->prepareModelToReturn($locationArray);

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

    /**
     * S# prepareModelToReturn() function
     * Build locations open times
     * @param array $locationArray Location array
     * 
     */
    private function prepareModelToReturn(&$locationArray) {
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
        //Set the days array as times key to the location array
        $locationArray['times'] = $daysArray;
    }

//E#prepareModelToReturn() function
}

//E# LocationController() function