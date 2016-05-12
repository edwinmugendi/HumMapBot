<?php

namespace Lava\Accounts;

use Carbon\Carbon;

/**
 * S# UserModel() Class
 * @author Edwin Mugendi
 * User Model
 */
class UserModel extends \BaseModel {

    //Table
    protected $table = 'acc_users';
    //View fields
    public $viewFields = array(
        'id' => array(1, 'text', '='),
        'merchant_id' => array(1, 'select', '='),
        'full_name' => array(1, 'text', 'like', 1),
        'role_id' => array(1, 'select', '=', 0),
        'email' => array(1, 'text', 'like', 0),
        'phone' => array(1, 'text', 'like', 0),
        'referral_code' => array(1, 'text', '=', 0),
        'dob' => array(0, 'text', 'like', 0),
        'gender' => array(0, 'text', 'like', 0),
        'notify_sms' => array(0, 'select', '=', 0),
        'notify_email' => array(0, 'select', '=', 0),
        'notify_push' => array(0, 'select', '=', 0),
        'device_token' => array(0, 'text', 'like', 0),
        'app_version' => array(0, 'text', 'like', 0),
    );
    //Fillable fields
    protected $fillable = array(
        'merchant_id',
        'full_name',
        'phone',
        'password',
        'email',
        'verification_code',
        'referral_code',
        'dob',
        'gender',
        'notify_sms',
        'notify_email',
        'notify_push',
        'device_token',
        'app_version',
        'role_id',
        'agent',
        'ip',
        'status',
        'created_by',
        'updated_by',
    );
    protected $hidden = array(
        'reset_code',
        'reset_time',
        'last_login',
        'ip',
        'verification_code',
        'username',
        'password',
        'status',
        'created_by',
        'updated_by',
        'deleted_at'
    );
    //Create validation rules
    public $createRules = array(
        'full_name' => 'required',
            /*
              'phone' => 'required',
              'password' => 'required',
              'email' => 'required|unique:acc_users', //TODO
              'role_id' => 'integer',
              'notify_sms' => 'integer|between:0,1',
              'notify_email' => 'integer|between:0,1',
              'notify_push' => 'integer|between:0,1',
             * 
             */
    );
    //Create update rules
    public $updateRules = array(
        'id' => 'exists:acc_users',
        'email' => 'unique:acc_users',
        'notify_sms' => 'integer|between:0,1',
        'notify_email' => 'integer|between:0,1',
        'notify_push' => 'integer|between:0,1',
        'device_token' => '',
    );

    /**
     * S# merchant() function
     * Set one to one relationship to Merchant Model
     */
    public function merchant() {
        return $this->belongsTo(\Util::buildNamespace('merchants', 'merchant', 2), 'merchant_id');
    }

//E# merchant() function

    /**
     * S# getMerchantIdTextAttribute() function
     * 
     * Get Merchant Text
     */
    public function getMerchantIdTextAttribute() {

        //Get merchant model
        $merchant_model = $this->merchant()->first();

        //Return name
        return $merchant_model ? $merchant_model->name : '';
    }

//E# getMerchantIdTextAttribute() function

    /**
     * S# getRoleIdTextAttribute() function
     * 
     * Get RoleId Text
     */
    public function getRoleIdTextAttribute() {
        return \Lang::has('accounts::user.data.role_id.' . $this->attributes['role_id']) ? \Lang::get('accounts::user.data.role_id.' . $this->attributes['role_id']) : '';
    }

//E# getRoleIdTextAttribute() function

    /**
     * S# logins() function
     * Set one to many relationship to Login Model
     */
    public function logins() {
        return $this->hasMany(\Util::buildNamespace('accounts', 'login', 2), 'user_id');
    }

//E# logins() function

    /**
     * S# transactions() function
     * Set one to many relationship to Card Model
     */
    public function transactions() {
        return $this->hasMany(\Util::buildNamespace('payments', 'transaction', 2), 'user_id');
    }

//E# transactions() function

    /**
     * S# merchants() function
     * Set one to one relationship to Merchants Model
     */
    public function merchants() {
        return $this->hasMany(\Util::buildNamespace('merchants', 'merchant', 2), 'user_id');
    }

//E# merchants() function
}

//E# UserModel() Class