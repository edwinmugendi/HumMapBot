<?php

namespace Lava\Merchants;

/**
 * S# FeelModel() Class
 * @author Edwin Mugendi
 * Feel Model
 */
class FeelModel extends \Eloquent {

    //Table
    protected $table = 'mct_feels';
    //Fillable fields
    protected $fillable = array(
        'user_id',
        'location_id',
        'type',
        'feeling',
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

//E# FeelModel() Class