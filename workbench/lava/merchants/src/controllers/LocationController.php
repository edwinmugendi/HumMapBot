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
     * S# postFeel() function
     * Favourite, rate or review a location
     * Favourite: type == 1, no other field is needed
     * Rate: type == 2, rate field is needed and should be between 1 and 5
     * Review: type == 3, review field is need
     * 
     * @param int $id Location
     * @return json 
     */
    public function postFeel($id) {
        //Add location id to inputs for validation
        $this->input['id'] = $id;

        //Define validation rules
        $this->validationRules = array(
            'id' => 'required|exists:mct_locations,id',
            'type' => 'required|integer|between:1,3',
            'rate' => 'required_if:type,2|integer|between_if:type,2,1,5',
            'review' => 'required_if:type,3'
        );
        //Validate location
        $this->isInputValid();

        if ($this->input['type'] == 1 || $this->input['type'] == 2) {//Favourite location: NB: Can only be one row
            //Fields to select
            $fields = array('*');

            //Build where clause
            $whereClause = array(
                array(
                    'where' => 'where',
                    'column' => 'user_id',
                    'operator' => '=',
                    'operand' => $this->user['id']
                ),
                array(
                    'where' => 'where',
                    'column' => 'location_id',
                    'operator' => '=',
                    'operand' => $id
                ),
                array(
                    'where' => 'where',
                    'column' => 'type',
                    'operator' => '=',
                    'operand' => $this->input['type']
                )
            );
            //Get feeling model
            $feelingModel = $this->callController(\Util::buildNamespace('merchants', 'feel', 1), 'select', array($fields, $whereClause, 1));

            //Cache feeling
            $feeling = $this->input['type'] == 2 ? $this->input['rate'] : '';

            if ($feelingModel) {//Exists
                $feelingModel->feeling = $feeling;
                $feelingModel->save();
            } else {//Create
                //Define feeling row
                $feelingRow = array(
                    'user_id' => $this->user['id'],
                    'location_id' => $id,
                    'type' => $this->input['type'],
                    'feeling' => $feeling
                );
                //Get feeling model
                $feelingModel = $this->callController(\Util::buildNamespace('merchants', 'feel', 1), 'createIfValid', array($feelingRow, true));
            }//E# if statement
        } else {//Review
            //Define feeling row
            $feelingRow = array(
                'user_id' => $this->user['id'],
                'location_id' => $id,
                'type' => $this->input['type'],
                'feeling' => $this->input['review']
            );
            //Get feeling model
            $feelingModel = $this->callController(\Util::buildNamespace('merchants', 'feel', 1), 'createIfValid', array($feelingRow, true));
        }//E# if statement
        //Get success message
        $message = \Lang::get($this->package . '::' . $this->controller . '.api.feel.' . $this->input['type'], array('field' => 'id', 'value' => $this->input['id']));

        //Throw API success Exception
        throw new \Api200Exception(array_only($feelingModel->toArray(), array('id')), $message);
    }

//E# postFeel() function
    //TODO Number of loyalty stamps – how many loyalty stamps the user has at that location
    public function getLocations($id = null) {
        if (is_null($id)) {//Get List of locations
            $this->validationRules = array(
                'lat' => 'required|integer',
                'long' => 'required|integer',
                'radius' => 'required|integer'
            );
            //Validate location
            $this->isInputValid();

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

                //Build open times 
                $this->buildOpenTimes($locationArray);

                //Get success message
                $message = \Lang::get($this->package . '::' . $this->controller . '.api.getSingle', array('field' => 'id', 'value' => $id));

                throw new \Api200Exception($locationArray, $message);

                return $locationArray;
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
     * S# buildOpenTimes() function
     * Build locations open times
     * @param array $locationArray Location array
     * 
     */
    private function buildOpenTimes(&$locationArray) {
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

//E#buildOpenTimes() function
}

//E# LocationController() function