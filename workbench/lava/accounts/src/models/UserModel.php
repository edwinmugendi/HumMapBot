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
        'organization_id' => array(1, 'select', '='),
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
        'organization_id',
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
     * S# organization() function
     * Set one to one relationship to Organization Model
     */
    public function organization() {
        return $this->belongsTo(\Util::buildNamespace('organizations', 'organization', 2), 'organization_id');
    }

//E# organization() function

    /**
     * S# getOrganizationIdTextAttribute() function
     * 
     * Get Organization Text
     */
    public function getOrganizationIdTextAttribute() {

        //Get organization model
        $organization_model = $this->org()->first();

        //Return name
        return $organization_model ? $organization_model->name : '';
    }

//E# getOrganizationIdTextAttribute() function

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
     * S# organizations() function
     * Set one to one relationship to Organizations Model
     */
    public function organizations() {
        return $this->hasMany(\Util::buildNamespace('organizations', 'organization', 2), 'user_id');
    }

//E# organizations() function
}

//E# UserModel() Class