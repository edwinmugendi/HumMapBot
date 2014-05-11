<?php

namespace Lava\Products;

/**
 * S# ProductModel() Class
 * @author Edwin Mugendi
 * Product Model
 */
class ProductModel extends \Eloquent {

    //Table
    protected $table = 'pdt_products';
    //Fillable fields
    protected $fillable = array(
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

    /**
     * S# merchant() function
     * Set one to one relationship to Merchant Model
     */
    public function merchant() {
        return $this->belongsTo(\Util::buildNamespace('merchants', 'merchant', 2), 'location_id');
    }

//E# merchant() function
}

//E# ProductModel() Class