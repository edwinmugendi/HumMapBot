<?php

namespace Lava\Surveys;

/**
 * S# SessionModel() Class
 * @author Edwin Mugendi
 * Session Model
 */
class SessionModel extends \BaseModel {

    //Table
    protected $table = 'svy_sessions';
    //View fields
    public $viewFields = array(
        'id' => array(1, 'text', '='),
        'full_name' => array(1, 'text', 'like', 1),
        'phone' => array(1, 'text', 'like', 1),
        'current_question' => array(1, 'text', '='),
    );
    //Fillable fields
    protected $fillable = array(
        'id',
        'organization_id',
        'form_id',
        'user_id',
        'full_name',
        'phone',
        'current_question',
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
    protected $hidden = array();
    //Create validation rules
    public $createRules = array(
        'full_name' => 'required',
        'phone' => 'required',
        'current_question' => 'required',
    );
    //Create validation rules
    public $updateRules = array(
        'full_name' => 'required',
        'phone' => 'required',
        'current_question' => 'required',
    );

}

//E# SurveyModel() Class