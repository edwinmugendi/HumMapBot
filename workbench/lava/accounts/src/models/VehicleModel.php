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
    //Fillable fields
    protected $fillable = array(
        'vrm',
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
        'vrm' => 'required',
        'is_default' => 'required|between:0,1',
        'purpose' => 'required|in:personal,business',
        'check_registry' => 'required|between:0,1|checkRegistry',
        'status' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    );

    /**
     * S# users() function
     * Set many to many relationship to User Model
     */
    public function users() {
        return $this->belongsToMany(\Util::buildNamespace('accounts', 'user', 2), 'acc_users_vehicles', 'vehicle_id', 'user_id');
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