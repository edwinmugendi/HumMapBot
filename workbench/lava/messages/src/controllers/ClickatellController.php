<?php

namespace Lava\Messages;

/**
 * S# ClickatellController() function
 * Clickatell controller
 * @author Edwin Mugendi
 */
class ClickatellController extends MessagesBaseController {

    //Controller
    public $controller = 'clickatell';
    public $smsClient;

    /**
     * S# __construct() function
     */
    public function __construct() {
        parent::__construct();

        //Get configs
        $configs = \Config::get($this->package . '::thirdParty.clickatell');

        //Instantiate an SMS client
        $this->smsClient = \Bdt\Clickatell\ClickatellClient::factory(array(
                    'api_id' => $configs['apiId'],
                    'user' => $configs['user'],
                    'password' => $configs['password'],
        ));
    }

//E# __construct() function

    /**
     * S# sms() function
     * Send SMS
     * @param mixed $sender Sender id
     * @param int $recipient International number forma
     * @param string $message Message
     * @return int 1 is SMS is send, 0 otherwise
     */
    public function sms($sender, $recipient, $message) {
        return (int) $this->smsClient->sendMessage($recipient, $message);
    }

//E# sms() function
}

//E# ClickatellController() function