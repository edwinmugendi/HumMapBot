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
    //Fillable fields
    protected $fillable = array(
        'status',
        'created_by',
        'updated_by'
    );
    //Appends fields
    protected $appends = array(
        'currency',
        'price',
        'price_1',
        'price_2'
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
  
    /**
     * S# __construct() function
     * Constuctor
     */
    public function __construct() {
        parent::__construct();
    }

//E# __construct() function

    /**
     * S# location() function
     * Set one to one relationship to Location Model
     */
    public function location() {
        return $this->belongsTo(\Util::buildNamespace('merchants', 'location', 2), 'location_id');
    }

//E# location() function
    
        /**
     * S# merchant() function
     * Set one to one relationship to Location Model
     */
    public function merchant() {
        return $this->belongsTo(\Util::buildNamespace('merchants', 'merchant', 2), 'merchant_id');
    }

//E# merchant() function

    /**
     * S# getCurrencyAttribute() function
     * Get product currency
     * 
     * @return string Currency
     */
    public function getCurrencyAttribute() {
        return $this->location()->first()->currency;
    }

//E# getCurrencyAttribute() function

    /**
     * S# getPriceAttribute() function
     * Get Price
     * 
     * @return mixed Effective price
     */
    public function getPriceAttribute() {

        //Create vehicle controller
        $vehicleController = new VehicleController();

        if ($this->loggedInUser && $this->loggedInUser->vrm) {//User exists
            //Get vehicle by vrm
            $vehicleModel = $vehicleController->getModelByField('vrm', $this->loggedInUser->vrm);

            if ($vehicleModel) {//Model exists
                return $vehicleModel->type == 2 ? $this->getPrice2Attribute() : $this->getPrice1Attribute();
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
        $userController = new UserController();

        if ($this->attributes['loyable']) {//This product is loyable
            if ($this->loggedInUser) {//User exists
                //Cache location stamps
                $locationStamps = $this->location()->first()->loyalty_stamps;
                if ($locationStamps) {
                    //Get loyalty stamps
                    $stampModel = $userController->callController(\Util::buildNamespace('payments', 'payment', 1), 'getLocationStamps', array($this->location()->first()->id, $this->loggedInUser->id));

                    if ($stampModel) {//Stamp found
                        if ((int) $stampModel->feeling >= $locationStamps) {//User qualifies for a free wash
                            return $this->freePrice = \Lang::get('products::product.api.freePrice');
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
        $userController = new UserController();

        if ($this->attributes['loyable']) {//This product is loyable
            if ($this->loggedInUser) {//User exists
                //Cache location stamps
                $locationStamps = $this->location()->first()->loyalty_stamps;
                if ($locationStamps) {
                    //Get loyalty stamps
                    $stampModel = $userController->callController(\Util::buildNamespace('payments', 'payment', 1), 'getLocationStamps', array($this->location()->first()->id, $this->loggedInUser->id));

                    if ($stampModel) {//Stamp found
                        if ((int) $stampModel->feeling >= $locationStamps) {//User qualifies for a free wash
                            return $this->freePrice = \Lang::get('products::product.api.freePrice');
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