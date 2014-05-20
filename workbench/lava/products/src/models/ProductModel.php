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
     * S# location() function
     * Set one to one relationship to Location Model
     */
    public function location() {
        return $this->belongsTo(\Util::buildNamespace('merchants', 'location', 2), 'location_id');
    }

//E# location() function
}

//E# ProductModel() Class