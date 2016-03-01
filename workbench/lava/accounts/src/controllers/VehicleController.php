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

    /**
     * S# beforeCreating() function
     * @author Edwin Mugendi
     * Call this just before creating the model
     * Can be used to prepare the inputs
     * @return 
     */
    public function beforeCreating() {
        if (array_key_exists('format', $this->input) && ($this->input['format'] == 'json')) {//From API
            $this->input['user_id'] = $this->user['id'];
        }//E# if statement

        $this->input['status'] = 1;
        $this->input['created_by'] = $this->user['id'] ? $this->user['id'] : 1;
        $this->input['updated_by'] = $this->user['id'] ? $this->user['id'] : 1;
        return;
    }

//E# beforeCreating() function

    /**
     * S# injectDataSources() function
     * @author Edwin Mugendi
     * Inject data source. This are mainly select
     * 
     * @param array $dataSource Data source
     */
    public function injectDataSources() {

        //Get this organization user id
        $this->view_data['dataSource']['user_id'] = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getMerchantsHtmlSelect', array($this->merchant['id'], 'id', array('first_name', 'last_name'), \Lang::get('common.select')));

        //Get and set type options to data source
        $this->view_data['dataSource']['type'] = \Lang::get($this->package . '::' . $this->controller . '.data.type');
    }

//E# injectDataSources() function

    /**
     * S# controllerSpecificWhereClause() function
     * @author Edwin Mugendi
     * 
     * Set controller specific where clause
     * @param array $fields Fields
     * @param array $where_clause Where clause
     * @param array $parameters Parameters
     */
    public function controllerSpecificWhereClause(&$fields, &$where_clause, &$parameters) {

        if (array_key_exists('format', $this->input) && ($this->input['format'] == 'json')) {//From API
            if (array_key_exists('id', $this->input)) {

                //Get model by id
                $vehicle_model = $this->getModelByField('id', $this->input['id']);

                if ($vehicle_model && ($vehicle_model->status == 1) && ($vehicle_model->user_id == $this->user['id'])) {
                    $message = \Lang::get($this->package . '::' . $this->controller . '.notification.list');

                    $vehicle_array = $vehicle_model->toArray();

                    unset($vehicle_array['user']);

                    //Throw Vehicle not found error
                    throw new \Api200Exception($vehicle_array, $message);
                } else {
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
                $where_clause[] = array(
                    'where' => 'where',
                    'column' => 'user_id',
                    'operator' => '=',
                    'operand' => $this->user['id']
                );
            }//E# if else statement
        } else {
            if ($this->user['role_id'] == 2) {//Merchant
                //Transaction fields
                $transaction_fields = array('vehicle_id');
                
                //Transaction where clause
                $transaction_where_clause = array(
                    array(
                        'where' => 'where',
                        'column' => 'merchant_id',
                        'operator' => '=',
                        'operand' => $this->user['merchant_id']
                    )
                );

                //Get transactions
                $transaction_model = $this->callController(\Util::buildNamespace('payments', 'transaction', 1), 'select', array($transaction_fields, $transaction_where_clause, 2));

                if ($transaction_model) {
                    $vehicle_ids = array_unique($transaction_model->lists('vehicle_id'));
                } else {
                    $vehicle_ids = array(0);
                }//E# if else statement
                
                $where_clause[] = array(
                    'where' => 'whereIn',
                    'column' => 'id',
                    'operand' => $vehicle_ids
                );
            }//E# if statement
        }//E# if else statement
    }

//E# controllerSpecificWhereClause() function

    /**
     * S# afterCreating() function
     * @author Edwin Mugendi
     * Call this just after creating the model
     * Can be used to prepare the inputs
     * @param array $input The input
     * @param object $contollerModel The model created
     * @return 
     */
    public function afterCreating(&$controller_model) {
        $this->afterCreatingAndUpdating($controller_model);
    }

//E# afterCreating() function

    /**
     * S# afterUpdating() function
     * @author Edwin Mugendi
     * Call this just after creating the model
     * Can be used to perform post create actions
     * @return 
     */
    public function afterUpdating(&$controller_model) {
        $this->afterCreatingAndUpdating($controller_model);
    }

//E# afterUpdating() function

    /**
     * S# afterCreatingAndUpdating() function
     * @author Edwin Mugendi
     * Call this just after creating or updating the model
     * Can be used to perform post create and update actions
     * @return 
     */
    private function afterCreatingAndUpdating($controller_model) {
        if (array_key_exists('is_default', $this->input) && $this->input['is_default']) {
            $this->makeVehicleDefault($controller_model->id, false);
        }//E# if statement
        //Get vehicle details
        $dvlasearch_response = $this->callController(\Util::buildNamespace('accounts', 'dvlasearch', 1), 'getVehicleDetails', array($controller_model->vrm));

        if ($dvlasearch_response['status']) {

            if (array_key_exists('error', $dvlasearch_response['response'])) {
                //Error = 0 - No vehicle
                //Error = 1 - API error
                $controller_model->api_status = $dvlasearch_response['response']['error'];
                $controller_model->api_message = $dvlasearch_response['response']['message'];
            } else {
                $controller_model->api_status = 2; //Vehicle found
                $controller_model->api_message = '';

                $controller_model->make = $dvlasearch_response['response']['make'];
                $controller_model->model = $dvlasearch_response['response']['model'];
                $controller_model->six_month_rate = $dvlasearch_response['response']['sixMonthRate'];
                $controller_model->twelve_month_rate = $dvlasearch_response['response']['twelveMonthRate'];
                $controller_model->date_of_first_registration = $dvlasearch_response['response']['dateOfFirstRegistration'];
                $controller_model->year_of_manufacture = $dvlasearch_response['response']['yearOfManufacture'];
                $controller_model->cylinder_capacity = $dvlasearch_response['response']['cylinderCapacity'];
                $controller_model->co2_emissions = $dvlasearch_response['response']['co2Emissions'];
                $controller_model->fuel_type = $dvlasearch_response['response']['fuelType'];
                $controller_model->tax_status = $dvlasearch_response['response']['taxStatus'];
                $controller_model->colour = $dvlasearch_response['response']['colour'];
                $controller_model->type_approval = $dvlasearch_response['response']['typeApproval'];
                $controller_model->wheel_plan = $dvlasearch_response['response']['wheelPlan'];
                $controller_model->revenue_weight = $dvlasearch_response['response']['revenueWeight'];
                $controller_model->tax_details = $dvlasearch_response['response']['taxDetails'];
                $controller_model->mot_details = $dvlasearch_response['response']['motDetails'];
                $controller_model->taxed = (boolean) $dvlasearch_response['response']['taxed'];
                $controller_model->mot = (boolean) $dvlasearch_response['response']['mot'];
            }//E# if else statement
        } else {
            $controller_model->api_status = 3; //API failure
            $controller_model->api_message = $dvlasearch_response['response'];
        }//E# if else statement
        //Save controller
        $controller_model->save();
    }

//E# afterCreatingAndUpdating() function

    /**
     * S# makeVehicleDefault() function
     * 
     * Make vehicle default
     * 
     * @param int $vehicle_id Vehicle id
     * @param boolean $save Should we save this vehicle as default if it's not yet saved
     * 
     */
    public function makeVehicleDefault($vehicle_id, $save) {
        if ($save) {
            //Set where clause
            $where_clause = array(
                array(
                    'where' => 'where',
                    'column' => 'id',
                    'operator' => '=',
                    'operand' => $vehicle_id
                )
            );

            $data_to_update = array(
                'is_default' => 1
            );

            $this->massUpdate($where_clause, $data_to_update);
        }//E# if statement
        //Set where clause
        $where_clause = array(
            array(
                'where' => 'where',
                'column' => 'id',
                'operator' => '=',
                'operand' => $this->user['id']
            )
        );

        $data_to_update = array(
            'vehicle_id' => $vehicle_id
        );

        //Update user
        $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'massUpdate', array($where_clause, $data_to_update));

        //Fields
        $fields = array('id');

        //Set where clause
        $where_clause = array(
            array(
                'where' => 'where',
                'column' => 'user_id',
                'operator' => '=',
                'operand' => $this->user['id']
            ),
            array(
                'where' => 'where',
                'column' => 'is_default',
                'operator' => '=',
                'operand' => 1
            )
        );
        $parameters['scope'] = array('statusOne');

        $vehicle_model = $this->select($fields, $where_clause, 2, $parameters);

        $vehicle_ids = $vehicle_model->lists('id');

        $clean_vehicle_ids = array_diff($vehicle_ids, array($vehicle_id));

        if ($clean_vehicle_ids) {
            //Set where clause
            $where_clause = array(
                array(
                    'where' => 'whereIn',
                    'column' => 'id',
                    'operator' => '=',
                    'operand' => $clean_vehicle_ids
                )
            );

            $data_to_update = array(
                'is_default' => 0
            );

            $this->massUpdate($where_clause, $data_to_update);
        }//E# if statement
    }

//E# makeVehicleDefault() function

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