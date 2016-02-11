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

}

//E# VehicleModel() Class