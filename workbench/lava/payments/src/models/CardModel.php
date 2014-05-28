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
    
    //Soft delete
    protected $softDelete = true;
    
    //User owned
    public $userOwned = true;
    
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
    //Delete validation rules
    public $deleteRules = array(
        'field' => 'required|in:id',
        'value' => 'required|integer|exists:fnc_cards,id',
    );
    
    //Select validation rules
    public $selectRules = array(
        'field' => 'required|in:id',
        'value' => 'required|integer|exists:fnc_cards,id',
    );
    
    //Select validation rules
    public $selectAllRules = array();

    /**
     * S# user() function
     * Set one to one relationship to User Model
     */
    public function user() {
        return $this->belongsTo(\Util::buildNamespace('accounts', 'user', 2), 'user_id', 'id');
    }

//E# user() function
}

//E# CardModel() Class