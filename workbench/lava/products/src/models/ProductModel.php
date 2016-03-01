<?php

namespace Lava\Products;

use Lava\Accounts\UserController;
use Lava\Accounts\VehicleController;

/**
 * S# ProductModel() Class
 * @author Edwin Mugendi
 * Product Model
 */
class ProductModel extends \BaseModel {

    //Table
    protected $table = 'pdt_products';
    //View fields
    public $viewFields = array(
        'id' => array(1, 'text', '=', 0),
        'merchant_id' => array(1, 'select', '=', 0),
        'name' => array(1, 'text', 'like', 1),
        'description' => array(0, 'text', 'like', 0),
        'location_id' => array(1, 'select', '=', 0),
        'price_1' => array(1, 'text', '=', 0),
        'price_2' => array(1, 'text', '=', 0),
        'loyable' => array(1, 'select', '=', 0),
    );
    //Fillable fields
    protected $fillable = array(
        'id',
        'name',
        'merchant_id',
        'location_id',
        'description',
        'price_1',
        'price_2',
        'loyable',
        'agent',
        'ip',
        'status',
        'created_by',
        'updated_by',
    );
    //Appends fields
    protected $appends = array(
        'merchant_id_text',
        'location_id_text',
        'loyable_text',
        'currency_id',
        'price',
        'price_1',
        'price_2'
    );
    protected $hidden = array();
    //Create validation rules
    public $createRules = array(
        'name' => 'required',
    );
    //Update validation rules
    public $updateRules = array(
        'name' => 'required',
    );

    /**
     * S# getLoyableTextAttribute() function
     * Get Loyable Text
     */
    public function getLoyableTextAttribute() {
        //Set icon
        $icon = $this->attributes['loyable'] ? 'glyphicon-ok commonColor' : 'glyphicon-remove commonColorRed';

        return '<i class="glyphicon ' . $icon . '"></i>';
    }

//E# getLoyableTextAttribute() function

    /**
     * S# location() function
     * Set one to one relationship to Location Model
     */
    public function location() {
        return $this->belongsTo(\Util::buildNamespace('merchants', 'location', 2), 'location_id');
    }

//E# location() function

    /**
     * S# getLocationIdTextAttribute() function
     * 
     * Get Location Text
     */
    public function getLocationIdTextAttribute() {

        //Get location model
        $location_model = $this->location()->first();

        //Return name
        return $location_model ? $location_model->name : '';
    }

//E# getLocationIdTextAttribute() function

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

    /**
     * S# getCurrencyIdAttribute() function
     * Get product currency
     * 
     * @return string Currency
     */
    public function getCurrencyIdAttribute() {
        return $this->location()->first()->currency->code;
    }

//E# getCurrencyIdAttribute() function

    /**
     * S# getPriceAttribute() function
     * Get Price
     * 
     * @return mixed Effective price
     */
    public function getPriceAttribute() {

        //Create vehicle controller
        $vehicle_controller = new VehicleController();
        if (\Auth::check() && \Request::has('token') && $vehicle_id = \Auth::user()->vehicle_id) {
            //Get vehicle by id
            $vehicle_model = $vehicle_controller->getModelByField('id', $vehicle_id);

            if ($vehicle_model) {//Model exists
                return $vehicle_model->type == 2 ? $this->getPrice2Attribute() : $this->getPrice1Attribute();
            }//E# if else statement
        }//E# if statement
        //User not logged in or has not set the default card

        return $this->getPrice1Attribute();
    }

//E# getPriceAttribute() function

    /**
     * S# getPrice1Attribute() function
     * Get Price 1
     * 
     * @return mixed Effective price
     */
    public function getPrice1Attribute() {
        //Create user controller
        $user_controller = new UserController();

        if ($this->attributes['loyable']) {//This product is loyable
            if (\Auth::check()) {//User exists
                //Cache location stamps
                $location_stamps = $this->location()->first()->loyalty_stamps;
                if ($location_stamps) {
                    //Get loyalty stamps
                    $stamp_model = $user_controller->callController(\Util::buildNamespace('payments', 'payment', 1), 'getLocationStamps', array($this->location()->first()->id, \Auth::user()->id));

                    if ($stamp_model) {//Stamp found
                        if ((int) $stamp_model->feeling >= $location_stamps) {//User qualifies for a free wash
                            return $this->freePrice = \Lang::get('products::product.notification.free_price');
                        }//E# if statement
                    }//E# if statement
                }//E# if statement
            }//E# if statement
        }//E# if statement
        //Return actual prices
        return $this->attributes['price_1'];
    }

//E# getPrice1Attribute() function

    /**
     * S# getPrice2Attribute() function
     * Get Price 2
     * 
     * @depends getPrice1Attribute freePrice is set this method
     * @return mixed Effective price
     */
    public function getPrice2Attribute() {
        //Create user controller
        $user_controller = new UserController();

        if ($this->attributes['loyable']) {//This product is loyable
            if (\Auth::check()) {//User exists
                //Cache location stamps
                $location_stamps = $this->location()->first()->loyalty_stamps;
                if ($location_stamps) {
                    //Get loyalty stamps
                    $stamp_model = $user_controller->callController(\Util::buildNamespace('payments', 'payment', 1), 'getLocationStamps', array($this->location()->first()->id, \Auth::user()->id));

                    if ($stamp_model) {//Stamp found
                        if ((int) $stamp_model->feeling >= $location_stamps) {//User qualifies for a free wash
                            return $this->freePrice = \Lang::get('products::product.notification.free_price');
                        }//E# if statement
                    }//E# if statement
                }//E# if statement
            }//E# if statement
        }//E# if statement
        //Return actual prices
        return $this->attributes['price_2'];
    }

//E# getPrice2Attribute() function
}

//E# ProductModel() Class