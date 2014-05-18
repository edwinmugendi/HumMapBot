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

    /**
     * S# postCreate() function
     * Create model associated with this controller
     * 
     * @return function createRedirect
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
            return $this->createRedirect($controllerModel);
        }//E# if else statement
    }

//E# postCreate() function

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
        //Cache relation
        $relation = 'allVehicles';
        
        //Lazy load to load
        $parameters['lazyLoad'] = array($relation);

        //Get user by token
        $userModel = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getModelByField', array('token', $this->input['token'], $parameters));

        //Get current vrm's
        $currentVrmIds = $userModel->$relation->lists('id');

        if (!in_array($controllerModel->id, $currentVrmIds)) {
            array_push($currentVrmIds, $controllerModel->id);
            $userModel->vehicles()->sync($currentVrmIds);
        }//E# if else statement
        //Get user by token
        $userModel = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getModelByField', array('id', $this->user['id'], $parameters));

        //Count user vehicles
        $userVehicles = $userModel->$relation->count();
       
        //Data to update
        $dataToUpdate = array();
        if ($userVehicles == 1) {//Only one vehicle exists
            //Default
            $dataToUpdate['is_default'] = 1;

            //Update pivot table
            $this->updatePivotTable($userModel, 'allVehicles', $userModel->vehicles[0]->id, $dataToUpdate);
        }//E# if statement
        
        if ($userVehicles) {//Vehicles exists
            
            foreach ($userModel->$relation as $singleVehicle) {//Loop via the vehicles
                //Data to update
                $dataToUpdate = array();
                $inputVrm = \Str::lower($this->input['vrm']);
                $vehicleVrm = \Str::lower($singleVehicle->vrm);
                
                if ($inputVrm == $vehicleVrm) {
                    $dataToUpdate['dropped_at'] = 'null';
                }//E# if statement
                //Set is default
                if (($this->input['is_default'])) {
                    if ($inputVrm == $vehicleVrm) {
                        $dataToUpdate['is_default'] = 1;
                    } else {
                        $dataToUpdate['is_default'] = 0;
                    }//E# if else statement
                }//E# if else statement
                //Set force
                if (($this->input['force'])) {
                    if ($inputVrm == $vehicleVrm) {
                        $dataToUpdate['force'] = 1;
                    }//E# if statement
                }//E# if statement
                //Set purpose
                if (($this->input['purpose'])) {
                    if ($inputVrm == $vehicleVrm) {
                        $dataToUpdate['purpose'] = $this->input['purpose'];
                    }//E# if statement
                }//E# if statement

                if ($dataToUpdate) {//Update
                    //Update pivot
                    $this->updatePivotTable($userModel, $relation, $singleVehicle->id, $dataToUpdate);
                }//E# if statement
            }//# if else statement
        }//E# if statement
    }

//E# afterCreating() function


    public function postDrop() {
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