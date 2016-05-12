<?php

namespace Lava\Loans;

/**
 * S# LoanModel() Class
 * @author Edwin Mugendi
 * Loan Model
 */
class LoanModel extends \BaseModel {

    //Table
    protected $table = 'lon_loans';
    //View fields
    public $viewFields = array(
        'id' => array(1, 'text', '=', 1),
        'user_id' => array(1, 'select', '=', 1),
        'plan_id' => array(1, 'select', '=', 0),
        'currency' => array(1, 'select', '=', 1),
        'principal' => array(1, 'text', '=', 1),
        'interest' => array(1, 'text', '=', 1),
        'workflow' => array(1, 'select', '=', 0),
        'balance' => array(1, 'text', '=', 0),
        'on_schedule' => array(1, 'select', '=', 0),
        'disbursement_date' => array(0, 'text', '=', 0),
        'due_date' => array(0, 'text', '=', 0),
        'instalment' => array(0, 'text', '=', 0),
        'instalments' => array(0, 'text', '=', 0),
        'interest_rate' => array(0, 'text', '=', 0),
        'period' => array(0, 'text', '=', 0),
        'period_cycle' => array(0, 'select', '=', 0),
        'pay_every' => array(0, 'text', '=', 0),
        'cycle' => array(0, 'select', '=', 0),
        'officer_id' => array(0, 'select', '=', 0),
    );
    //Fillable fields
    protected $fillable = array(
        'user_id',
        'plan_id',
        'currency',
        'principal',
        'interest',
        'workflow',
        'balance',
        'on_schedule',
        'disbursement_date',
        'due_date',
        'instalment',
        'instalments',
        'interest_rate',
        'period',
        'period_cycle',
        'pay_every',
        'cycle',
        'officer_id',
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
        'plan_id' => 'required|integer|exists:lon_plans,id',
        'currency' => 'required',
        'principal' => 'required|numeric',
        'interest' => 'required|numeric',
        'workflow' => 'required',
        /* 'balance' => 'required|numeric', */
        /* 'on_schedule' => 'required|integer', */
        'disbursement_date' => 'required|check_date',
        'due_date' => 'required|check_date',
        'instalment' => 'required|numeric',
        'instalments' => 'required|integer',
        'interest_rate' => 'required|numeric',
        'period' => 'required|integer',
        'period_cycle' => 'required',
        'pay_every' => 'required|integer',
        'cycle' => 'required',
        'officer_id' => 'required|integer|exists:acc_users,id',
    );
    //Update validation rules
    public $updateRules = array(
        'user_id' => 'required|integer|exists:acc_users,id',
        'officer_id' => 'required|integer|exists:acc_users,id',
        'plan_id' => 'required|integer|exists:lon_plans,id',
        'currency' => 'required',
        'principal' => 'required|numeric',
        'interest' => 'required|numeric',
        'workflow' => 'required',
        /* 'balance' => 'required|numeric', */
        /* 'on_schedule' => 'required|integer', */
        'disbursement_date' => 'required|check_date',
        'due_date' => 'required|check_date',
        'instalment' => 'required|numeric',
        'instalments' => 'required|integer',
        'interest_rate' => 'required|numeric',
        'period' => 'required|integer',
        'period_cycle' => 'required',
        'pay_every' => 'required|integer',
        'cycle' => 'required',
    );
    //Date fields
    public $dateFields = array('disbursement_date', 'due_date');

    /**
     * S# getOnScheduleTextAttribute() function
     * 
     * Get On Schedule Text
     */
    public function getOnScheduleTextAttribute() {
        return \Lang::has('loans::loan.data.on_schedule.' . $this->attributes['on_schedule']) ? \Lang::get('loans::loan.data.on_schedule.' . $this->attributes['on_schedule']) : '';
    }

//E# getOnScheduleTextAttribute() function

    /**
     * S# getCurrencyTextAttribute() function
     * 
     * Get Currency Text
     */
    public function getCurrencyTextAttribute() {
        return \Lang::has('loans::loan.data.currency.' . $this->attributes['currency']) ? \Lang::get('loans::loan.data.currency.' . $this->attributes['currency']) : '';
    }

//E# getCurrencyTextAttribute() function

    /**
     * S# getWorkflowTextAttribute() function
     * 
     * Get Workflow Text
     */
    public function getWorkflowTextAttribute() {
        return $this->attributes['workflow'] ? \Lang::get('loans::loan.data.workflow.' . $this->attributes['workflow']) : '';
    }

//E# getWorkflowTextAttribute() function

    /**
     * S# getCycleTextAttribute() function
     * 
     * Get Cycle Text
     */
    public function getCycleTextAttribute() {
        return \Lang::has('loans::loan.data.cycle.' . $this->attributes['cycle']) ? \Lang::get('loans::loan.data.cycle.' . $this->attributes['cycle']) : '';
    }

//E# getCycleTextAttribute() function

    /**
     * S# getPeriodCycleTextAttribute() function
     * 
     * Get PeriodCycle Text
     */
    public function getPeriodCycleTextAttribute() {
        return \Lang::has('loans::loan.data.period_cycle.' . $this->attributes['period_cycle']) ? \Lang::get('loans::loan.data.period_cycle.' . $this->attributes['period_cycle']) : '';
    }

//E# getPeriodCycleTextAttribute() function

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
     * S# officer() function
     * Set one to one relationship to Officer Model
     */
    public function officer() {
        return $this->belongsTo(\Util::buildNamespace('accounts', 'user', 2), 'officer_id', 'id');
    }

//E# officer() function

    /**
     * S# getOfficerIdTextAttribute() function
     * 
     * Get Officer Text
     */
    public function getOfficerIdTextAttribute() {

        //Get officer model
        $officer_model = $this->officer()->first();

        //Return name
        return $officer_model->full_name;
    }

//E# getOfficerIdTextAttribute() function
}

//E# LoanModel() Class