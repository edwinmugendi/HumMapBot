<?php

namespace Lava\Payments;

use Illuminate\Database\Eloquent\SoftDeletingTrait;

/**
 * S# CardModel() Class
 * @author Edwin Mugendi
 * Card Model
 */
class CardModel extends \Eloquent {
    
    use SoftDeletingTrait;
    //Table
    protected $table = 'fnc_cards';
    //Soft delete
    protected $dates = ['deleted_at'];
    //Appends fields
    protected $appends = array(
        'is_default',
        'app55_id'
    );
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

    /**
     * S# getIsDefaultAttribute() function
     * Is this card the default
     */
    public function getIsDefaultAttribute() {
        //Get the logged in user card
        $token = $this->user()->first()->card;
        
        return ($this->attributes['token'] == $token) ? 1 : 0;
    }

//E# getIsDefaultAttribute() function

    /**
     * S# getApp55IdAttribute() function
     * Get User App55 Id
     */
    public function getApp55IdAttribute() {
        //Return app55 id
        return $this->user()->first()->app55_id;
    }

//E# getApp55IdAttribute() function
}

//E# CardModel() Class