<?php

namespace Lava\Payments;

/**
 * S# CardModel() Class
 * @author Edwin Mugendi
 * Card Model
 */
class CardModel extends \Eloquent {

    //Table
    protected $table = 'fnc_cards';
    //Fillable fields
    protected $fillable = array(
        'address_city',
        'address_country',
        'address_postal_code',
        'address_street',
        'expiry',
        'gateway_id',
        'number',
        'token',
        'user_id',
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

//E# CardModel() Class