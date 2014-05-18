<?php

namespace Lava\Messages;

/**
 * S# MessageController() function
 * Message controller
 * @author Edwin Mugendi
 */
class MessageController extends MessagesBaseController {

    //Controller  
    public $controller = 'message';

    /**
     * S# sms() function
     * @author Edwin Mugendi
     * Send email
     * @param string $sender The sender's email
     * @param string $recipient The recipient's email
     * @param string $comCode The communication code
     * @param array $parameters The parameters 
     * @return boolean 1 if email is sent 0 otherwise
     */
    public function sms($senderId, $sender, $recipientId, $recipient, $comCode, $lang, $parameters) {
        
        //Get com code configs
        $comCodeConfig = \Config::get($this->package . '::' . $this->controller . '.communication.' . $comCode);
        
        //Build message
        $parameters['body'] = \Lang::get($this->package . '::' . $this->controller . '.communication.' . $comCode . '.sms', $parameters);
        
        //Prepare sender
        $senderId = is_null($senderId) ? 1 : $senderId;
        
        //Prepare sender id
        $sender = is_null($sender) ? \Config::get('product.smsSender') : $sender;
        
        //SMS
        $sent = $this->callController(\Util::buildNamespace('messages', 'clickatell', 1), 'sms', array($sender, $recipient, $parameters['body']));

        //Add sent to parameters
        $parameters['sent'] = $sent;

        if ($comCodeConfig['log']) {//Log this message
            //Log this email
            $this->log('sms', $senderId, $sender, $recipientId, $recipient, $comCode, $lang, $parameters);
        }//E# if statement
    }

//E# sms() function

    public function testSend($type) {
        $parameters = array(
            'welcome'
        );

        $sent = $this->sms(null, null, 1, '+254722', 'welcome', 'en', array());
    }

    /**
     * S# converse() function
     * Send either email, sms or push
     *
     * @param string $type Message type (email, push, sms)
     * @param integer $senderId Sender Id
     * @param string $sender Sender address
     * @param integer $recipientId Recipient Id
     * @param string $recipient Recipient address
     * @param string $comCode Commication code
     * @param string $lang Language code
     * @param array $parameters Parameters data
     * 
     * @return integer 1 if message was sent, 0 otherwise
     */
    public function converse($type, $senderId, $sender, $recipientId, $recipient, $comCode, $lang, $parameters = array()) {
        switch ($type) {
            case 'email': {

                    return $this->email($senderId, $sender, $recipientId, $recipient, $comCode, $lang, $parameters);
                    break;
                }//E# case
            case 'sms': {
                    return $this->sms($senderId, $sender, $recipientId, $recipient, $comCode, $lang, $parameters);
                    break;
                }//E# case
            default:
                break;
        }//E# switch statement
    }

//E# converse() function

    /**
     * S# getMessageBody() function
     * @author Edwin Mugendi
     * Get message body as as string
     * @param string $type Is is Email, SMS or Push
     * @param string $comCode The communication code
     * @param array $parameters The parameters 
     * @return string The message
     */
    private function getMessageBody($type, $comCode, $parameters) {
        //Return the actual conversation
        return \View::make($this->package . '::' . $this->controller . '.' . \Config::get('app.locale') . '.' . $comCode . 'View')
                        ->with('viewData', $parameters)
                        ->render();
    }

//E# getMessageBody() function

    /**
     * S# email() function
     * @author Edwin Mugendi
     * Send email
     * 
     * @param integer $senderId Sender Id
     * @param string $sender Sender address
     * @param integer $recipientId Recipient Id
     * @param string $recipient Recipient address
     * @param string $comCode Commication code
     * @param string $lang Language code
     * @param array $parameters Parameters data
     * 
     * @return boolean 1 if email is sent 0 otherwise
     */
    public function email($senderId, $sender, $recipientId, $recipient, $comCode, $lang, $parameters = array()) {
        //Define view data
        $viewData = array();

        //Get body to inject into the template
        $parameters['body'] = $this->getMessageBody('email', $comCode, $parameters);

        //Get com code configs
        $comCodeConfig = \Config::get($this->package . '::' . $this->controller . '.communication.' . $comCode);

        //Set parameters as view data
        $viewData['viewData'] = $parameters;

        //Set the subject
        $subject = \Lang::get($this->package . '::' . $this->controller . '.communication.' . $comCode . '.email', $parameters);

        //Build the template
        $template = array(
            'html' => $this->package . '::' . $this->controller . '.' . \Config::get('app.locale') . '.emailTemplateView'
        );

        //Send email
        /* UNCOMMENT
          $sent = \Mail::send($template, $viewData, function($message) use(&$recipient, &$senderName, &$subject) {
          $message->to($recipient, $senderName)->subject($subject);
          });
         */
        $sent = 1;

        if ($comCodeConfig['log']) {//Log this record
            //Add sent to parameters
            $parameters['sent'] = $sent;
            //Prepare sender
            $senderId = is_null($senderId) ? 1 : $senderId;

            //Prepare sender id
            $sender = is_null($sender) ? \Config::get('mail.from.address') : $sender;

            //Log this email
            $this->log('email', $senderId, $sender, $recipientId, $recipient, $comCode, $lang, $parameters);
        }//E# if statement
        //Return sent response
        return $sent;
    }

//E# email() function

    /**
     * S# log() function
     * Save the message to the database
     * 
     * @param string $type Message type (email, push, sms)
     * @param integer $senderId Sender Id
     * @param string $sender Sender address
     * @param integer $recipientId Recipient Id
     * @param string $recipient Recipient address
     * @param string $comCode Commication code
     * @param string $lang Language code
     * @param array $parameters Parameters data
     * 
     * @return Model if created, false otherwise
     */
    private function log($type, $senderId, $sender, $recipientId, $recipient, $comCode, $lang, $parameters) {
        //Define message row
        $messageRow = array(
            'type' => $type,
            'code' => $comCode,
            'body' => $parameters['body'],
            'sender_id' => $senderId,
            'sender' => $sender,
            'recipient_id' => $recipientId,
            'recipient' => $recipient,
            'sent' => $parameters['sent'],
            'status' => 1,
            'created_by' => $senderId,
            'updated_by' => $senderId
        );

        //Create message model
        return $this->createIfValid($messageRow, true);
    }

//E# log() function
}

//E# MessageController() function