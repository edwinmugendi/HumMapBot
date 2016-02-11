<?php

namespace Lava\Accounts;

use GuzzleHttp\Client;

/**
 * S# DvlasearchController() function
 * Dvlasearch Controller
 * @author Edwin Mugendi
 */
class DvlasearchController extends AccountsBaseController {

    //Controller
    public $controller = 'dvlasearch';
    //Lazy load
    public $lazyLoad = array();
    //Gateway
    private $url = 'https://dvlasearch.appspot.com/';
    //API key
    private $api_key;
    //Response
    private $response;

    /**
     * Error codes:
     * 0 - No vehicle found - Lava code - 0
     * 1 - Error eg API key not found and invalid parameters - Lava code 1
     * 2 - vehicle found
     * 3 - API failure
     */
    public function __construct() {
        parent::__construct();

        $this->api_key = \Config::get('thirdParty.dvlasearch.api_key');
    }

//E# contruct() function

    /**
     * S# getVehicleDetails() function
     * 
     * Create Card on Dvlasearch
     */
    public function getVehicleDetails($licence_plate) {

        //Build url
        $this->url .= 'DvlaSearch?licencePlate=' . $licence_plate . '&apikey=' . $this->api_key;

        try {
            //Create guzzle client
            $client = new Client();

            //Send request
            $this->response = $client->get($this->url);

            //Build response
            $this->notification = array(
                'status' => 1,
                'response' => $this->response->json()
            );
        } catch (\Exception $e) {
            $this->notification = array(
                'status' => 0,
                'response' => $e->getMessage(),
            );
        }//E# try catch block

        return $this->notification;
    }

//E# getVehicleDetails() function
}

//E# DvlasearchController() function