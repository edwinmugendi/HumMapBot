<?php

namespace Lava\Locations;

use Illuminate\Support\Facades\HTML;
use Lava\Locations\ArrayDataModel;

/**
 * S# LocationController() Class
 * @author Edwin Mugendi
 * Location Controller
 */
class LocationController extends LocationsBaseController {

    //Controller
    public $controller = 'location';

    /**
     * S# getLocationTemplate() function
     * @author Edwin Mugendi
     * Get map view
     * @param array $view_data media data array
     * @return view media view to upload media
     */
    public function getLocationTemplate() {
        $view_data = array(
            'package' => $this->package,
            'controller' => $this->controller
        );
        //Return media view to upload media
        return \View::make($this->package . '::' . $this->controller . '.templates.locationTemplate')
                        ->with('view_data', $view_data)
                        ->render();
    }

//E# getLocationTemplate() function

    /**
     * S# getMapView() function
     * @author Edwin Mugendi
     * Get map view
     * @param array $view_data media data array
     * @return view media view to upload media
     */
    public function getMapView($lat, $lng) {
        
        //Return media view to upload media
        return \View::make('locations::location.mapView')
                        ->with('lat', $lat)
                        ->with('lng', $lng)
                        ->render();
    }

//E# getMapView() function

    /**
     * S# getLocationSelectOptions() function
     * Get location select options
     * @return Array The select options
     */
    public function getLocationSelectOptions() {
        //Build the function name
        $function = camel_case('get_' . $this->controller . 'SelectOptions');

        //Return this locations select options
        return ArrayDataModel::$function($this->package, $this->controller);
    }

//E# getLocationSelectOptions() function

    /**
     * S# getLocationKey() function
     * @author Edwin Mugendi
     * Get the parent location primary key based on the controller
     * @return string primary key
     */
    protected function getLocationKey() {

        if ($this->controller == 'town') {//Town
            $locationKey = 'country_id';
        } else if ($this->controller == 'estate') {//Estate
            $locationKey = 'town_id';
        }//E# if else statement
        //Return the location key
        return $locationKey;
    }

    public function getPrefetch() {
        //Camelize cache name
        $cacheName = 'autoCompleteLocations';

        \Cache::section($this->package)->flush($cacheName);

        if (!\Cache::section($this->package)->has($cacheName)) {//Location options not in cache
            //Fields to select
            $fields = array('id', 'name');
            //Build where clause
            $where_clause = array(
                array(
                    'where' => 'where',
                    'column' => 'id',
                    'operator' => '=',
                    'operand' => 67 //Nairobi
                ),
                array(
                    'where' => 'orWhere',
                    'column' => 'id',
                    'operator' => '=',
                    'operand' => 36 //Kikuyu
                ),
                array(
                    'where' => 'orWhere',
                    'column' => 'id',
                    'operator' => '=',
                    'operand' => 81 //Ruiru
                ),
                array(
                    'where' => 'orWhere',
                    'column' => 'id',
                    'operator' => '=',
                    'operand' => 1 //Athi River / Mavoko
                ),
                array(
                    'where' => 'orWhere',
                    'column' => 'id',
                    'operator' => '=',
                    'operand' => 63 //Mombasa
                ),
                array(
                    'where' => 'where',
                    'column' => 'is_verified',
                    'operator' => '=',
                    'operand' => 1
                ),
                array(
                    'where' => 'where',
                    'column' => 'status',
                    'operator' => '=',
                    'operand' => 1
                )
            );
            //Build extra parameters
            $parameters = array();
            $parameters['orderBy'][] = array('name' => 'asc');
            $parameters['convertTo'] = 'toArray';
            $parameters['lazyLoad'] = array('estates');

            //Select all active towns models
            $townModel = $this->select($fields, $where_clause, 2, $parameters);

            //Array cache 
            $locationCache = $location = array();

            if ($townModel) {//There exist a location
                foreach ($townModel as $singleTownModel) {//Loop through town model
                    //Define the town datum
                    $datum = array();
                    $singleTownModel['name'] = HTML::decode($singleTownModel['name']);
                    $datum['value'] = $singleTownModel['name'] . ', All estates';
                    $datum['tokens'] = $singleTownModel['name'];
                    $datum['id'] = '0,' . $singleTownModel['id'];

                    //Add the datum to location cache
                    $locationCache[] = $datum;
                    foreach ($singleTownModel['estates'] as $singleEstateModel) {
                        //Define the estate datum
                        $datum = array();
                        $singleEstateModel['name'] = HTML::decode($singleEstateModel['name']);
                        $datum['value'] = $singleEstateModel['name'] . ', ' . $singleTownModel['name'];
                        $datum['tokens'] = array($singleEstateModel['name'], $singleTownModel['name']);
                        $datum['id'] = $singleEstateModel['id'] . ',' . $singleTownModel['id'];

                        //Add the datum to location cache
                        $locationCache[] = $datum;
                    }//E# foreach statement
                }//E# foreach statement
            }//E# if statement
            //Cache type select options
            \Cache::section($this->package)->forever($cacheName, $locationCache);
        }//E# if statement
        //Return location cache
        return \Cache::section($this->package)->get($cacheName);
    }

//E# getPrefetch() function

    /**
     * S# locationNotInList() function
     * @author Edwin Mugendi
     * First check if a sub location is not in the list and notify us accordingly, else return that the sublocation exist
     * @return JSON Notification
     */
    public function exists() {
        //Set action
        $this->action = 'getting';

        //Get the location key 
        $locationKey = $this->getLocationKey();

        //Get the validation rules
        $this->validationRules = array(
            $locationKey => 'integer'
        );

        //Validate inputs
        $this->isInputValid($this->input);

        //Fields to select
        $fields = array('name');

        //Build where clause
        $where_clause = array(
            array(
                'where' => 'where',
                'column' => $locationKey,
                'operator' => '=',
                'operand' => $this->input[$locationKey]
            ),
            array(
                'where' => 'where',
                'column' => 'name',
                'operator' => '=',
                'operand' => $this->input['location']
            ),
            array(
                'where' => 'where',
                'column' => 'is_verified',
                'operator' => '=',
                'operand' => 1
            ),
            array(
                'where' => 'where',
                'column' => 'status',
                'operator' => '=',
                'operand' => 1
            )
        );
        //Build extra parameters
        $parameters = array();
        $parameters['convertTo'] = 'toArray';

        //Select all active location models
        $locationModel = $this->select($fields, $where_clause, 1, $parameters);

        //Count model
        $locationCount = count($locationModel);

        if ($locationModel) {//Town model exists
            $this->notification = array(
                'type' => 'success',
                'message' => 1
            );
        } else {//Town does not exist
            //Build notification
            $this->notification = array(
                'type' => 'success',
                'message' => 0,
            );

            //Define Issue row
            $issueRow = array(
                'notification_id' => 904,
                'issuer_id' => 1,
                'issuee_id' => 1,
                'controller' => $this->controller,
                'description' => json_encode(array($this->controller => \Str::title($this->input['location']), 'id' => $this->input[$locationKey])),
                'priority' => 1,
                'status' => 1,
                'created_by' => $this->user['id'], //USER_ID
                'updated_by' => 1//USER_ID
            );

            //Create issue model
            $this->callController(\Util::buildNamespace('system', 'issue', 1), 'createIfValid', array($issueRow));
        }//E# if else statement
        //Return the notification a as JSON
        return \Response::json($this->notification);
    }

//E# locationNotInList() function

    /**
     * S# getLocations() function
     * @author Edwin Mugendi
     * Gets the sub location details for a given location id
     * @return json details
     */
    public function getLocations() {
        //Get the location key 
        $locationKey = $this->getLocationKey();

        //Get the validation rules
        $this->validationRules = array(
            $locationKey => 'integer'
        );

        //Validate inputs
        $this->isInputValid($this->input);

        //Return this locations
        return $this->getSelectOptionsByLocation($this->input[$locationKey], 'alphaList');
    }

//E# getLocations() function

    /**
     * S# getSelectOptionsByCountry() function
     * @author Edwin Mugendi
     * Get towns select options for a given country
     * @param int $countryId the ID of the country
     * @param string $listType the type of the list
     * @return array location select options
     */
    public function getSelectOptionsByLocation($locationId, $listType) {

        $locationKey = $this->getLocationKey();
        //Camelize cache name
        $cacheName = camel_case($locationId . '_SelectOptions');

        \Cache::section($this->package)->flush($cacheName);

        if (!\Cache::section($this->package)->has($cacheName)) {//Location options not in cache
            //Fields to select
            $fields = array('id', 'name');
            //Build where clause
            $where_clause = array(
                array(
                    'where' => 'where',
                    'column' => $locationKey,
                    'operator' => '=',
                    'operand' => $locationId
                ),
                array(
                    'where' => 'where',
                    'column' => 'status',
                    'operator' => '=',
                    'operand' => 1
                )
            );
            //Build extra parameters
            $parameters = array();
            $parameters['orderBy'][] = array('name' => 'asc');
            $parameters['convertTo'] = 'toArray';

            //Select all active location models
            $locationModel = $this->select($fields, $where_clause, 2, $parameters);

            //Array cache 
            $selectOptionsCache = array();
            if ($locationModel) {//There exist a location
                foreach ($locationModel as $singleLocationModel) {//Loop through location model
                    $optionAttributes = array();
                    $optionAttributes['text'] = HTML::decode($singleLocationModel['name']);
                    $optionAttributes['latitude'] = $singleLocationModel['latitude'];
                    $optionAttributes['longitude'] = $singleLocationModel['longitude'];
                    $optionAttributes['id'] = $singleLocationModel['id'];

                    //Append location option to the alphabetical list cache
                    $selectOptionsCache['alphaList'][] = $optionAttributes;

                    if ($singleLocationModel['is_popular'] == 1) {//This location is popular
                        //Append location option to the popular cache
                        $selectOptionsCache['popular'][] = $optionAttributes;
                    }//E# if else statement 
                }//E# foreach statement
            } else {//No location found
                $selectOptionsCache['alphaList'] = $selectOptionsCache['popular'] = array();
            }//E# if else statement
            //Cache type select options
            \Cache::section($this->package)->forever($cacheName, $selectOptionsCache);
        }//E# if statement

        if ($listType == 'alphaList') {//Get options in alphabetical order only   
            $alphaList = \Cache::section($this->package)->get($cacheName);
            $selectOptions['alphaList'] = $alphaList['alphaList'];
        } else if ($listType == 'alphaPopularList') {//Get both popular options and options in alphabetical order 
            $selectOptions = \Cache::section($this->package)->get($cacheName);
        }//E# if else statement
        //Return cached type select option
        return $selectOptions;
    }

//E# getSelectOptionsByLocation() function 
}

//E# LocationController() Class