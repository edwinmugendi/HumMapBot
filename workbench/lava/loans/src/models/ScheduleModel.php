<?php

namespace Lava\Loans;

/**
 * S# ScheduleModel() Class
 * @author Edwin Mugendi
 * Schedule Model
 */
class ScheduleModel extends \BaseModel {

    //Table
    protected $table = 'lon_schedules';
    //View fields
    public $viewFields = array(
        'id' => array(1, 'text', '=', 1),
        'loan_id' => array(1, 'select', '=', 1),
        'amount' => array(1, 'text', '=', 1),
        'due_date' => array(1, 'text', '=', 1),
    );
    //Fillable fields
    protected $fillable = array(
        'loan_id',
        'amount',
        'due_date',
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
        'loan_id' => 'required|integer|exists:lon_loans,id',
        'amount' => 'required|integer',
        'due_date' => 'required|check_date',
    );
    //Update validation rules
    public $updateRules = array(
        'loan_id' => 'required|integer|exists:lon_loans,id',
        'amount' => 'required|integer',
        'due_date' => 'required|check_date',
    );
    //Date fields
    public $dateFields = array('disbursement_date', 'due_date');

    /**
     * S# loan() function
     * Set one to one relationship to Loan Model
     */
    public function loan() {
        return $this->belongsTo(\Util::buildNamespace('loans', 'loan', 2), 'loan_id', 'id');
    }

//E# loan() function

    /**
     * S# getLoanIdTextAttribute() function
     * 
     * Get Loan Text
     */
    public function getLoanIdTextAttribute() {

        //Get loan model
        $loan_model = $this->loan()->first();

        //Return name
        return $loan_model ? $loan_model->user_id_text . ' ' . $loan_model->currency . ' ' . $loan_model->principal . ' ' . $loan_model->balance . ' ' : '';
    }

//E# getLoanIdTextAttribute() function
}

//E# ScheduleModel() Class