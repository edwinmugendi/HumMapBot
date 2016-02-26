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
        'id' => array(1, 'text', '=', 0),
        'last4' => array(1, 'text', '=', 1),
        'brand' => array(1, 'text', '=', 1),
        'user_id' => array(1, 'select', '=', 1),
        'gateway' => array(1, 'text', 'like', 0),
        'deleted_on_stripe' => array(0, 'select', '=', 0),
        'exp_month' => array(1, 'text', '=', 0),
        'exp_year' => array(1, 'text', '=', 0),
        'address_city' => array(0, 'text', 'like', 0),
        'token' => array(1, 'text', 'like', 0),
        'address_zip' => array(0, 'text', 'like', 0),
        'address_country' => array(0, 'text', 'like', 0),
        'address_line1' => array(0, 'text', 'like', 0),
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
        'ip',
        'agent',
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
        'stripe_token' => 'required',
    );
    //Update validation rules
    public $updateRules = array();
    
        /**
     * S# getDeletedOnStripeTextAttribute() function
     * Get DeletedOnStripe Text
     */
    public function getDeletedOnStripeTextAttribute() {
        //Set icon
        $icon = $this->attributes['deleted_on_stripe'] ? 'glyphicon-ok commonColor' : 'glyphicon-remove commonColorRed';

        return '<i class="glyphicon ' . $icon . '"></i>';
    }

//E# getDeletedOnStripeTextAttribute() function
    
    /**
     * S# user() function
     * Set one to one relationship to User Model
     */
    public function user() {
        return $this->belongsTo(\Util::buildNamespace('accounts', 'user', 2), 'user_id');
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