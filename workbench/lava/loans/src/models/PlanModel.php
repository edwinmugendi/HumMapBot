<?php

namespace Lava\Loans;

/**
 * S# PlanModel() Class
 * @author Edwin Mugendi
 * Plan Model
 */
class PlanModel extends \BaseModel {

    //Table
    protected $table = 'lon_plans';
    //View fields
    public $viewFields = array(
        'id' => array(1, 'text', '=', 1),
        'amount_from' => array(1, 'text', '=', 1),
        'amount_to' => array(1, 'text', '=', 1),
        'period' => array(1, 'text', '=', 0),
        'period_cycle' => array(1, 'select', '=', 0),
        'interest_rate' => array(1, 'text', '=', 0),
        'pay_every' => array(1, 'text', '=', 0),
        'cycle' => array(1, 'select', '=',),
    );
    //Fillable fields
    protected $fillable = array(
        'amount_from',
        'amount_to',
        'period',
        'period_cycle',
        'interest_rate',
        'pay_every',
        'cycle',
        'agent',
        'ip',
        'status',
        'created_by',
        'updated_by',
    );
    //Appends fields
    protected $appends = array(
        'cycle_text',
        'period_cycle_text',
    );
    protected $hidden = array();
    //Create validation rules
    public $createRules = array(
        'amount_from' => 'required|integer',
        'amount_to' => 'required|integer',
        'period' => 'required|integer',
        'period_cycle' => 'required',
        'interest_rate' => 'required|numeric',
        'pay_every' => 'required',
        'cycle' => 'required',
    );
    //Update validation rules
    public $updateRules = array(
        'amount_from' => 'required|integer',
        'amount_to' => 'required|integer',
        'period' => 'required|integer',
        'period_cycle' => 'required',
        'interest_rate' => 'required|numeric',
        'pay_every' => 'required',
        'cycle' => 'required',
    );

    /**
     * S# getCycleTextAttribute() function
     * 
     * Get Cycle Text
     */
    public function getCycleTextAttribute() {
        return \Lang::has('loans::plan.data.cycle.' . $this->attributes['cycle']) ? \Lang::get('loans::plan.data.cycle.' . $this->attributes['cycle']) : '';
    }

//E# getCycleTextAttribute() function
    /**
     * S# getPeriodCycleTextAttribute() function
     * 
     * Get PeriodCycle Text
     */
    public function getPeriodCycleTextAttribute() {
        return \Lang::has('loans::plan.data.period_cycle.' . $this->attributes['period_cycle']) ? \Lang::get('loans::plan.data.period_cycle.' . $this->attributes['period_cycle']) : '';
    }

//E# getPeriodCycleTextAttribute() function
}

//E# PlanModel() Class