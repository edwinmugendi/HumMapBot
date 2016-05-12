<?php

namespace Lava\Accounts;

use Carbon\Carbon;

/**
 * S# LogModel() Class
 * @author Edwin Mugendi
 * Log Model
 */
class LogModel extends \BaseModel {

    //Table
    protected $table = 'acc_logs';
    //View fields
    public $viewFields = array(
        'id' => array(1, 'text', '=', 1),
        'user_id' => array(1, 'select', '=', 1),
        'type' => array(1, 'select', '=', 1),
        'in_out' => array(1, 'select', '=', 1),
        'account_number' => array(1, 'text', '=', 0),
        'log_date' => array(1, 'text', '=', 0),
        'log_datetime' => array(0, 'text', '=', 0),
        'seconds' => array(1, 'text', '=', 0),
    );
    //Fillable fields
    protected $fillable = array(
        'merchant_id',
        'user_id',
        'type',
        'in_out',
        'account_number',
        'log_date',
        'log_datetime',
        'seconds',
        'agent',
        'ip',
        'status',
        'created_by',
        'updated_by',
    );
    protected $hidden = array();
    //Create validation rules
    public $createRules = array();
    //Create update rules
    public $updateRules = array();

    /**
     * S# getTypeTextAttribute() function
     * 
     * Get Type Text
     */
    public function getTypeTextAttribute() {
        return $this->attributes['type'] ? \Lang::get('accounts::log.data.type.' . $this->attributes['type']) : '';
    }

//E# getTypeTextAttribute() function

    /**
     * S# getInOutTextAttribute() function
     * 
     * Get InOut Text
     */
    public function getInOutTextAttribute() {
        return $this->attributes['in_out'] ? \Lang::get('accounts::log.data.in_out.' . $this->attributes['in_out']) : '';
    }

//E# getInOutTextAttribute() function
}

//E# LogModel() Class