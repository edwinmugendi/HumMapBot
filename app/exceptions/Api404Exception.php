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
     * @param array $data data array
     */
    public function __construct($data) {
        parent::__construct();
        $this->system_code = 904;
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
        $this->notification = $this->getNotification($this->system_code, 'developer_message', $this->data);

        //Return nofitication response
        return \Response::make($this->notification['data'], $this->notification['http_status_code'])
                        ->header('Content-Type', 'application/json');
    }

//E# thrower() function
}

//E# API404Exception() class
