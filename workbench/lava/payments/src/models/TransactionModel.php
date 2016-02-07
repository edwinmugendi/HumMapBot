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
    //User owned
    public $userOwned = true;
    //Fillable fields
    protected $fillable = array(
        'user_id',
        'product_id',
        'promotion_id',
        'location_id',
        'currency_id',
        'amount',
        'currency',
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
        'agent',
        'status',
        'created_by',
        'updated_by'
    );
    //Appends fields
    protected $appends = array(
        'loc'
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
     * S# user() function
     * Set one to one relationship to User Model
     */
    public function user() {
        return $this->belongsTo(\Util::buildNamespace('accounts', 'user', 2), 'user_id', 'id');
    }

//E# user() function

    /**
     * S# location() function
     * Set one to one relationship to Location Model
     */
    public function location() {
        return $this->belongsTo(\Util::buildNamespace('merchants', 'location', 2), 'location_id', 'id');
    }

//E# location() function

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