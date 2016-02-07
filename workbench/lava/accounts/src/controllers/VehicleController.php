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
            if (array_key_exists('id', $this->input)) {
                //Get model by id
                $vehicle_model = $this->getModelByField('id', $this->input['id']);
                
                if (!$vehicle_model || !$vehicle_model->user_owns) {
                    //Set notification
                    $this->notification = array(
                        'field' => 'vehicle_id',
                        'type' => 'Vehicle',
                        'value' => $this->input['id'],
                    );

                    //Throw Vehicle not found error
                    throw new \Api404Exception($this->notification);
                }//E# if else statement
            } else {
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
        $user_model = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getModelByField', array('token', $this->input['token'], $parameters));

        //Get current vrm's
        $currentVrmIds = $user_model->$relation->lists('id');

        if (!in_array($controllerModel->id, $currentVrmIds)) {
            $now = Carbon::now();
            $user_model->vehicles()->attach($controllerModel->id, array('created_at' => $now, 'updated_at' => $now));
        }//E# if else statement
        //Get user by token
        $user_model = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getModelByField', array('token', $this->input['token'], $parameters));

        //Count user vehicles
        $userVehicles = $user_model->$relation->count();

        //Save user
        $save_user = false;

        if ($userVehicles == 1) {//Only one vehicle exists
            //Default this vehicle
            $user_model->vrm = $user_model->vehicles[0]->vrm;

            //Update save user
            $save_user = true;
        }//E# if statement

        if ($userVehicles) {//Vehicles exists
            foreach ($user_model->$relation as $singleVehicle) {//Loop via the vehicles
                //Data to update
                $data_to_update = array();

                if ($controllerModel->id == $singleVehicle->id) {
                    $data_to_update['dropped_at'] = 'null';
                    //Set is default
                    if (($this->input['is_default'])) {
                        //Default this vehicle
                        $user_model->vrm = $singleVehicle->vrm;

                        //Update save user
                        $save_user = true;
                    } else {
                        //Default this vehicle
                        $user_model->vrm = '';
                        //Update save user
                        $save_user = true;
                    }//E# if else statement
                    //Set force
                    $data_to_update['force'] = $this->input['force'];

                    //Set purpose
                    if (($this->input['purpose'])) {
                        $data_to_update['purpose'] = $this->input['purpose'];
                    }//E# if statement
                }//E# if statement

                if ($data_to_update) {//Update
                    $data_to_update['status'] = 1;
                    $data_to_update['created_by'] = $this->user['id'];
                    $data_to_update['updated_by'] = $this->user['id'];
                    $data_to_update['ip'] = $this->input['ip'];
                    $data_to_update['agent'] = $this->input['agent'];
                    //Update pivot
                    $this->updatePivotTable($user_model, $relation, $singleVehicle->id, $data_to_update);
                }//E# if statement
            }//# if else statement
        }//E# if statement

        if ($save_user) {
            //Save model
            $user_model->save();
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