<?php
namespace Lava\Accounts;
/**
 * S# LoginModel() Class
 * @author Edwin Mugendi
 * Login Model
 */
class LoginModel extends \Eloquent {

    //Table
    protected $table = 'acc_logins';
    
    //Fillable fields
    protected $fillable = array(
        'user_id',
        'ip_address',
        'date_time',
        'status',
        'created_by',
        'updated_by'
    );
    protected $hidden = array(
        'status',
        'created_by',
        'updated_by',
        'deleted_at'
    );
    //Create validation rules
    public $createRules = array(
        'user_id' => 'required|integer',
        'ip_address' => 'ip',
        'date_time' => 'date',
        'status' => 'required|integer',
        'created_by' => 'required|integer',
        'updated_by' => 'required|integer',
    );
    
}

//E# LoginModel() Class