<?php

/**
 * S# Api200Exception() Class
 * @author Edwin Mugendi
 * Api 200 Exception
 */
class Api200Exception extends \BaseException {

    //Data
    protected $data;

    /**
     * S# __contruct() function
     * @author Edwin Mugendi
     *
     * Constructor
     * @param array $data Data array
     * @param string $message mssage
     */
    public function __construct($data, $message) {
        parent::__construct();
        $this->system_code = 700;
        $this->data = $data;
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
        $this->notification = $this->getNotification($this->system_code, 'developer_message');

        //Return nofitication response
        return \Response::make($this->notification['data'], $this->notification['http_status_code'])
                        ->header('Content-Type', 'application/json');
    }

//E# thrower() function
}

//E# Api200Exception() class
