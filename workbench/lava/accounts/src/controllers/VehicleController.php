<?php

namespace Lava\Accounts;

use Carbon\Carbon;

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
            $now = Carbon::now();
            $userModel->vehicles()->attach($controllerModel->id,array('created_at'=> $now,'updated_at'=>$now));
        }//E# if else statement
        
        //Get user by token
        $userModel = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getModelByField', array('token', $this->input['token'], $parameters));

        //Count user vehicles
        $userVehicles = $userModel->$relation->count();

        //Data to update
        $dataToUpdate = array();

        //Save user
        $saveUser = false;

        if ($userVehicles == 1) {//Only one vehicle exists
            //Default this vehicle
            $userModel->vrm = $userModel->vehicles[0]->vrm;

            //Update save user
            $saveUser = true;
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
                        //Default this vehicle
                        $userModel->vrm = $singleVehicle->vrm;

                        //Update save user
                        $saveUser = true;
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

        if ($saveUser) {
            //Save model
            $userModel->save();
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