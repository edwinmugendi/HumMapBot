<?php

namespace Lava\Accounts;

use GuzzleHttp\Client;

/**
 * S# VehicleController() function
 * Vehicle controller
 * @author Edwin Mugendi
 */
class VehicleController extends AccountsBaseController {

    //Controller
    public $controller = 'vehicle';
    //Searchable fields
    public $searchableFields = array('vrm');
    //User Searchable relations
    public $userSearchableRelations = array('vehicles');

    public function getVehicle($vrm = null) {
        if (is_null($vrm)) {//Get List of owned vehicles
            //Lazy load to load
            $parameters['lazyLoad'] = $this->userSearchableRelations;

            //Get user by token
            $userModel = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getModelByField', array('token', $this->input['token'], $parameters));

            $pluralController = $this->controller . 's';

            if ($this->subdomain == 'api') {//From API
                //Get success message
                $message = \Lang::get($this->package . '::' . $this->controller . '.api.getAll');

                throw new \Api200Exception($userModel->$pluralController->toArray(), $message);
            }//E# if else statement
        } else {//Get a single vehicle
            $this->input['vrm'] = $vrm;
            $this->validationRules = array(
                'vrm' => 'required'
            );
            //Validate vehicle
            $this->isInputValid();

            $vehicleModel = $this->getModelByField('vrm', $this->input['vrm']);

            if ($vehicleModel) {

                if ($vehicleModel->user_owns) {
                    //Get success message
                    $message = \Lang::get($this->package . '::' . $this->controller . '.api.getSingle', array('field' => 'vrm', 'value' => $this->input['vrm']));

                    throw new \Api200Exception($vehicleModel->toArray(), $message);
                } else {
                    //Set notification
                    $this->notification = array(
                        'field' => 'vrm',
                        'type' => 'Vehicle',
                        'value' => $this->input['vrm'],
                    );

                    //Throw Locationf not found error
                    throw new \Api403Exception($this->notification);
                }
            } else {
                //Set notification
                $this->notification = array(
                    'field' => 'vrm',
                    'type' => 'Vehicle',
                    'value' => $this->input['vrm'],
                );

                //Throw Locationf not found error
                throw new \Api404Exception($this->notification);
            }
        }
    }

    private function getVrmDetails($vrm) {

        $cwUsername = trim(\Config::get('accounts::thirdParty.carweb.username'));
        $cwPassword = trim(\Config::get('accounts::thirdParty.carweb.password'));
        $cwKey = trim(\Config::get('accounts::thirdParty.carweb.key'));
        $cwClientRef = trim(\Config::get('accounts::thirdParty.carweb.clientref'));
        $cwVersion = trim(\Config::get('accounts::thirdParty.carweb.version'));
        $cwUri = trim(\Config::get('accounts::thirdParty.carweb.url'));


        $bodyArray = array(
            'strUserName' => $cwUsername,
            'strPassword' => $cwPassword,
            'strClientRef' => $cwClientRef,
            'strClientDescription' => $cwClientRef,
            'strKey1' => $cwKey,
            'strVRM' => $vrm,
            'strVersion' => $cwVersion
        );

        //Create a guzzle client
        $guzzleClient = new Client();

        $response = $guzzleClient->get($cwUri . '?' . http_build_query($bodyArray));
        $xml = $response->xml();
        dd($xml);
        echo $xml->id;
        $xml = \Request::get($cwUri . '?' . http_build_query($bodyArray))
                ->expectsXml()
                ->send();
        dd($xml);
//            echo $xml;
//            print_r($xml);
//            $message=  json_encode($xml);
//            Log::write("debug-xml",$xml,true);
        $vehicle = new Account\Libraries\VehicleParser($xml->body->DataArea);

        return $vehicle;
    }

    /**
     * S# beforeCreating() function
     * @author Edwin Mugendi
     * Call this just before creating the model
     * Can be used to prepare the inputs
     * @param array $input The input
     * @return 
     */
    public function beforeCreating() {
        //TODO call Carweb API
        //$this->getVrmDetails($this->input['vrm']);
        $this->input['status'] = 1;
        $this->input['created_by'] = $this->user['id'] ? $this->user['id'] : 1;
        $this->input['updated_by'] = $this->user['id'] ? $this->user['id'] : 1;
        return;
    }

//E# beforeCreating() function

    /**
     * S# afterCreating() function
     * @author Edwin Mugendi
     * Call this just after creating the model
     * Can be used to prepare the inputs
     * @param array $input The input
     * @param object $contollerModel The model created
     * @return 
     */
    public function afterCreating(&$controllerModel) {
        //Lazy load to load
        $parameters['lazyLoad'] = array('vehicles');

        //Get user by token
        $userModel = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getModelByField', array('token', $this->input['token'], $parameters));

        $currentVrmIds = $userModel->vehicles->lists('id');

        if (!in_array($controllerModel->id, $currentVrmIds)) {
            array_push($currentVrmIds, $controllerModel->id);
            $userModel->vehicles()->sync($currentVrmIds);
        }//E# if else statement
        //Lazy load to load
        $parameters['lazyLoad'] = array('vehicles');

        //Get user by token
        $userModel = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getModelByField', array('token', $this->input['token'], $parameters));

        //Count user vehicles
        $userVehicles = $userModel->vehicles->count();

        $dataToUpdate = array();

        if ($userVehicles == 1) {

            $dataToUpdate['is_default'] = 1;

            $this->updatePivotTable($userModel, 'vehicles', $userModel->vehicles[0]->id, $dataToUpdate);
        }//E# if statement

        if ($userVehicles) {

            foreach ($userModel->vehicles as $singleVehicle) {
                $dataToUpdate = array();
                //Set is default
                if (($this->input['is_default'])) {
                    if ($this->input['vrm'] == $singleVehicle->vrm) {
                        $dataToUpdate['is_default'] = 1;
                    } else {
                        $dataToUpdate['is_default'] = 0;
                    }
                }

                //Set is default
                if (($this->input['check_registry'])) {
                    if ($this->input['vrm'] == $singleVehicle->vrm) {
                        $dataToUpdate['check_registry'] = 1;
                    }
                }//E# if statement

                if ($dataToUpdate) {
                    $this->updatePivotTable($userModel, 'vehicles', $singleVehicle->id, $dataToUpdate);

                    $singleVehicle->save();
                }//E# if statement
            }
        }
    }

//E# afterCreating() function

    /**
     * S# postCreate() function
     * @author Edwin Mugendi
     * Create a post
     */
    public function postCreate() {
        //Build model namespace
        $modelName = \Util::buildNamespace($this->package, $this->controller, 2);

        //Create a model object
        $model = new $modelName();

        //Get and set the model's create validation rules
        $this->validationRules = $model->createRules;

        //Validate row to be inserted
        $validation = $this->isInputValid();

        if ($validation->fails()) {//Validation fails
            //Validation error redirect
            return $this->failedValidationRedirect($validation, 1);
        } else {//Validation passes
            //Just before creating the model
            $this->beforeCreating();

            //Check if vehicle already exists
            $controllerModel = $this->getModelByField('vrm', $this->input['vrm']);

            if (!$controllerModel) {//Create it
                //Create controller model
                $controllerModel = $this->createIfValid($this->input, true);
            }//E# if statement
            //Just after creating the model
            $this->afterCreating($controllerModel);

            //Redirect to list
            return $this->listRedirect($controllerModel, 'create');
        }//E# if else statement
    }

//E# postCreate() function

    /**
     * S# listRedirect() function
     * @author Edwin Mugendi
     * Redirect to list
     * @param array $controller The controller
     * @param string $crudAction The Crud action
     * @return \Redirect redirect to list page
     */
    public function listRedirect($controllerModel, $crudAction) {
        if ($this->subdomain == 'api') {//From API
            //Get success message
            $message = \Lang::get($this->package . '::' . $this->controller . '.api.addVehicle', array('vrm' => $controllerModel->vrm));

            throw new \Api200Exception(array_only($controllerModel->toArray(), array('id', 'vrm')), $message);
        }//E# if else statement

        return \Redirect::route($this->controller . 'List');
    }

//E# listRedirect() function


    public function postDelete() {
        //TODO Set Deleted at field
        //TODO update or reset the users default vrm
        //Set validation rules
        $this->validationRules = array(
            'vrm' => 'required|vrmDelete'
        );
        //Validate inputs
        $this->isInputValid();
    }

}

//E# VehicleController() function