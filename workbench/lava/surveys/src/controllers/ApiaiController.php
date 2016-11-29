<?php

namespace Lava\Surveys;

use Carbon\Carbon;
use ApiAi\Client as ApiaiClient;

/**
 * S# ApiaiController() function
 * Apiai controller
 * @author Edwin Mugendi
 */
class ApiaiController extends SurveysBaseController {

    //Controller
    public $controller = 'apiai';
    private $service;
    private $configs;
    private $request;
    private $response;

    /**
     * S# __construct() function
     * 
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        //Get configs
        $this->configs = \Config::get('thirdParty.apiai');

        //dd($this->configs['client_access_token']);
        // Create Apiai API object
        $this->service = new ApiaiClient($this->configs['developer_access_token']);
    }

//E# __contruct() function

    /**
     * S# query() function
     * 
     * Query
     * 
     * @param str $text Text
     */
    public function query($text) {
        try {
            $query = $this->service->get('query', [
                'query' => $text,
                'confidence' => 1,
                'sessionId' => '1234567890',
            ]);

            echo $query->getBody();
            echo '<p>';
            $this->response = array(
                'status' => 1,
                'message' => json_decode((string) $query->getBody(), true)
            );
        } catch (\Exception $error) {
            $this->response = array(
                'status' => 0,
                'message' => $error->getMessage()
            );
        }//E# try catch block

        return $this->response;
    }

//E# query() function
}

//E# ApiaiController() function