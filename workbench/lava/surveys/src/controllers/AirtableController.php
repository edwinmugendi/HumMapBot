<?php

namespace Lava\Surveys;

use Armetiz\AirtableSDK\Airtable;

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
        $this->service = new Airtable($this->configs['api_key'], $this->configs['base_id']);
    }

//E# __contruct() function

    /**
     * S# listRecords() function
     * 
     * List Records
     * 
     * @param array 
     */
    public function findRecords($table, $criteria) {

        try {
            $response = $this->service->findRecords($table, $criteria);

            $this->response = array(
                'status' => 1,
                'message' => $response
            );
        } catch (\Exception $error) {
            $this->response = array(
                'status' => 0,
                'message' => $error->getMessage()
            );
        }//E# try catch block

        return $this->response;
    }

//E# findRecords() function

    /**
     * S# findRecords() function
     * 
     * Find Single Records
     * 
     * @param array 
     */
    public function findSingleRecord($table, $criteria) {
        /*
          $table = 'Facets';

          $criteria = array(
          'id' => 'recZKiX8HvjEjxDTd',
          ); */
        try {
            $response = $this->service->findRecord($table, $criteria);

            $this->response = array(
                'status' => 1,
                'message' => $response
            );
        } catch (\Exception $error) {
            $this->response = array(
                'status' => 0,
                'message' => $error->getMessage()
            );
        }//E# try catch block

        return $this->response;
    }

//E# findRecords() function

    public function getSolutions($table, $criteria) {
        $facet_response = $this->findRecords($table, $criteria);

        $solution_answer = 'Facet Description:' . "\n";
        if ($facet_response['status']) {
            $fields = $facet_response['message'][0]->getFields();

            $solution_answer .= $fields['Description'];
            //Get Solutions
            $this->getSolutionsOrTools($solution_answer, $fields['Solutions'], 'Solutions', 'Solution');
            //Get Tools
            $this->getSolutionsOrTools($solution_answer, $fields['Tools'], 'Tools', 'Tool');
        }//E# if statement

        return $solution_answer;
    }

    private function getSolutionsOrTools(&$solution_answer, $field_ids, $field_name, $title) {


        if ($field_ids) {
            $index = 1;
            foreach ($field_ids as $single_field_id) {
                $table = $field_name;

                $criteria = array(
                    'id' => $single_field_id,
                );

                $field_response = $this->findSingleRecord($table, $criteria);

                if ($field_response['status']) {
                    // dd($solution_response);
                    $fields = $field_response['message'][0]->getFields();

                    $solution_answer .= "\n\n" . '' . $title . ' ' . $index . ': ' . $fields[$table] . "\n";

                    if (array_key_exists('Description', $fields)) {
                        $solution_answer .= "\n" . 'Description:' . "\n" . $fields['Description'];
                    }//E# if statement
                }//E# if statement

                $index++;
            }//E# foreach statement;
        }
    }

}

//E# AirtableController() function