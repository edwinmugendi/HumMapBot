<?php

namespace Lava\Accounts;

/**
 * S# VehicleModel() Class
 * @author Edwin Mugendi
 * Vehicle Model
 */
class VehicleModel extends \BaseModel {

    //Table
    protected $table = 'acc_vehicles';
    //View fields
    public $viewFields = array(
        'id' => array(1, 'text', '=', 0),
        'vrm' => array(1, 'text', 'like', 1),
        'user_id' => array(1, 'select', '=', 1),
        'purpose' => array(1, 'text', 'like', 0),
        'type' => array(1, 'select', '=', 0),
        'is_default' => array(0, 'select', '=', 0),
        'make' => array(0, 'text', 'like', 0),
        'model' => array(0, 'text', 'like', 0),
        'six_month_rate' => array(0, 'text', 'like', 0),
        'twelve_month_rate' => array(0, 'text', 'like', 0),
        'date_of_first_registration' => array(0, 'text', 'like', 0),
        'year_of_manufacture' => array(0, 'text', 'like', 0),
        'cylinder capacity' => array(0, 'text', 'like', 0),
        'co2_emisssions' => array(0, 'text', 'like', 0),
        'fuel_type' => array(0, 'text', 'like', 0),
        'tax_status' => array(0, 'text', 'like', 0),
        'colour' => array(0, 'text', 'like', 0),
        'type_approval' => array(0, 'text', 'like', 0),
        'wheel_plan' => array(0, 'text', 'like', 0),
        'revenue_weight' => array(0, 'text', 'like', 0),
        'tax_details' => array(0, 'text', 'like', 0),
        'mot_details' => array(0, 'text', 'like', 0),
        'taxed' => array(0, 'select', '=', 0),
        'mot' => array(0, 'select', '=', 0),
        'api_status' => array(0, 'text', 'like', 0),
        'api_message' => array(0, 'text', 'like', 0),
    );
    //Fillable fields
    protected $fillable = array(
        'user_id',
        'vrm',
        'type',
        'purpose',
        'is_default',
        'agent',
        'ip',
        'status',
        'created_by',
        'updated_by'
    );
    //Appends fields
    protected $appends = array(
        'user_id_text',
    );
    protected $hidden = array(
        'status',
        'created_by',
        'updated_by',
        'deleted_at'
    );
    //Create validation rules
    public $createRules = array(
        'is_default' => 'required|between:0,1',
        'purpose' => 'required|in:personal,business',
        'type' => 'required|between:1,2',
        'vrm' => 'required',
        'status' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    );
    //Update validation rules
    public $updateRules = array(
        'id' => 'required|exists:acc_vehicles,id',
        'is_default' => 'between:0,1',
        'purpose' => 'in:personal,business',
        'type' => 'between:1,2',
        'status' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    );

    /**
     * S# user() function
     * Set one to one relationship to User Model
     */
    public function user() {
        return $this->belongsTo(\Util::buildNamespace('accounts', 'user', 2), 'user_id', 'id');
    }

//E# user() function

    /**
     * S# getUserIdTextAttribute() function
     * 
     * Get User Text
     */
    public function getUserIdTextAttribute() {

        //Get user model
        $user_model = $this->user()->first();

        //Return name
        return $user_model ? $user_model->first_name . ' ' . $user_model->last_name : '';
    }

//E# getUserIdTextAttribute() function
        
    /**
     * S# getTypeTextAttribute() function
     * 
     * Get Type Text
     */
    public function getTypeTextAttribute() {
        return \Lang::has('accounts::vehicle.data.type.' . $this->attributes['type']) ? \Lang::get('accounts::vehicle.data.type.' . $this->attributes['type']) : '';
    }

//E# getTypeTextAttribute() function

        /**
     * S# getTaxedTextAttribute() function
     * Get Taxed Text
     */
    public function getTaxedTextAttribute() {
        //Set icon
        $icon = $this->attributes['taxed'] ? 'glyphicon-ok commonColor' : 'glyphicon-remove commonColorRed';

        return '<i class="glyphicon ' . $icon . '"></i>';
    }

//E# getTaxedTextAttribute() function
    
    
        /**
     * S# getMotTextAttribute() function
     * Get Mot Text
     */
    public function getMotTextAttribute() {
        //Set icon
        $icon = $this->attributes['mot'] ? 'glyphicon-ok commonColor' : 'glyphicon-remove commonColorRed';

        return '<i class="glyphicon ' . $icon . '"></i>';
    }

//E# getMotTextAttribute() function

}

//E# VehicleModel() Class