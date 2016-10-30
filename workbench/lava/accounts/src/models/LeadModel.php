<?php

namespace Lava\Accounts;

/**
 * S# LeadModel() Class
 * @author Edwin Mugendi
 * Lead Model
 */
class LeadModel extends \BaseModel {

    //Table
    protected $table = 'acc_leads';
    //View fields
    public $viewFields = array(
        'full_name' => array(1, 'text', 'like', 1),
        'organization' => array(1, 'text', 'like', 1),
        'phone' => array(1, 'text', 'like'),
        'email' => array(1, 'text', '='),
        'country_id' => array(1, 'select', '='),
        'note' => array(1, 'text', 'like'),
        'created_at' => array(1, 'text', 'like'),
        'action' => array(1, 'select', '='),
    );
    //Fillable fields
    protected $fillable = array(
        'full_name',
        'organization',
        'email',
        'phone',
        'country_id',
        'source',
        'workflow',
        'note',
        'agent',
        'ip',
        'status',
        'created_by',
        'updated_by',
    );
//Appends fields
    protected $appends = array(
        'country_id_text',
        'workflow_text',
        'source_text',
        'action_text',
    );
    //Hidden fields
    protected $hidden = array();
    //Create rules
    public $createRules = array(
        'full_name' => 'required|min:2',
        'organization' => 'required|min:2',
        'reg_email' => 'required|email',
        'phone' => 'required',
        'country_id' => 'required',
        //'source' => 'required',
        //'workflow' => 'required',
            //'note' => 'required',
    );
    //Update rules
    public $updateRules = array(
        'full_name' => 'required|min:2',
        'organization' => 'required|min:2',
        'email' => 'required|email',
        'phone' => 'required',
        'number' => 'required|integer',
        'country_id' => 'required',
        'town' => 'required',
        //'source' => 'required',
        //'workflow' => 'required',
            //'note' => 'required',
    );
    //Delete rules
    public $deleteRules = array(
        'id' => 'required|exists:acc_leads,id'
    );

    /**
     * S# country() function
     * Set one to one relationship to Country Model
     */
    public function country() {
        return $this->belongsTo(\Util::buildNamespace('locations', 'country', 2), 'country_id');
    }

//E# country() function

    /**
     * S# getCountryIdTextAttribute() function
     * Get Country Text
     */
    public function getCountryIdTextAttribute() {
        //Get country model
        $country_model = $this->country()->first();
        //Return name
        return $country_model ? $country_model->name : '';
    }

//E# getCountryIdTextAttribute() function

    /**
     * S# getWorkflowTextAttribute() function
     * Get Workflow Text
     */
    public function getWorkflowTextAttribute() {
        return \Lang::has('accounts::lead.data.workflow.' . $this->attributes['workflow']) ? \Lang::get('accounts::lead.data.workflow.' . $this->attributes['workflow']) : '';
    }

//E# getWorkflowTextAttribute() function

    /**
     * S# getSourceTextAttribute() function
     * Get Source Text
     */
    public function getSourceTextAttribute() {
        return \Lang::has('accounts::lead.data.source.' . $this->attributes['source']) ? \Lang::get('accounts::lead.data.source.' . $this->attributes['source']) : '';
    }

//E# getSourceTextAttribute() function

    /**
     * S# getActionTextAttribute() function
     * Get Action Text
     */
    public function getActionTextAttribute() {
        //if ($this->attributes['action']) {
        $action = \Lang::has('accounts::lead.data.action.' . $this->attributes['action']) ? \Lang::get('accounts::lead.data.action.' . $this->attributes['action']) : '';
        // } else {
        return $action . '<br>' . \Form::compositeSelect('action', \Lang::get('accounts::lead.data.action'), $this->attributes['action'], array('class' => 'leadAction', 'data-id' => $this->attributes['id']));
        // }
    }

//E# getActionTextAttribute() function
}

//E# LeadModel() Class