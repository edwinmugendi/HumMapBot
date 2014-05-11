<?php

/**
 * S# API404Exception() Class
 * @author Edwin Mugendi
 * Api 404 Exception
 */
class Api404Exception extends \BaseException {

    /**
     * S# __contruct() function
     * @author Edwin Mugendi
     * Constructor
     * @param object $validation a validation object 
     * @param array $rules validation rules
     * @param array $replacements Language line replacements
     */
    public function __construct($data) {
        parent::__construct();
        $this->systemCode = 904;
        $this->data = $data;
    }

//E# __construct() function

    /**
     * S# thrower() function
     * @author Edwin Mugendi
     * Build and throw return the exception
     * @return mixed json or redirect
     */
    public function thrower() {
        //Get and set notification
        $this->notification = $this->getNotification($this->systemCode, 'developerMessage',$this->data);

        //Return nofitication response
        return \Response::make($this->notification['data'], $this->notification['httpStatusCode'])
                        ->header('Content-Type', 'application/json');
    }

//E# thrower() function
}

//E# API404Exception() class
