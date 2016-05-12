<?php

namespace Lava\Accounts;

use Carbon\Carbon;

/**
 * S# MpesaModel() Class
 * @author Edwin Mugendi
 * Mpesa Model
 */
class MpesaModel extends \BaseModel {

    //Table
    protected $table = 'acc_mpesa';
    //View fields
    public $viewFields = array(
        'id' => array(1, 'text', '='),
        'user_id' => array(1, 'select', '=', 1),
        'type' => array(1, 'select', '=', 1),
        'class' => array(1, 'select', '=', 1),
        'tran_date' => array(1, 'text', '=', 0),
        'tran_id' => array(1, 'text', '=', 0),
        'account' => array(1, 'text', 'like', 0),
        'account_number' => array(1, 'text', '=', 0),
        'currency' => array(1, 'select', '=', 0),
        'amount' => array(1, 'text', '=', 1),
        'balance' => array(1, 'text', '=', 1),
        'tran_datetime' => array(0, 'text', '=', 0),
    );
    //Fillable fields
    protected $fillable = array(
        'merchant_id',
        'user_id',
        'tran_id',
        'currency',
        'amount',
        'balance',
        'account',
        'account_number',
        'tran_date',
        'tran_datetime',
        'type',
        'class',
        'agent',
        'ip',
        'status',
        'created_by',
        'updated_by',
    );
    protected $hidden = array();
    //Create validation rules
    public $createRules = array();
    //Create update rules
    public $updateRules = array();
    
     /**
     * S# getTypeTextAttribute() function
     * 
     * Get Type Text
     */
    public function getTypeTextAttribute() {
        return $this->attributes['type'] ? \Lang::get('accounts::mpesa.data.type.' . $this->attributes['type']) : '';
    }

//E# getTypeTextAttribute() function
    
     /**
     * S# getClassTextAttribute() function
     * 
     * Get Class Text
     */
    public function getClassTextAttribute() {
        return $this->attributes['class'] ? \Lang::get('accounts::mpesa.data.class.' . $this->attributes['class']) : '';
    }

//E# getClassTextAttribute() function
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
}

//E# MpesaModel() Class