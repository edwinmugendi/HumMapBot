<?php

/**
 * S# Api400Exception() Class
 * @author Edwin Mugendi
 * API 400 Exception
 */
class Api400Exception extends \BaseException {

    //Validation Object
    private $validation;
    //Validation rules
    private $rules;

    /**
     * S# __contruct() function
     * @author Edwin Mugendi
     * Constructor
     * @param object $validation a validation object 
     * @param array $rules validation rules
     * @param array $replacements Language line replacements
     */
    public function __construct($validation, $rules) {
        parent::__construct();
        $this->system_code = 900;
        $this->validation = $validation;
        $this->rules = $rules;
    }

//E# __construct() function

    /**
     * S# thrower() function
     * @author Edwin Mugendi
     * Build and throw return the exception
     * @return mixed json or redirect
     */
    public function thrower() {
        
        foreach ($this->rules as $field => $singleRule) {//Loop through the rules
            if ($this->validation->messages()->get($field)) {
                $error = array();
                $error['field'] = $field;
                $error['error'] = $this->validation->messages()->first($field);
                $this->data[] = $error;
            }//E# if statement
        }//E# foreach statement
        
        //Get and set notification
        $this->notification = $this->getNotification($this->system_code, 'developer_message');

        //Return nofitication response
        return \Response::make($this->notification['data'], $this->notification['http_status_code'])
                        ->header('Content-Type', 'application/json');
    }

//E# thrower() function

}

//E# Api400Exception() class
