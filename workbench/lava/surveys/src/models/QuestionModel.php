<?php

namespace Lava\Surveys;

/**
 * S# QuestionModel() Class
 * @author Edwin Mugendi
 * Question Model
 */
class QuestionModel extends \BaseModel {

    //Table
    protected $table = 'svy_questions';
    //View fields
    public $viewFields = array(
        'id' => array(1, 'text', '='),
        'title' => array(1, 'text', 'like', 1),
        'name' => array(1, 'text', 'like', 1),
        'regex' => array(1, 'text', '='),
        'type' => array(1, 'select', '='),
        'error_message' => array(1, 'text', 'like'),
    );
    //Fillable fields
    protected $fillable = array(
        'id',
        'organization_id',
        'form_id',
        'user_id',
        'title',
        'name',
        'regex',
        'type',
        'error_message',
        'agent',
        'ip',
        'status',
        'created_by',
        'updated_by'
    );
    //Appends fields
    protected $appends = array(
        'type_text',
    );
    //Hidden fields
    protected $hidden = array();
    //Create validation rules
    public $createRules = array(
        'title' => 'required',
        'name' => 'required',
        'type' => 'required',
        'regex' => '',
        'error_message' => '',
    );
    //Create validation rules
    public $updateRules = array(
        'title' => 'required',
        'name' => 'required',
        'type' => 'required',
        'regex' => '',
        'error_message' => '',
    );

    /**
     * S# getTypeTextAttribute() function
     * Get Type Text
     */
    public function getTypeTextAttribute() {
        return $this->attributes['type'] ? \Lang::get('surveys::question.data.type.' . $this->attributes['type']) : '';
    }

//E# getTypeTextAttribute() function

    /**
     * S# options() function
     * Set one to many relationship to Question Model
     */
    public function options() {
        return $this->hasMany(\Util::buildNamespace('surveys', 'option', 2), 'question_id');
    }

//E# options() function
}

//E# SurveyModel() Class