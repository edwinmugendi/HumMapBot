<?php

namespace Lava\Accounts;

/**
 * S# DeviceModel() Class
 * @author Edwin Mugendi
 * Device Model
 */
class DeviceModel extends \Eloquent {

    //Table
    protected $table = 'acc_devices';
    //User owned
    public $userOwned = true;
    //Fillable fields
    protected $fillable = array(
        'user_id',
        'os',
        'manufacturer',
        'model',
        'version',
        'app_version',
        'push_token',
        'unid',
        'status',
        'created_by',
        'updated_by'
    );
    protected $hidden = array(
        'status',
        'created_by',
        'updated_by',
        'deleted_at'
    );
    //Create validation rules
    public $createRules = array(
        'user_id' => 'integer',
        'os' => 'required',
        'manufacturer' => 'required',
        'model' => 'required',
        'version' => 'required',
        'app_version' => 'required',
        'unid' => 'required',
        'push_token' => '',
        'status' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    );
    //Update validation rules
    public $updateRules = array(
        'field' => 'required|in:id',
        'value' => 'required|integer|exists:acc_devices,id',
        'user_id' => 'integer',
        'os' => '',
        'manufacturer' => '',
        'model' => '',
        'version' => '',
        'app_version' => '',
        'unid' => '',
        'push_token' => '',
        'status' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    );
    //Delete validation rules
    public $deleteRules = array(
        'field' => 'required|in:id',
        'value' => 'required|integer|exists:acc_devices,id',
    );
    
    //Select validation rules
    public $selectRules = array(
        'field' => 'required|in:id',
        'value' => 'required|integer|exists:acc_devices,id',
    );

}

//E# DeviceModel() Class