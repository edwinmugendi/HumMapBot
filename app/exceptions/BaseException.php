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
    protected $systemCode;
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
     * @param integer $systemCode System code
     * @param string $messageKey Message to get
     * @param array $replacement Replacement array
     * 
     * @return array Notification
     */
    public function getNotification($systemCode, $messageKey, $replacement = array()) {
       
        //Build message
        $notificationMessage = $this->message ? $this->message : \Lang::get('httpStatus.systemCode.' . $systemCode . '.' . $messageKey, $replacement);
         
        //Get the HTTP/1.1 code
        $this->notification['httpStatusCode'] = (int) \Lang::get('httpStatus.systemCode.' . $systemCode . '.httpStatusCode', $replacement);
                
        //Build notification
        $this->notification['data'] = array(
            'httpStatusCode' => $this->notification['httpStatusCode'],
            'systemCode' => $systemCode,
            'message' => $notificationMessage
        );

        if (!is_null($this->data)) {//Data is not NULL
            $this->notification['data']['data'] = $this->data;
        }//E# if statement
        return $this->notification;
    }

}

//E# BaseException() class

