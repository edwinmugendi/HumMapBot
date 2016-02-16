<?php

namespace Lava\Merchants;

/**
 * S# SearchModel() Class
 * @author Edwin Mugendi
 * Search Model
 */
class SearchModel extends \BaseModel {

    //Table
    protected $table = 'mct_searches';
    //View fields
    public $viewFields = array(
        'id' => array(1, 'text', '='),
    );
    //Fillable fields
    protected $fillable = array(
        'user_id',
        'lat',
        'lng',
        'locations_found',
        'datetime',
        'radius',
        'agent',
        'ip',
        'status',
        'created_by',
        'updated_by'
    );
    
    //Appends fields
    protected $appends = array(
       
    );
    //Hidden fields
    protected $hidden = array(
    );
    //Create validation rules
    public $createRules = array(
    );
    //Update validation rules
    public $updateRules = array(
    );

}

//E# SearchModel() Class