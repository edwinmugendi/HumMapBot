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
        'first_name' => array(1, 'text', 'like', 1),
        'last_name' => array(1, 'text', 'like', 1),
        'role_id' => array(1, 'select', '=', 0),
        'email' => array(1, 'text', 'like', 0),
        'phone' => array(1, 'text', 'like', 0),
        'vehicle_id' => array(1, 'text', '=', 0),
        'card_id' => array(1, 'text', '=', 0),
        'dob' => array(0, 'text', 'like', 0),
        'gender' => array(0, 'text', 'like', 0),
        'lat' => array(0, 'text', 'like', 0),
        'lng' => array(0, 'text', 'like', 0),
        'address' => array(1, 'text', 'like', 0),
        'postal code' => array(1, 'text', 'like', 0),
        'notify_sms' => array(0, 'select', '=', 0),
        'notify_email' => array(0, 'select', '=', 0),
        'notify_push' => array(0, 'select', '=', 0),
        'device_token' => array(0, 'text', 'like', 0),
        'fb_uid' => array(0, 'text', 'like', 0),
        'stripe_id' => array(0, 'text', 'like', 0),
        'os' => array(0, 'text', 'like', 0),
        'app_version' => array(0, 'text', 'like', 0),
    );
    //Fillable fields
    protected $fillable = array(
        'merchant_id',
        'vehicle_id',
        'card_id',
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
        'vehicle_id',
        'card_token',
        'device_token',
        'app_version',
        'role_id',
        'points',
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
        'first_name' => 'required',
        'last_name' => 'required',
        'phone' => 'required',
        'password' => 'required',
        'verification_code' => '',
        'email' => 'required|unique:acc_users', //TODO
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
        'id' => 'exists:acc_users',
        'email' => 'unique:acc_users',
        'location' => 'latLng',
        'notify_sms' => 'integer|between:0,1',
        'notify_email' => 'integer|between:0,1',
        'notify_push' => 'integer|between:0,1',
        'device_token' => '',
        'os' => 'in:ios,android',
        'vehicle_id' => 'vehicleId',
        'card_id' => 'cardId',
        'old_password' => 'required_with:new_password',
        'new_password' => 'password',
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
     * S# getNotifySmsTextAttribute() function
     * Get NotifySms Text
     */
    public function getNotifySmsTextAttribute() {
        //Set icon
        $icon = $this->attributes['notify_sms'] ? 'glyphicon-ok commonColor' : 'glyphicon-remove commonColorRed';

        return '<i class="glyphicon ' . $icon . '"></i>';
    }

//E# getNotifySmsTextAttribute() function

    /**
     * S# getNotifyPushTextAttribute() function
     * Get NotifyPush Text
     */
    public function getNotifyPushTextAttribute() {
        //Set icon
        $icon = $this->attributes['notify_push'] ? 'glyphicon-ok commonColor' : 'glyphicon-remove commonColorRed';

        return '<i class="glyphicon ' . $icon . '"></i>';
    }

//E# getNotifyPushTextAttribute() function

    /**
     * S# getNotifyEmailTextAttribute() function
     * Get NotifyEmail Text
     */
    public function getNotifyEmailTextAttribute() {
        //Set icon
        $icon = $this->attributes['notify_email'] ? 'glyphicon-ok commonColor' : 'glyphicon-remove commonColorRed';

        return '<i class="glyphicon ' . $icon . '"></i>';
    }

//E# getNotifyEmailTextAttribute() function

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
                        ->where('pdt_promotions.expiry_date', '>', Carbon::now());
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

    /**
     * S# transactions() function
     * Set one to many relationship to Card Model
     */
    public function transactions() {
        return $this->hasMany(\Util::buildNamespace('payments', 'transaction', 2), 'user_id');
    }

//E# transactions() function

    /**
     * S# favourites() function
     * Set one to many relationship to Feel Model
     */
    public function favourites() {
        return $this->belongsToMany(\Util::buildNamespace('merchants', 'location', 2), 'mct_feels', 'user_id', 'location_id')
                        ->whereType(1);
    }

//E# favourites() function

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