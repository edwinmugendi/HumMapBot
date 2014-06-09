<?php

namespace Lava\Messages;

/**
 * S# UrbanairshipController() function
 * Urbanairship controller
 * @author Edwin Mugendi
 */
class UrbanairshipController extends MessagesBaseController {

    //Controller
    public $controller = 'urbanairship';
    public $pushClient;

    /**
     * S# __construct() function
     */
    public function __construct() {
        parent::__construct();

        //Get configs
        $configs = \Config::get($this->package . '::thirdParty.urbanairship');

        //Instantiate Push client
        $this->pushClient = new \UrbanAirship\Airship($configs['appKey'],$configs['appMaster']);
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
            $this->response = $this->pushClient->push()
                    ->setAudience($token)
                    ->setNotification($message)
                    ->setDeviceTypes($os)
                    ->send();
            $this->response = 1;
        } catch (\AirshipException $e) {
            $this->response = 0;
        } catch (\Exception $e) {
            $this->response = 0;
        }//E# try catch statement

        return $this->response;
    }

//E# push() function
}

//E# UrbanairshipController() function