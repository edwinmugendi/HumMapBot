<?php

namespace Lava\Payments;

/**
 * S# TransactionModel() Class
 * @author Edwin Mugendi
 * Transaction Model
 */
class TransactionModel extends \BaseModel {

    //Table
    protected $table = 'pyt_transactions';
    //View fields
    public $viewFields = array(
        'id' => array(1, 'text', '=', 0),
        'user_id' => array(1, 'select', '=', 0),
        'loan_id' => array(1, 'select', '=', 1),
        'phone' => array(1, 'text', '=', 1),
        'type' => array(1, 'select', '=', 1),
        'transaction_date' => array(1, 'text', '=', 0),
        'amount' => array(1, 'text', 'like', 0),
        'currency' => array(1, 'text', 'like', 0),
        'description' => array(0, 'text', 'like', 0),
        'gateway' => array(1, 'select', '=', 0),
        'gateway_tran_id' => array(0, 'text', 'like', 0),
        'gateway_code' => array(0, 'text', 'like', 0),
        'user_smsed' => array(0, 'select', '=', 0),
        'user_emailed' => array(0, 'select', '=', 0),
        'user_pushed' => array(0, 'select', '=', 0),
        'officer_smsed' => array(0, 'select', '=', 0),
        'officer_emailed' => array(0, 'select', '=', 0),
        'merchant_id' => array(0, 'select', '=', 0),
    );
    //Fillable fields
    protected $fillable = array(
        'transaction_date',
        'user_id',
        'loan_id',
        'phone',
        'type',
        'currency',
        'merchant_id',
        'amount',
        'description',
        'gateway',
        'gateway_tran_id',
        'gateway_code',
        'user_smsed',
        'user_emailed',
        'user_pushed',
        'officer_smsed',
        'officer_emailed',
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
        'officer_smsed_text',
        'officer_emailed_text',
        'user_id_text',
        'merchant_id_text',
        'loan_id_text',
        'gateway_text',
    );
    protected $hidden = array(
        'user_smsed_text',
        'user_emailed_text',
        'user_pushed_text',
        'officer_smsed_text',
        'officer_emailed_text',
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
    //Date fields
    public $dateFields = array('transaction_date');

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
     * S# getOfficerSmsedTextAttribute() function
     * Get New Customer Text
     */
    public function getOfficerSmsedTextAttribute() {
        //Set icon
        $icon = $this->attributes['officer_smsed'] ? 'glyphicon-ok commonColor' : 'glyphicon-remove commonColorRed';

        return '<i class="glyphicon ' . $icon . '"></i>';
    }

//E# getOfficerSmsedTextAttribute() function

    /**
     * S# getOfficerEmailedTextAttribute() function
     * Get New Customer Text
     */
    public function getOfficerEmailedTextAttribute() {
        //Set icon
        $icon = $this->attributes['officer_emailed'] ? 'glyphicon-ok commonColor' : 'glyphicon-remove commonColorRed';

        return '<i class="glyphicon ' . $icon . '"></i>';
    }

//E# getOfficerEmailedTextAttribute() function

    /**
     * S# getGatewayTextAttribute() function
     * Get Gateway Text
     */
    public function getGatewayTextAttribute() {
        return \Lang::has('payments::transaction.data.gateway.' . $this->attributes['gateway']) && $this->attributes['gateway'] ? \Lang::get('payments::transaction.data.gateway.' . $this->attributes['gateway']) : '';
    }

//E# getGatewayTextAttribute() function

    /**
     * S# loan() function
     * Set one to one relationship to Loan Model
     */
    public function loan() {
        return $this->belongsTo(\Util::buildNamespace('loans', 'loan', 2), 'loan_id');
    }

//E# loan() function

    /**
     * S# getLoanIdTextAttribute() function
     * 
     * Get Loan Text
     */
    public function getLoanIdTextAttribute() {

        //Get loan model
        $loan_model = $this->loan()->first();

        //Return name
        return $loan_model ? $loan_model->name : '';
    }

//E# getLoanIdTextAttribute() function

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
}

//E# TransactionModel() Class