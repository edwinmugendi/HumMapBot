<?php

namespace Lava\Payments;

/**
 * S# CardModel() Class
 * @author Edwin Mugendi
 * Card Model
 */
class CardModel extends \BaseModel {

    //Table
    protected $table = 'fnc_cards';
    //View fields
    public $viewFields = array(
        'id' => array(1, 'text', '='),
    );
    //Appends fields
    protected $appends = array(
        'is_default',
        'stripe_id'
    );
    //Fillable fields
    protected $fillable = array(
        'user_id',
        'gateway',
        'exp_month',
        'exp_year',
        'last4',
        'brand',
        'address_city',
        'address_zip',
        'address_country',
        'address_line1',
        'token',
        'status',
        'created_by',
        'updated_by'
    );
    protected $hidden = array(
        'created_by',
        'updated_by',
    );
    //Create validation rules
    public $createRules = array(
    );
    //Update validation rules
    public $updateRules = array(
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

    /**
     * S# user() function
     * Set one to one relationship to User Model
     */
    public function user() {
        return $this->belongsTo(\Util::buildNamespace('accounts', 'user', 2), 'user_id');
    }

//E# user() function

    /**
     * S# getIsDefaultAttribute() function
     * Is this card the default
     */
    public function getIsDefaultAttribute() {

        if (count($this->user)) {
            //Get the logged in user card
            $token = $this->user()->first()->card;

            return ($this->attributes['token'] == $token) ? 1 : 0;
        } else {
            return 0;
        }
    }

//E# getIsDefaultAttribute() function

    /**
     * S# getStripeIdAttribute() function
     * Get User Stripe Id
     */
    public function getStripeIdAttribute() {
        //Return stripe id
        return count($this->user) ? $this->user()->first()->stripe_id : '';
    }

//E# getStripeIdAttribute() function
}

//E# CardModel() Class