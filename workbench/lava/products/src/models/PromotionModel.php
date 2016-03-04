<?php

namespace Lava\Products;

use Carbon\Carbon;

/**
 * S# PromotionModel() Class
 * @author Edwin Mugendi
 * Promotion Model
 */
class PromotionModel extends \BaseModel {

    //Table
    protected $table = 'pdt_promotions';
    
    //View fields
    public $viewFields = array(
        'id' => array(1, 'text', '=', 0),
        'code' => array(1, 'text', '=', 1),
        'merchant_id' => array(1, 'select', '=', 0),
        'location_id' => array(1, 'select', '=', 0),
        'description' => array(0, 'text', 'like', 0),
        'type' => array(1, 'select', '=', 0),
        'value' => array(1, 'text', '=', 0),
        'new_customer' => array(1, 'select', '=', 0),
        'expiry_date' => array(1, 'text', 'like', 0),
    );
    //Fillable fields
    protected $fillable = array(
        'id',
        'code',
        'merchant_id',
        'location_id',
        'description',
        'new_customer',
        'expiry_date',
        'type',
        'value',
        'agent',
        'ip',
        'status',
        'created_by',
        'updated_by',
    );
    //Appends fields
    protected $appends = array(
        'claimed',
        'user_owns'
    );
    protected $hidden = array(
        'claimed'
    );
    //Create validation rules
    public $createRules = array(
        'code' => 'required|unique:pdt_promotions,code,NULL,id,status,1',
        'description' => 'required',
        'type' => 'required|integer|between:1,2',
        'value' => 'required|numeric',
        'new_customer' => 'between:0,1',
        'expiry_date' => 'required|check_date',
    );
    //Update validation rules
    public $updateRules = array(
        'code' => 'required|unique:pdt_promotions,code,NULL,id,status,1',
        'description' => 'required',
        'type' => 'required|integer|between:1,2',
        'value' => 'required|numeric',
        'new_customer' => 'between:0,1',
        'expiry_date' => 'required|check_date',
    );
    //Date fields
    public $dateFields = array('expiry_date');

    /**
     * S# getTypeTextAttribute() function
     * Get Type Text
     */
    public function getTypeTextAttribute() {
        return \Lang::has('products::promotion.data.type.' . $this->attributes['type']) ? \Lang::get('products::promotion.data.type.' . $this->attributes['type']) : '';
    }

//E# getTypeTextAttribute() function

    /**
     * S# getNewCustomerTextAttribute() function
     * Get New Customer Text
     */
    public function getNewCustomerTextAttribute() {
        //Set icon
        $icon = $this->attributes['new_customer'] ? 'glyphicon-ok commonColor' : 'glyphicon-remove commonColorRed';

        return '<i class="glyphicon ' . $icon . '"></i>';
    }

//E# getNewCustomerTextAttribute() function

    /**
     * S# location() function
     * Set one to one relationship to Location Model
     */
    public function location() {
        return $this->belongsTo(\Util::buildNamespace('merchants', 'location', 2), 'location_id');
    }

//E# location() function

    /**
     * S# getLocationIdTextAttribute() function
     * 
     * Get Location Text
     */
    public function getLocationIdTextAttribute() {

        //Get location model
        $location_model = $this->location()->first();

        //Return name
        return $location_model ? $location_model->name : '';
    }

//E# getLocationIdTextAttribute() function

    /**
     * S# merchant() function
     * Set one to one relationship to Location Model
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
     * S# getClaimedAttribute() function
     * Has the customer claimed this promotion
     */
    public function getClaimedAttribute() {
        return $this->users()
                        ->withPivot('redeemed')
                        ->whereUserId(\Auth::user()->id)
                        ->first();
    }

//E# getClaimedAttribute() function

    /**
     * S# users() function
     * Set many to many relationship to User Model
     */
    public function users() {
        return $this->belongsToMany(\Util::buildNamespace('accounts', 'user', 2), 'pdt_users_promotions', 'promotion_id', 'user_id');
    }

//E# users() function

    /**
     * S# getUserOwnsAttribute() function
     * Does the logged in user own this promotion
     */
    public function getUserOwnsAttribute() {
        return $this->users()
                        ->whereRedeemed(0)
                        ->count();
    }

//E# getUserOwnsAttribute() function
}

//E# PromotionModel() Class