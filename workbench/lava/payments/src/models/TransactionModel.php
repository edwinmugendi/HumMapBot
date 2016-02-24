<?php

namespace Lava\Payments;

/**
 * S# TransactionModel() Class
 * @author Edwin Mugendi
 * Transaction Model
 */
class TransactionModel extends \BaseModel {

    //Table
    protected $table = 'fnc_transactions';
    //View fields
    public $viewFields = array(
        'id' => array(1, 'text', '=', 0),
        'workflow' => array(1, 'select', '=', 0),
        'user_id' => array(1, 'select', '=', 0),
        'product_id' => array(1, 'select', '=', 1),
        'location_id' => array(1, 'select', '=', 1),
        'merchant_id' => array(1, 'select', '=', 0),
        'promotion_id' => array(0, 'select', '=', 0),
        'amount' => array(1, 'text', 'like', 0),
        'refund' => array(0, 'text', 'like', 0),
        'currency_id' => array(1, 'text', 'like', 0),
        'description' => array(0, 'text', 'like', 0),
        'card_used' => array(0, 'text', 'like', 0),
        'card_token' => array(1, 'text', '=', 0),
        'stamps_issued' => array(0, 'text', 'like', 0),
        'lat' => array(0, 'text', 'like', 0),
        'lng' => array(0, 'text', 'like', 0),
        'gateway' => array(1, 'select', '=', 0),
        'gateway_tran_id' => array(0, 'text', 'like', 0),
        'gateway_code' => array(0, 'text', 'like', 0),
        'user_smsed' => array(0, 'select', '=', 0),
        'user_emailed' => array(0, 'select', '=', 0),
        'user_pushed' => array(0, 'select', '=', 0),
        'merchant_smsed' => array(0, 'select', '=', 0),
        'merchant_emailed' => array(0, 'select', '=', 0),
    );
    //Fillable fields
    protected $fillable = array(
        'user_id',
        'product_id',
        'promotion_id',
        'location_id',
        'currency_id',
        'merchant_id',
        'amount',
        'currency_id',
        'description',
        'card_used',
        'card_token',
        'stamps_issued',
        'vrm',
        'vehicle_id',
        'lat',
        'lng',
        'gateway',
        'gateway_tran_id',
        'gateway_code',
        'user_smsed',
        'user_emailed',
        'user_pushed',
        'merchant_smsed',
        'merchant_emailed',
        'workflow',
        'ip',
        'agent',
        'status',
        'created_by',
        'updated_by'
    );
    //Appends fields
    protected $appends = array(
        'user_smsed_text',
        'user_emailed_text',
        'user_pushed_text',
        'merchant_smsed_text',
        'merchant_emailed_text',
        'user_id_text',
        'location_id_text',
        'merchant_id_text',
        'product_id_text',
        'promotion_id_text',
        'loc',
        'workflow_text',
        'gateway_text',
    );
    protected $hidden = array(
        'status',
        'created_by',
        'updated_by',
        'deleted_at'
    );
    //Create validation rules
    public $createRules = array(
        'status' => 'required|integer',
        'created_by' => 'required|integer',
        'updated_by' => 'required|integer',
    );
    //Select validation rules
    public $selectRules = array(
        'field' => 'required|in:id',
        'value' => 'required|integer|exists:fnc_transactions,id',
        'take' => 'integer',
        'page' => 'integer'
    );
    //Select all validation rules
    public $selectAllRules = array(
        'take' => 'integer',
        'page' => 'integer'
    );

    /**
     * S# getUserSmsedTextAttribute() function
     * Get New Customer Text
     */
    public function getUserSmsedTextAttribute() {
        //Set icon
        $icon = $this->attributes['user_smsed'] ? 'glyphicon-ok commonColor' : 'glyphicon-remove commonColorRed';

        return '<i class="glyphicon ' . $icon . '"></i>';
    }

//E# getUserSmsedTextAttribute() function

    /**
     * S# getUserEmailedTextAttribute() function
     * Get New Customer Text
     */
    public function getUserEmailedTextAttribute() {
        //Set icon
        $icon = $this->attributes['user_emailed'] ? 'glyphicon-ok commonColor' : 'glyphicon-remove commonColorRed';

        return '<i class="glyphicon ' . $icon . '"></i>';
    }

//E# getUserEmailedTextAttribute() function

    /**
     * S# getUserPushedTextAttribute() function
     * Get New Customer Text
     */
    public function getUserPushedTextAttribute() {
        //Set icon
        $icon = $this->attributes['user_pushed'] ? 'glyphicon-ok commonColor' : 'glyphicon-remove commonColorRed';

        return '<i class="glyphicon ' . $icon . '"></i>';
    }

//E# getUserPushedTextAttribute() function

    /**
     * S# getMerchantSmsedTextAttribute() function
     * Get New Customer Text
     */
    public function getMerchantSmsedTextAttribute() {
        //Set icon
        $icon = $this->attributes['merchant_smsed'] ? 'glyphicon-ok commonColor' : 'glyphicon-remove commonColorRed';

        return '<i class="glyphicon ' . $icon . '"></i>';
    }

//E# getMerchantSmsedTextAttribute() function

    /**
     * S# getMerchantEmailedTextAttribute() function
     * Get New Customer Text
     */
    public function getMerchantEmailedTextAttribute() {
        //Set icon
        $icon = $this->attributes['merchant_emailed'] ? 'glyphicon-ok commonColor' : 'glyphicon-remove commonColorRed';

        return '<i class="glyphicon ' . $icon . '"></i>';
    }

//E# getMerchantEmailedTextAttribute() function

    /**
     * S# getWorkflowTextAttribute() function
     * Get Workflow Text
     */
    public function getWorkflowTextAttribute() {
        return \Lang::has('payments::transaction.data.workflow.' . $this->attributes['workflow']) ? \Lang::get('payments::transaction.data.workflow.' . $this->attributes['workflow']) : '';
    }

//E# getWorkflowTextAttribute() function

    /**
     * S# getGatewayTextAttribute() function
     * Get Gateway Text
     */
    public function getGatewayTextAttribute() {
        return \Lang::has('payments::transaction.data.gateway.' . $this->attributes['gateway']) && $this->attributes['gateway'] ? \Lang::get('payments::transaction.data.gateway.' . $this->attributes['gateway']) : '';
    }

//E# getGatewayTextAttribute() function

    /**
     * S# promotion() function
     * Set one to one relationship to Promotion Model
     */
    public function promotion() {
        return $this->belongsTo(\Util::buildNamespace('products', 'promotion', 2), 'promotion_id');
    }

//E# promotion() function

    /**
     * S# getPromotionIdTextAttribute() function
     * 
     * Get Promotion Text
     */
    public function getPromotionIdTextAttribute() {

        //Get promotion model
        $promotion_model = $this->promotion()->first();

        //Return name
        return $promotion_model ? $promotion_model->code : '';
    }

//E# getPromotionIdTextAttribute() function

    /**
     * S# product() function
     * Set one to one relationship to Product Model
     */
    public function product() {
        return $this->belongsTo(\Util::buildNamespace('products', 'product', 2), 'product_id');
    }

//E# product() function

    /**
     * S# getProductIdTextAttribute() function
     * 
     * Get Product Text
     */
    public function getProductIdTextAttribute() {

        //Get product model
        $product_model = $this->product()->first();

        //Return name
        return $product_model ? $product_model->name : '';
    }

//E# getProductIdTextAttribute() function

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
     * S# user() function
     * Set one to one relationship to User Model
     */
    public function user() {
        return $this->belongsTo(\Util::buildNamespace('accounts', 'user', 2), 'user_id', 'id');
    }

//E# user() function

    /**
     * S# getUserIdTextAttribute() function
     * 
     * Get User Text
     */
    public function getUserIdTextAttribute() {

        //Get user model
        $user_model = $this->user()->first();

        //Return name
        return $user_model ? $user_model->first_name . ' ' . $user_model->last_name : '';
    }

//E# getUserIdTextAttribute() function

    /**
     * S# getLocAttribute() function
     * Get the loc
     */
    public function getLocAttribute() {
        $locationModel = $this->location()->first();

        $loc = array();
        if ($locationModel) {
            return $loc['loc'] = array(
                'name' => $locationModel->name,
                'address' => $locationModel->address
            );
        } else {
            return $loc['loc'] = array();
        }//E# if statement
    }

//E# getLocAttribute() function
}

//E# TransactionModel() Class