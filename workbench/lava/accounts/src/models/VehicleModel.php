<?php

namespace Lava\Accounts;

/**
 * S# VehicleModel() Class
 * @author Edwin Mugendi
 * Vehicle Model
 */
class VehicleModel extends \Eloquent {

    //Table
    protected $table = 'acc_vehicles';
    //User owned
    public $userOwned = true;
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
        'user_owns'
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
        'type' => 'required|in:car,4x4',
        'force' => 'required|between:0,1',
        'vrm' => 'required|checkRegistry',
        'status' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    );
    //Update validation rules
    public $updateRules = array(
        'field' => 'required|in:id',
        'value' => 'required|exists:acc_vehicles,id',
        'is_default' => 'required|between:0,1',
        'purpose' => 'required|in:personal,business',
        'type' => 'required|in:car,4x4',
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
}

//E# VehicleModel() Class