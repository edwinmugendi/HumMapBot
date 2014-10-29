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
     * S# push() function
     * @author Edwin Mugendi
     * Send Push
     * 
     * @param string $type Message type (email, push, sms)
     * @param integer $senderId Sender Id
     * @param string $sender Sender address
     * @param integer $recipientId Recipient Id
     * @param mixed $recipient Receipient address, single or multiple
     * @param string $comCode Commication code
     * @param string $lang Language code
     * @param array $parameters Parameters data
     *
     * @return boolean 1 if email is sent 0 otherwise
     */
    public function push($senderId, $sender, $recipientId, $recipient, $comCode, $lang, $parameters) {


        //Get com code configs
        $comCodeConfig = \Config::get($this->package . '::' . $this->controller . '.communication.' . $comCode);

        //Build message
        $parameters['body'] = \Lang::get($this->package . '::' . $this->controller . '.communication.' . $comCode . '.sms', $parameters);

        //Prepare sender
        $senderId = is_null($senderId) ? 1 : $senderId;

        //Push
        $sent = $this->callController(\Util::buildNamespace('messages', 'urbanairship', 1), 'push', array($recipient, $parameters['os'], $parameters['body']));

        //Add sent to parameters
        $parameters['sent'] = $sent;

        if ($comCodeConfig['log']) {//Log this message
            //Log this email
            $this->log('push', $senderId, 'system', $recipientId, $recipient, $comCode, $lang, $parameters);
        }//E# if statement
    }

//E# push() function

    /**
     * S# sms() function
     * @author Edwin Mugendi
     * Send SMS
     * 
     * @param string $type Message type (email, push, sms)
     * @param integer $senderId Sender Id
     * @param string $sender Sender address
     * @param integer $recipientId Recipient Id
     * @param mixed $recipient Receipient address, single or multiple
     * @param string $comCode Commication code
     * @param string $lang Language code
     * @param array $parameters Parameters data
     *
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

        //Message parameters
        $parameters = array(
            'name' => 'Edwin',
            'tranId' => '1',
            'product' => 'product',
            'productId' => 'product_id',
            'vrm' => 'KAN',
            'location' => 'Location',
            'day' => 'Monday',
            'time' => '12:30 PM',
            'os' => 'ios'
        );
        $sent = $this->converse('push', null, null, 1, '9A6E26299DBB199969B50BABD67839CC0ACCC07C287B664DD80D0A94F740C9D9', 'transactionUserCard', \Config::get('app.locale'), $parameters);
    
        dd($sent);
    }

    /**
     * S# converse() function
     * Send either email, sms or push
     *
     * @param string $type Message type (email, push, sms)
     * @param integer $senderId Sender Id
     * @param string $sender Sender address
     * @param integer $recipientId Recipient Id
     * @param mixed $recipient Receipient address, single or multiple
     * @param string $comCode Commication code
     * @param string $lang Language code
     * @param array $parameters Parameters data
     * 
     * @return integer 1 if message was sent, 0 otherwise
     */
    public function converse($type, $senderId, $sender, $recipientId, $recipient, $comCode, $lang, $parameters = array()) {
        //Add product name
        $parameters['productName'] = \Config::get('product.name');

        switch ($type) {
            case 'email': {
                    return $this->email($senderId, $sender, $recipientId, $recipient, $comCode, $lang, $parameters);
                    break;
                }//E# case
            case 'sms': {
                    return $this->sms($senderId, $sender, $recipientId, $recipient, $comCode, $lang, $parameters);
                    break;
                }//E# case
            case 'push': {
                    return $this->push($senderId, $sender, $recipientId, $recipient, $comCode, $lang, $parameters);
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
            'html' => $this->package . '::' . $this->controller . '.' . $lang . '.emailTemplateView'
        );

        //Send email
        $sent = \Mail::send($template, $viewData, function($message) use(&$recipient, &$senderName, &$subject) {
                    if (is_array($recipient)) {//Send to many
                        //Set to
                        $message->to($recipient[0], $senderName)->subject($subject);

                        //Unset first recipient
                        unset($recipient[0]);

                        foreach ($recipient as $cc) {//Build cc
                            $message->cc($cc, $senderName);
                        }//E# foreach statement
                    } else {//Send to only one
                        $message->to($recipient, $senderName)->subject($subject);
                    }//E# if else statement
                });

        if ($comCodeConfig['log']) {//Log this record
            //Add sent to parameters
            $parameters['sent'] = 1;
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
     * @param mixed $recipient Receipient address, single or multiple
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
            'recipient' => is_array($recipient) ? json_encode($recipient) : $recipient,
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