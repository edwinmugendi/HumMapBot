<?php

namespace Lava\Messages;

use Gomoob\Pushwoosh\Client\Pushwoosh;
use Gomoob\Pushwoosh\Model\Request\CreateMessageRequest;
use Gomoob\Pushwoosh\Model\Notification\Notification;

/**
 * S# PushwooshController() function
 * Pushwoosh controller
 * @author Edwin Mugendi
 */
class PushwooshController extends MessagesBaseController {

    //Controller
    public $controller = 'pushwoosh';
    public $pushClient;

    /**
     * S# __construct() function
     */
    public function __construct() {
        parent::__construct();

        //Get configs
        $configs = \Config::get($this->package . '::thirdParty.pushwoosh');

        //Instantiate Push client
        $this->pushClient = Pushwoosh::create()
                ->setApplication($configs['application'])
                ->setAuth($configs['auth']);
    }

//E# __construct() function

    /**
     * S# push() function
     * Push
     * 
     * @param string $token Push token
     * @param string $os Operating System
     * @param string $message Message
     *
     * @return Response
     * */
    public function push($token, $os, $message) {
        try {
            //Build notification
            $notification = Notification::create()
                    ->addDevice($token)
                    ->setContent($message);

            //Create message request
            $request = CreateMessageRequest::create()
                    ->addNotification($notification);

            //Woosh
            $response = $this->pushClient->createMessage($request);

            // Check if its ok
            if ($response->isOk()) {
                $this->response = 1;
            } else {
                $this->response = 0;
            }//E# if else statement
        } catch (\Exception $e) {
            $this->response = 0;
        }//E# try catch statement

        return $this->response;
    }

//E# push() function
}

//E# PushwooshController() function