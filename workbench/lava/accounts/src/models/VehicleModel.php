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
        'id' => array(1, 'text', '='),
    );
    //Fillable fields
    protected $fillable = array(
        'vrm',
        'type',
        'status',
        'created_by',
        'updated_by'
    );
    //Appends fields
    protected $appends = array(
        'user_owns',
        'is_default'
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
        'force' => 'required|between:0,1',
        'vrm' => 'required|checkRegistry',
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
        //'vrm' => 'checkRegistry',
        'status' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    );
    //Select validation rules
    public $selectRules = array(
        'field' => 'required|in:vrm',
        'value' => 'required',
    );

    /**
     * S# users() function
     * Set many to many relationship to User Model
     */
    public function users() {
        return $this->belongsToMany(\Util::buildNamespace('accounts', 'user', 2), 'acc_users_vehicles', 'vehicle_id', 'user_id')
                        ->whereNull('acc_users_vehicles.dropped_at');
    }

//E# users() function

    /**
     * S# getUserOwnsAttribute() function
     * Does the logged in user own this vehicle
     */
    public function getUserOwnsAttribute() {
        return $this->users()
                        ->whereUserId(\Auth::user()->id)
                        ->count();
    }

//E# getUserOwnsAttribute() function

    /**
     * S# getIsDefaultAttribute() function
     * Is this vehicle the default
     */
    public function getIsDefaultAttribute() {
        //Get the logged in user vrm
        //  $vrm = $this->users()->whereUserId(\Auth::user()->id)->first()->vrm;
        //  return ($this->attributes['vrm'] == $vrm) ? 1 : 0;
    }

//E# getIsDefaultAttribute() function
}

//E# VehicleModel() Class