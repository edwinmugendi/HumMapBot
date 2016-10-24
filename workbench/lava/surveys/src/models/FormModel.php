<?php

namespace Lava\Surveys;

/**
 * S# FormModel() Class
 * @author Edwin Mugendi
 * Form Model
 */
class FormModel extends \BaseModel {

    //Table
    protected $table = 'svy_forms';
    //View fields
    public $viewFields = array(
        'id' => array(1, 'text', '='),
        'name' => array(1, 'text', 'like', 1),
        'workflow' => array(1, 'select', '='),
        'responses' => array(1, 'text', '='),
    );
    //Fillable fields
    protected $fillable = array(
        'id',
        'organization_id',
        'user_id',
        'name',
        'workflow',
        'agent',
        'ip',
        'status',
        'created_by',
        'updated_by'
    );
    //Appends fields
    protected $appends = array(
        'workflow_text',
    );
    //Hidden fields
    protected $hidden = array();
    //Create validation rules
    public $createRules = array(
        'name' => 'required|unique:svy_forms,name',
        'workflow' => '',
    );
    //Create validation rules
    public $updateRules = array(
        /*'name' => 'required',*/
        'workflow' => '',
    );

    /**
     * S# questions() function
     * Set one to many relationship to Question Model
     */
    public function questions() {
        return $this->hasMany(\Util::buildNamespace('surveys', 'question', 2), 'form_id');
    }

//E# questions() function
    /**
     * S# getWorkflowTextAttribute() function
     * Get Workflow Text
     */
    public function getWorkflowTextAttribute() {
        return $this->attributes['workflow'] ? \Lang::get('surveys::form.data.workflow.' . $this->attributes['workflow']) : '';
    }

//E# getWorkflowTextAttribute() function
}

//E# SurveyModel() Class