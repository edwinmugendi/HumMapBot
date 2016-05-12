<?php

namespace Lava\Messages;

require_once base_path() . '/workbench/lava/messages/src/libraries/oneapi/client.php';

/**
 * S# InfobipsController() function
 * Infobips controller
 * @author Edwin Mugendi
 */
class InfobipsController extends MessagesBaseController {

    //Controller
    public $controller = 'infobips';
    public $smsClient;

    public function __construct() {
        //dd(base_path());
        parent::__construct();
        //Instantiate SMS client
        $this->smsClient = new \SmsClient(\Config::get($this->package . '::thirdParty.infoBips.username'), \Config::get($this->package . '::thirdParty.infoBips.password'));
    }

    /**
     * S# sms() function
     * Send SMS
     * @param mixed $sender Sender id
     * @param int $receipent International number forma
     * @param string $message Message
     * @return int 1 is SMS is send, 0 otherwise
     */
    public function sms($sender, $receipient, $message) {

        //Login
        $this->smsClient->login();

        //Build sms object
        $smsMessage = new \SMSRequest();
        $smsMessage->senderAddress = $sender;
        $smsMessage->address = $receipient;
        $smsMessage->message = $message;

        //Send
        $smsMessageSendResult = $this->smsClient->sendSMS($smsMessage);

        //Query status
        $smsMessageStatus = $this->smsClient->queryDeliveryStatus($smsMessageSendResult);
        $deliveryStatus = $smsMessageStatus->deliveryInfo[0]->deliveryStatus;

        //Possible statuses are: DeliveredToTerminal, DeliveryUncertain, DeliveryImpossible, MessageWaiting and DeliveredToNetwork.
        return in_array($deliveryStatus, array('DeliveredToTerminal', 'DeliveryUncertain', 'MessageWaiting', 'DeliveredToNetwork')) ? 1 : 0;
    }

//E# sms() function
}

//E# InfobipsController() function