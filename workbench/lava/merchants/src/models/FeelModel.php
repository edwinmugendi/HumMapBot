<?php

namespace Lava\Merchants;

/**
 * S# FeelModel() Class
 * @author Edwin Mugendi
 * Feel Model
 */
class FeelModel extends \BaseModel {

    //Table
    protected $table = 'mct_feels';
    //Fillable fields
    protected $fillable = array(
        'user_id',
        'location_id',
        'type',
        'feeling',
        'ip',
        'agent',
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
        'location_id' => 'required|exists:mct_locations,id',
        'type' => 'required|integer|between:1,3',
        'rate' => 'required_if:type,2|integer|between_if:type,2,1,5',
        'review' => 'required_if:type,3'
    );

}

//E# FeelModel() Class