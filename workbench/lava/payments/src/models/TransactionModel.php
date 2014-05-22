<?php

namespace Lava\Payments;

/**
 * S# TransactionModel() Class
 * @author Edwin Mugendi
 * Transaction Model
 */
class TransactionModel extends \Eloquent {

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
        'amount',
        'currency',
        'description',
        'refund',
        'card_used',
        'lat',
        'lng',
        'gateway',
        'gateway_tran_id',
        'gateway_code',
        'agent',
        'status',
        'created_by',
        'updated_by'
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
        'take'=>'integer',
        'page'=>'integer'
    );
    
    //Select all validation rules
    public $selectAllRules = array(
        'take'=>'integer',
        'page'=>'integer'
    );

}

//E# TransactionModel() Class