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
        'channel_chat_id' => array(1, 'text', '='),
        'created_at' => array(1, 'text', '='),
        'updated_at' => array(1, 'text', '='),
    );
    //Fillable fields
    protected $fillable = array(
        'id',
        'organization_id',
        'channel_chat_id',
        'full_name',
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
        'channel_chat_id' => 'required',
    );
    //Create validation rules
    public $updateRules = array(
        'full_name' => 'required',
        'channel_chat_id' => 'required',
    );

   
}

//E# SurveyModel() Class