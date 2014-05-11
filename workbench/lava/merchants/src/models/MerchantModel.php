<?php

namespace Lava\Merchants;

/**
 * S# MerchantModel() Class
 * @author Edwin Mugendi
 * Merchant Model
 */
class MerchantModel extends \Eloquent {

    //Table
    protected $table = 'mct_merchants';
    //Fillable fields
    protected $fillable = array(
        'total_reviews',
        'status',
        'created_by',
        'updated_by'
    );
    //Appends fields
    protected $appends = array('total_reviews', 'star_rating', 'image_url', 'is_favourite', 'is_rated');
    //Hidden fields
    protected $hidden = array(
        'type_id',
        'plan_id',
        'registration_number',
        'tax_id',
        'vat',
        'vision',
        'mission',
        'slogan',
        'about',
        'email',
        'country_id',
        'town_id',
        'landline',
        'mobile',
        'website',
        'facebook',
        'twitter',
        'views',
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
     * S# locations() function
     * Set one to many relationship to Location Model
     */
    public function locations() {
        return $this->hasMany(\Util::buildNamespace('merchants', 'location', 2), 'location_id');
    }

//E# locations() function
}

//E# MerchantModel() Class