<?php

namespace Lava\Surveys;

/**
 * S# OptionModel() Class
 * @author Edwin Mugendi
 * Option Model
 */
class OptionModel extends \BaseModel {

    //Table
    protected $table = 'svy_options';
    //View fields
    public $viewFields = array(
        'id' => array(1, 'text', '='),
        'title' => array(1, 'text', 'like', 1),
        'value' => array(1, 'text', 'like', 1),
    );
    //Fillable fields
    protected $fillable = array(
        'id',
        'organization_id',
        'form_id',
        'question_id',
        'user_id',
        'title',
        'value',
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
        'title' => 'required',
        'value' => 'required',
    );
    //Update validation rules
    public $updateRules = array(
        'title' => 'required',
        'value' => 'required',
    );

}

//E# SurveyModel() Class