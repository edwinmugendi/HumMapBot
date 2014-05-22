<?php

namespace Lava\Accounts;

use Carbon\Carbon;

/**
 * S# UserModel() Class
 * @author Edwin Mugendi
 * User Model
 */
class UserModel extends \Eloquent {

    //Table
    protected $table = 'acc_users';
    //Fillable fields
    protected $fillable = array(
        'first_name',
        'last_name',
        'phone',
        'password',
        'email',
        'lat',
        'lng',
        'verification_code',
        'dob',
        'fb_uid',
        'address',
        'postal_code',
        'gender',
        'notify_sms',
        'notify_email',
        'notify_push',
        'os',
        'push_token',
        'app_version',
        'role_id',
        'status',
        'created_by',
        'updated_by',
    );
    protected $hidden = array(
        'reset_code',
        'reset_time',
        'last_login',
        'role_id',
        'ip_address',
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
        'first_name' => 'required',
        'last_name' => 'required',
        'phone' => 'required',
        'password' => 'required',
        'verification_code' => '',
         'email' => 'required|unique:acc_users',//TODO
        //'email' => 'required|email', //TODO Uncomment above
        'location' => 'latLng',
        'role_id' => 'integer',
        'notify_sms' => 'integer|between:0,1',
        'notify_email' => 'integer|between:0,1',
        'notify_push' => 'integer|between:0,1',
        'status' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    );
    //Create update rules
    public $updateRules = array(
        'email' => 'exists:acc_users', //TODO
        'location' => 'latLng',
        'notify_sms' => 'integer|between:0,1',
        'notify_email' => 'integer|between:0,1',
        'notify_push' => 'integer|between:0,1',
        'push_token' => '',
        'os' => 'in:ios,android',
        'old_password' => 'required_with:old_password',
        'new_password' => 'required_with:new_password|min:6|password',
    );

    /**
     * S# logins() function
     * Set one to many relationship to Login Model
     */
    public function logins() {
        return $this->hasMany(\Util::buildNamespace('accounts', 'login', 2), 'user_id');
    }

//E# logins() function

    /**
     * S# devices() function
     * Set one to many relationship to Device Model
     */
    public function devices() {
        return $this->hasMany(\Util::buildNamespace('accounts', 'device', 2), 'user_id');
    }

//E# devices() function

    /**
     * S# promotions() function
     * Set many to many relationship to Promotion Model
     */
    public function promotions() {
        return $this->belongsToMany(\Util::buildNamespace('products', 'promotion', 2), 'pdt_users_promotions', 'user_id', 'promotion_id');
    }

//E# promotions() function

    /**
     * S# promotions() function
     * Set many to many relationship to Promotion Model
     */
    public function unredeemedPromotions() {
        return $this->promotions()
                        ->whereRedeemed(0)
                        ->where('expiry_date', '<', Carbon::now());
    }

//E# promotions() function

    /**
     * S# vehicles() function
     * Set many to many relationship to Vehicle Model
     */
    public function vehicles() {
        return $this->belongsToMany(\Util::buildNamespace('accounts', 'vehicle', 2), 'acc_users_vehicles', 'user_id', 'vehicle_id')
                        ->whereNull('acc_users_vehicles.dropped_at');
    }

//E# vehicles() function

    /**
     * S# allVehicles() function
     * Set many to many relationship to Vehicle Model
     */
    public function allVehicles() {
        return $this->belongsToMany(\Util::buildNamespace('accounts', 'vehicle', 2), 'acc_users_vehicles', 'user_id', 'vehicle_id');
    }

//E# allVehicles() function

    /**
     * S# cards() function
     * Set one to many relationship to Card Model
     */
    public function cards() {
        return $this->hasMany(\Util::buildNamespace('payments', 'card', 2), 'user_id');
    }

//E# cards() function
}

//E# UserModel() Class