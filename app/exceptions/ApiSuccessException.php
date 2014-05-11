<?php

/**
 * S# ApiSuccessException() Class
 * @author Edwin Mugendi
 * Api Success Exception
 */
class ApiSuccessException extends \BaseException {

    //Data
    protected $data;

    /**
     * S# __contruct() function
     * @author Edwin Mugendi
     * Constructor
     * @param object $validation a validation object 
     * @param array $rules validation rules
     * @param array $replacements Language line replacements
     */
    public function __construct($controllerModel = null, $message) {
        parent::__construct();
        $this->systemCode = 700;
        $this->data = $controllerModel;
        $this->message = $message;
    }

//E# __construct() function

    /**
     * S# thrower() function
     * @author Edwin Mugendi
     * Build and throw return the exception
     * @return mixed json or redirect
     */
    public function thrower() {
        //dd($this->data); 
        //Get and set notification
        $this->notification = $this->getNotification($this->systemCode, 'developerMessage');

        //Return nofitication response
        return \Response::make($this->notification['data'], $this->notification['httpStatusCode'])
                        ->header('Content-Type', 'application/json');
    }

//E# thrower() function
}

//E# ApiSuccessException() class
