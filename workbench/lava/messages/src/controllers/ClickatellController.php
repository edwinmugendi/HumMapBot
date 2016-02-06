<?php

namespace Lava\Messages;

use Clickatell\Api\ClickatellHttp;

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
        $configs = \Config::get('thirdParty.clickatell');

        //Instantiate SMS client
        $this->smsClient = new ClickatellHttp($configs['username'], $configs['password'], $configs['apiId']);
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