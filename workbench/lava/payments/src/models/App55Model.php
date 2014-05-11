<?php

namespace Lava\Payments;

/**
 * S# App55Model() Class
 * @author Edwin Mugendi
 * App55 Model
 */
class App55Model extends \Eloquent {

    //Table
    protected $table = 'fnc_app55';
    //Fillable fields
    protected $fillable = array(
        'id',
        'sig',
        'ts',
        'user_id',
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
        'id' => 'required|unique:fnc_app55',
        'user_id' => 'required|integer',
        'sig' => 'required',
        'ts' => 'required',
        'status' => 'required|integer',
        'created_by' => 'required|integer',
        'updated_by' => 'required|integer',
    );

}

//E# App55Model() Class