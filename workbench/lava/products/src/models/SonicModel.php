<?php

namespace Lava\Products;

use Carbon\Carbon;

/**
 * S# SonicModel() Class
 * @author Edwin Mugendi
 * Sonic Model
 */
class SonicModel extends \Eloquent {

    //Table
    protected $table = 'pdt_sonic';
    //Fillable fields
    protected $fillable = array(
        'user_id',
        'event_id',
        'signature',
        'timestamp',
        'points',
        'commission_origin',
        'application_id',
        'item_name',
        'status',
        'created_by',
        'updated_by'
    );
    //Appends fields
    protected $appends = array(
    );
    protected $hidden = array(
        'status',
        'created_by',
        'updated_by',
        'deleted_at'
    );
    //Create validation rules
    public $createRules = array(
    );
    //Select validation rules
    public $selectRules = array(
    );

}

//E# SonicModel() Class