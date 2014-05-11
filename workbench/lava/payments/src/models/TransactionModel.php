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
    //Fillable fields
    protected $fillable = array(
        'user_id',
        'product_id',
        'promotion_id',
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

}

//E# TransactionModel() Class