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
     * @param integer $sender_id Sender Id
     * @param string $sender Sender address
     * @param integer $recipient_id Recipient Id
     * @param mixed $recipient Receipient address, single or multiple
     * @param string $comCode Commication code
     * @param string $lang Language code
     * @param array $parameters Parameters data
     *
     * @return boolean 1 if email is sent 0 otherwise
     */
    public function push($sender_id, $sender, $recipient_id, $recipient, $comCode, $lang, $parameters) {

        //Get com code configs
        $com_code_config = \Config::get($this->package . '::' . $this->controller . '.communication.' . $comCode);

        //Build message
        $parameters['body'] = \Lang::get($this->package . '::' . $this->controller . '.communication.' . $comCode . '.sms', $parameters);

        //Prepare sender
        $sender_id = is_null($sender_id) ? 1 : $sender_id;

        //Push
        $sent = $this->callController(\Util::buildNamespace('messages', 'pushwoosh', 1), 'push', array($recipient, $parameters['os'], $parameters['body']));

        //Add sent to parameters
        $parameters['sent'] = $sent;

        if ($com_code_config['log']) {//Log this message
            //Log this email
            $this->log('push', $sender_id, 'system', $recipient_id, $recipient, $comCode, $lang, $parameters);
        }//E# if statement
    }

//E# push() function

    /**
     * S# sms() function
     * @author Edwin Mugendi
     * Send SMS
     * 
     * @param string $type Message type (email, push, sms)
     * @param integer $sender_id Sender Id
     * @param string $sender Sender address
     * @param integer $recipient_id Recipient Id
     * @param mixed $recipient Receipient address, single or multiple
     * @param string $comCode Commication code
     * @param string $lang Language code
     * @param array $parameters Parameters data
     *
     * @return boolean 1 if email is sent 0 otherwise
     */
    public function sms($sender_id, $sender, $recipient_id, $recipient, $comCode, $lang, $parameters) {

        //Get com code configs
        $com_code_config = \Config::get($this->package . '::' . $this->controller . '.communication.' . $comCode);

        //Build message
        $parameters['body'] = \Lang::get($this->package . '::' . $this->controller . '.communication.' . $comCode . '.sms', $parameters);

        //Prepare sender
        $sender_id = is_null($sender_id) ? 1 : $sender_id;

        //Prepare sender id
        $sender = is_null($sender) ? \Config::get('product.smsSender') : $sender;
        
        /*
        foreach ($recipient as &$singleRecipient) {
            $singleRecipient = $this->cleanSmsSender($singleRecipient);
        }//E# foreach statement
         * 
         */
        
        //SMS
        $sent = $this->callController(\Util::buildNamespace('messages', 'infobips', 1), 'sms', array($sender, $recipient, $parameters['body']));

        //Add sent to parameters
        $parameters['sent'] = $sent;

        if ($com_code_config['log']) {//Log this message
            //Log this email
            $this->log('sms', $sender_id, $sender, $recipient_id, $recipient, $comCode, $lang, $parameters);
        }//E# if statement
    }

//E# sms() function

    /**
     * S# cleanSmsSender() function
     * Return the number if it's valid otherwise return false
     * @param string $number Number
     * @return int The formated number otherwise 0
     */
    public function cleanSmsSender($number) {
        if ((int)substr($number, 0, 1) === 0) {//Starts with 0
            return '44' . substr($number, 1);
        }//E# if statement

        return $number;
    }

//E# cleanSmsSender() function

    public function testSend($type) {
        $recipient = array('07779977791');
        var_dump($recipient);
          foreach ($recipient as &$singleRecipient) {
            $singleRecipient = $this->cleanSmsSender($singleRecipient);
        }//E# foreach statement
        
        //$num = $this->cleanSmsSender('07779977791');
        dd($recipient[0]);
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
     * @param integer $sender_id Sender Id
     * @param string $sender Sender address
     * @param integer $recipient_id Recipient Id
     * @param mixed $recipient Receipient address, single or multiple
     * @param string $comCode Commication code
     * @param string $lang Language code
     * @param array $parameters Parameters data
     * 
     * @return integer 1 if message was sent, 0 otherwise
     */
    public function converse($type, $sender_id, $sender, $recipient_id, $recipient, $comCode, $lang, $parameters = array()) {
        //Add product name
        $parameters['productName'] = \Config::get('product.name');

        switch ($type) {
            case 'email': {
                    return $this->email($sender_id, $sender, $recipient_id, $recipient, $comCode, $lang, $parameters);
                    break;
                }//E# case
            case 'sms': {
                    return $this->sms($sender_id, $sender, $recipient_id, $recipient, $comCode, $lang, $parameters);
                    break;
                }//E# case
            case 'push': {
                    return $this->push($sender_id, $sender, $recipient_id, $recipient, $comCode, $lang, $parameters);
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
     * @param array $parameters The parameters mnm
     * @return string The message
     */
    private function getMessageBody($type, $comCode, $parameters) {
        //Return the actual conversation
        return \View::make($this->package . '::' . $this->controller . '.' . \Config::get('app.locale') . '.' . $comCode . 'View')
                        ->with('view_data', $parameters)
                        ->render();
    }

//E# getMessageBody() function

    /**
     * S# email() function
     * @author Edwin Mugendi
     * Send email
     * 
     * @param integer $sender_id Sender Id
     * @param string $sender Sender address
     * @param integer $recipient_id Recipient Id
     * @param string $recipient Recipient address
     * @param string $comCode Commication code
     * @param string $lang Language code
     * @param array $parameters Parameters data
     * 
     * @return boolean 1 if email is sent 0 otherwise
     */
    public function email($sender_id, $sender, $recipient_id, $recipient, $comCode, $lang, $parameters = array()) {
        //Define view data
        $view_data = array();

        //Set sender
        $sender = $sender ? $sender : \Config::get('product.email');

        //Get body to inject into the template
        $parameters['body'] = $this->getMessageBody('email', $comCode, $parameters);

        //Get com code configs
        $com_code_config = \Config::get($this->package . '::' . $this->controller . '.communication.' . $comCode);

        //Set parameters as view data
        $view_data['view_data'] = $parameters;

        //Set the subject
        $subject = \Lang::get($this->package . '::' . $this->controller . '.communication.' . $comCode . '.email', $parameters);

        //Build the template
        $template = array(
            'html' => $this->package . '::' . $this->controller . '.' . $lang . '.emailTemplateView'
        );

        //Send email
        $sent = (boolean)\Mail::send($template, $view_data, function($message) use(&$recipient, &$senderName, &$subject) {
                    if (array_key_exists('cc', $recipient) && is_array($recipient['cc'])) {//CC
                        foreach ($recipient['cc'] as $cc) {//Cc
                            $message->cc($cc, $senderName);
                        }//E# foreach statement
                    }//E# if statement

                    if (array_key_exists('bcc', $recipient) && is_array($recipient['bcc'])) {//BCC
                        foreach ($recipient['bcc'] as $cc) {//BCC
                            $message->cc($cc, $senderName);
                        }//E# foreach statement
                    }//E# if statement
                    
                    //Set to
                    $message->to($recipient['to'], $senderName)->subject($subject);

                    if (array_key_exists('attachment', $recipient) && is_array($recipient['attachment'])) {//Attach
                        foreach ($recipient['attachment'] as $attachment) {//Attachments
                            $message->attach($attachment);
                        }//E# foreach statement
                    }//E# if statement
                });

        if ($com_code_config['log']) {//Log this record
            //Add sent to parameters
            $parameters['sent'] = $sent;
            //Prepare sender
            $sender_id = is_null($sender_id) ? 1 : $sender_id;

            //Prepare sender id
            $sender = is_null($sender) ? \Config::get('mail.from.address') : $sender;

            //Log this email
            $this->log('email', $sender_id, $sender, $recipient_id, $recipient, $comCode, $lang, $parameters);
        }//E# if statement

        return $sent;
    }

//E# email() function

    /**
     * S# log() function
     * Save the message to the database
     * 
     * @param string $type Message type (email, push, sms)
     * @param integer $sender_id Sender Id
     * @param string $sender Sender address
     * @param integer $recipient_id Recipient Id
     * @param mixed $recipient Receipient address, single or multiple
     * @param string $comCode Commication code
     * @param string $lang Language code
     * @param array $parameters Parameters data
     * 
     * @return Model if created, false otherwise
     */
    private function log($type, $sender_id, $sender, $recipient_id, $recipient, $comCode, $lang, $parameters) {
        //Define message row
        $messageRow = array(
            'type' => $type,
            'code' => $comCode,
            'body' => $parameters['body'],
            'sender_id' => $sender_id,
            'sender' => $sender,
            'recipient_id' => $recipient_id,
            'recipient' => is_array($recipient) ? json_encode($recipient) : $recipient,
            'sent' => $parameters['sent'],
            'status' => 1,
            'created_by' => $sender_id,
            'updated_by' => $sender_id
        );

        //Create message model
        return $this->createIfValid($messageRow, true);
    }

//E# log() function
}

//E# MessageController() function