<?php

/**
 * S# BaseException() Class
 * @author Edwin Mugendi
 * Base Exception class
 */
class BaseException extends \Exception {

    //Data array
    protected $data;
    //System code
    protected $system_code;
    //Notification
    protected $notification;
    //Replacement
    protected $replacement;
    
    protected $message;
    
    public function __construct() {
        parent::__construct();
        //To prevent the language replacement from erroring 
        $this->data = array();
    }//E# __construct() function
    
    
    /**
     * S# getNotification() function
     * 
     * Get notification
     * 
     * @param integer $system_code System code
     * @param string $messageKey Message to get
     * @param array $replacement Replacement array
     * 
     * @return array Notification
     */
    public function getNotification($system_code, $messageKey, $replacement = array()) {
       
        //Build message
        $notificationMessage = $this->message ? $this->message : \Lang::get('httpStatus.system_code.' . $system_code . '.' . $messageKey, $replacement);
         
        //Get the HTTP/1.1 code
        $this->notification['http_status_code'] = (int) \Lang::get('httpStatus.system_code.' . $system_code . '.http_status_code', $replacement);
                
        //Build notification
        $this->notification['data'] = array(
            'http_status_code' => $this->notification['http_status_code'],
            'system_code' => $system_code,
            'message' => $notificationMessage
        );

        if (!is_null($this->data)) {//Data is not NULL
            $this->notification['data']['data'] = $this->data;
        }//E# if statement
        return $this->notification;
    }

}

//E# BaseException() class

