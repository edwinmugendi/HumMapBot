<?php

namespace Lava\Surveys;

/**
 * S# AirtableController() function
 * Airtable controller
 * @author Edwin Mugendi
 */
class AirtableController extends SurveysBaseController {

    //Controller
    public $controller = 'airtable';
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
        $this->configs = \Config::get('thirdParty.airtable');

        // Create Airtable API object
        $this->service = new AirtableClient($this->configs['developer_access_token']);
    }

//E# __contruct() function
    

    /**
     * S# query() function
     * 
     * Query
     * 
     * @param array $query_array Query array
     */
    public function query($query_array) {
        try {
            $query = $this->service->get('query', $query_array/* [
                      'query' => $text,
                      'confidence' => 1,
                      'sessionId' => '1234567890',
                      ] */);

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

//E# AirtableController() function