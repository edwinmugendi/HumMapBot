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
     * S# controllerSpecificWhereClause() function
     * @author Edwin Mugendi
     * 
     * Set controller specific where clause
     * @param array $fields Fields
     * @param array $whereClause Where clause
     * @param array $parameters Parameters
     */
    public function controllerSpecificWhereClause(&$fields, &$whereClause, &$parameters) {

        if (array_key_exists('format', $this->input) && ($this->input['format'] == 'json')) {//From API
            //dd($this->input);
            if (!array_key_exists('id', $this->input)) {
                //Lazy load to load
                $params['lazyLoad'] = array('vehicles');

                //Get user by token
                $user_model = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getModelByField', array('token', $this->input['token'], $params));

                $vehicle_ids = array();

                if ($user_model && $user_model->vehicles) {
                    foreach ($user_model->vehicles as $single_vehicle) {
                        $vehicle_ids[] = $single_vehicle['id'];
                    }//E# foreach statement
                }//E# if statement

                $vehicle_ids = $vehicle_ids ? $vehicle_ids : array(0);

                if ($vehicle_ids) {
                    //Set where clause
                    $whereClause[] = array(
                        'where' => 'whereIn',
                        'column' => 'id',
                        'operator' => '=',
                        'operand' => $vehicle_ids
                    );
                }//E# if statement
            }//E# if statement
        }//E# if statement
    }

//E# controllerSpecificWhereClause() function

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
        $this->afterCreatingAndUpdating($controllerModel);
    }

//E# afterCreating() function

    /**
     * S# afterUpdating() function
     * @author Edwin Mugendi
     * Call this just after creating the model
     * Can be used to perform post create actions
     * @return 
     */
    public function afterUpdating(&$controllerModel) {
        $this->afterCreatingAndUpdating($controllerModel);
    }

//E# afterUpdating() function

    /**
     * S# afterCreatingAndUpdating() function
     * @author Edwin Mugendi
     * Call this just after creating or updating the model
     * Can be used to perform post create and update actions
     * @return 
     */
    private function afterCreatingAndUpdating(&$controllerModel) {
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
            $userModel->vehicles()->attach($controllerModel->id, array('created_at' => $now, 'updated_at' => $now));
        }//E# if else statement
        //Get user by token
        $userModel = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getModelByField', array('token', $this->input['token'], $parameters));

        //Count user vehicles
        $userVehicles = $userModel->$relation->count();

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

                if ($controllerModel->id == $singleVehicle->id) {
                    $dataToUpdate['dropped_at'] = 'null';
                    //Set is default
                    if (($this->input['is_default'])) {
                        //Default this vehicle
                        $userModel->vrm = $singleVehicle->vrm;

                        //Update save user
                        $saveUser = true;
                    }//E# if else statement
                    //Set force
                    $dataToUpdate['force'] = $this->input['force'];

                    //Set purpose
                    if (($this->input['purpose'])) {
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

//E# afterCreatingAndUpdating() function

    /**
     * S# postDrop() function
     * 
     * Drop vehicle
     */
    public function postDrop() {
        //TODO Set Deleted at field
        //TODO update or reset the users default vrm
        //Set validation rules
        $this->validationRules = array(
            'id' => 'required|integer|deleteVehicle'
        );
        //Validate inputs
        $this->isInputValid();
    }

//E# postDrop() function
}

//E# VehicleController() function