<?php

/**
 * S# API500Exception() Class
 * @author Edwin Mugendi
 * Api 500 Exception
 */
class Api500Exception extends \BaseException {

    /**
     * S# __contruct() function
     * @author Edwin Mugendi
     * Constructor
      @param string $message Message
     */
    public function __construct($message = '') {
        parent::__construct();
        $this->system_code = 1000;
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
        //Get and set notification
        $this->notification = $this->getNotification($this->system_code, 'developer_message', $this->data);
        
        //Return nofitication response
        return \Response::make($this->notification['data'], $this->notification['http_status_code'])
                        ->header('Content-Type', 'application/json');
    }

//E# thrower() function
}

//E# API500Exception() class
