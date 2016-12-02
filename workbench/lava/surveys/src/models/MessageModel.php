<?php

namespace Lava\Surveys;

/**
 * S# MessageModel() Class
 * @author Edwin Mugendi
 * Message Model
 */
class MessageModel extends \BaseModel {

    //Table
    protected $table = 'svy_messages';
    //View fields
    public $viewFields = array(
        'id' => array(1, 'text', '='),
        'type' => array(1, 'select', '=', 1),
        'session_id' => array(1, 'select', '=', 1),
        'text' => array(1, 'text', 'like'),
        'created_at' => array(1, 'text', '='),
        'updated_at' => array(1, 'text', '='),
    );
    //Fillable fields
    protected $fillable = array(
        'id',
        'organization_id',
        'session_id',
        'type',
        'text',
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
        'session_id' => 'required',
        'message' => 'required',
    );
    //Create validation rules
    public $updateRules = array(
        'session_id' => 'required',
        'message' => 'required',
    );

    /**
     * S# session() function
     * Set one to one relationship to Session Model
     */
    public function session() {
        return $this->belongsTo(\Util::buildNamespace('surveys', 'session', 2), 'session_id');
    }

//E# session() function

    /**
     * S# getSessionIdTextAttribute() function
     * Get Session Text
     */
    public function getSessionIdTextAttribute() {
        //Get session model
        $session_model = $this->session()->first();
        //Return name
        return $session_model ? $session_model->full_name : '';
    }

//E# getSessionIdTextAttribute() function
    
     /**
     * S# getTypeTextAttribute() function
     * Get Type Text
     */
    public function getTypeTextAttribute() {
        return $this->attributes['type'] ? \Lang::get('surveys::message.data.type.' . $this->attributes['type']) : '';
    }

//E# getTypeTextAttribute() function
}

//E# SurveyModel() Class