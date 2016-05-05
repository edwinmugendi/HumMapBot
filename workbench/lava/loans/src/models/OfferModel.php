<?php

namespace Lava\Loans;

/**
 * S# OfferModel() Class
 * @author Edwin Mugendi
 * Offer Model
 */
class OfferModel extends \BaseModel {

    //Table
    protected $table = 'lon_offers';
    //View fields
    public $viewFields = array(
        'id' => array(1, 'text', '=', 1),
        'user_id' => array(1, 'select', '=', 1),
        'plan_id' => array(1, 'select', '=', 1),
        'currency' => array(1, 'text', '=', 1),
        'principal' => array(1, 'text', '=', 0),
        'workflow' => array(1, 'select', '=', 0),
    );
    //Fillable fields
    protected $fillable = array(
        'user_id',
        'plan_id',
        'currency',
        'principal',
        'workflow',
        'agent',
        'ip',
        'status',
        'created_by',
        'updated_by',
    );
    //Appends fields
    protected $appends = array();
    protected $hidden = array();
    //Create validation rules
    public $createRules = array(
        'user_id' => 'required|integer|exists:acc_users,id',
        'plan_id' => 'required|exists:lon_plans,id',
        'currency' => 'required',
        'principal' => 'required|numeric',
        'workflow' => 'required',
    );
    //Update validation rules
    public $updateRules = array(
        'user_id' => 'required|integer|exists:acc_users,id',
        'plan_id' => 'required|exists:lon_plans,id',
        'currency' => 'required',
        'principal' => 'required|numeric',
        'workflow' => 'required',
    );

    /**
     * S# plan() function
     * Set one to one relationship to Plan Model
     */
    public function plan() {
        return $this->belongsTo(\Util::buildNamespace('loans', 'plan', 2), 'plan_id', 'id');
    }

//E# plan() function

    /**
     * S# getPlanIdTextAttribute() function
     * 
     * Get Plan Text
     */
    public function getPlanIdTextAttribute() {

        //Get plan model
        $plan_model = $this->plan()->first();

        //Return name
        return $plan_model ? $plan_model->period . ' ' . $plan_model->period_cycle_text . ' ' . $plan_model->interest_rate . ' pay ' . $plan_model->pay_every . ' ' . $plan_model->cycle_text : '';
    }

//E# getPlanIdTextAttribute() function
    /**
     * S# getCurrencyTextAttribute() function
     * 
     * Get Currency Text
     */
    public function getCurrencyTextAttribute() {
        return \Lang::has('loans::offer.data.currency.' . $this->attributes['currency']) ? \Lang::get('loans::offer.data.currency.' . $this->attributes['currency']) : '';
    }

//E# getCurrencyTextAttribute() function

    /**
     * S# getWorkflowTextAttribute() function
     * 
     * Get Workflow Text
     */
    public function getWorkflowTextAttribute() {
        return $this->attributes['workflow'] ? \Lang::get('loans::offer.data.workflow.' . $this->attributes['workflow']) : '';
    }

//E# getWorkflowTextAttribute() function

    /**
     * S# user() function
     * Set one to one relationship to User Model
     */
    public function user() {
        return $this->belongsTo(\Util::buildNamespace('accounts', 'user', 2), 'user_id', 'id');
    }

//E# user() function

    /**
     * S# getUserIdTextAttribute() function
     * 
     * Get User Text
     */
    public function getUserIdTextAttribute() {

        //Get user model
        $user_model = $this->user()->first();

        //Return name
        return $user_model ? $user_model->first_name . ' ' . $user_model->last_name : '';
    }

//E# getUserIdTextAttribute() function
}

//E# OfferModel() Class