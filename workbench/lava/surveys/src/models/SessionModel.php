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
        'answer' => array(1, 'text', '='),
        'form_id' => array(1, 'select', '=', 1),
        'question_id' => array(1, 'select', '=', 1),
        'channel' => array(1, 'text', '=', 1),
        'channel_chat_id' => array(1, 'text', '='),
        'full_name' => array(1, 'text', '='),
    );
    //Fillable fields
    protected $fillable = array(
        'id',
        'organization_id',
        'answer',
        'form_id',
        'question_id',
        'channel',
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
        'phone' => 'required',
        'current_question' => 'required',
    );
    //Create validation rules
    public $updateRules = array(
        'full_name' => 'required',
        'phone' => 'required',
        'current_question' => 'required',
    );

    /**
     * S# form() function
     * Set one to one relationship to Form Model
     */
    public function form() {
        return $this->belongsTo(\Util::buildNamespace('surveys', 'form', 2), 'form_id');
    }

//E# form() function

    /**
     * S# getFormIdTextAttribute() function
     * Get Form Text
     */
    public function getFormIdTextAttribute() {
        //Get form model
        $form_model = $this->form()->first();
        //Return name
        return $form_model ? $form_model->name : '';
    }

//E# getFormIdTextAttribute() function

    /**
     * S# question() function
     * 
     * Set one to one relationship to Question Model
     * 
     */
    public function question() {
        return $this->belongsTo(\Util::buildNamespace('surveys', 'question', 2), 'question_id');
    }

//E# question() function

    /**
     * S# getQuestionIdTextAttribute() function
     * 
     * Get Question Text
     * 
     */
    public function getQuestionIdTextAttribute() {
        //Get question model
        $question_model = $this->question()->first();
        //Return name
        return $question_model ? $question_model->name : '';
    }

//E# getQuestionIdTextAttribute() function
}

//E# SurveyModel() Class