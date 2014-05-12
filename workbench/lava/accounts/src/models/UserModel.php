<?php

namespace Lava\Accounts;

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
        'long',
        'verification_code',
        'dob',
        'fb_uid',
        'address',
        'postal_code',
        'gender',
        'card',
        'role_id',
        'status',
        'created_by',
        'updated_by',
    );
    //Appends fields
    protected $appends = array(
        'default_vrm'
    );
    protected $hidden = array(
        'reset_code',
        'reset_time',
        'last_login',
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
        // 'email' => 'required|unique:acc_users',//TODO
        'email' => 'required|email', //TODO Uncomment above
        'location' => 'latLng',
        'role_id' => 'integer',
        'status' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    );
    //Create update rules
    public $updateRules = array(
        'email' => 'exists:acc_users', //TODO
        'location' => 'latLng',
    );

    /**
     * S# getDefaultVrmAttribute() function
     * Get user default vrm
     */
    public function getDefaultVrmAttribute() {
        $defaultVrm = $this->belongsToMany(\Util::buildNamespace('accounts', 'vehicle', 2), 'acc_users_vehicles', 'user_id', 'vehicle_id')
                        ->whereIsDefault(1)->first();
        if ($defaultVrm) {//User has default vrm
            return $defaultVrm->vrm;
        } else {//User has not set default vrm
            return 0;
        }//E# if else statement
    }

//E# getDefaultVrmAttribute() function

    /**
     * S# logins() function
     * Set one to many relationship to Login Model
     */
    public function logins() {
        return $this->hasMany(\Util::buildNamespace('accounts', 'login', 2), 'user_id');
    }

//E# logins() function

    /**
     * S# promotions() function
     * Set many to many relationship to Promotion Model
     */
    public function unredeemedPromotions() {
        return $this->belongsToMany(\Util::buildNamespace('products', 'promotion', 2), 'pdt_users_promotions', 'user_id', 'promotion_id')
                        ->whereRedeemed(0);
    }

//E# promotions() function

    /**
     * S# vehicles() function
     * Set many to many relationship to Vehicles Model
     */
    public function vehicles() {
        return $this->belongsToMany(\Util::buildNamespace('accounts', 'vehicle', 2), 'acc_users_vehicles', 'user_id', 'vehicle_id');
    }

//E# vehicles() function

    /**
     * S# cards() function
     * Set one to many relationship to Card Model
     */
    public function cards() {
        return $this->hasMany(\Util::buildNamespace('payments', 'card', 2), 'user_id');
    }

//E# cards() function

    /**
     * S# app55() function
     * Set one to one relationship to App55 Model
     */
    public function app55() {
        return $this->hasOne(\Util::buildNamespace('payments', 'app55', 2), 'user_id');
    }

//E# app55() function
}

//E# UserModel() Class