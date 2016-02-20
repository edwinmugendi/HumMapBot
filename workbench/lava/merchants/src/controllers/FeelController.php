<?php

namespace Lava\Merchants;

/**
 * S# FeelController() function
 * Feel controller
 * @author Edwin Mugendi
 */
class FeelController extends MerchantsBaseController {

    //Controller
    public $controller = 'feel';

    /**
     * S# postUnfeel() function
     * Favourite, rate or review a location
     * Favourite: type == 1, no other field is needed
     * Rate: type == 2, no other field is needed
     * Review: type == 3, review_id field is need
     * Stamps: type == 4
     * 
     * @param int $id Location
     * @return json 
     */
    public function postUnfeel() {
        
        //Define validation rules
        $this->validationRules = array(
            'location_id' => 'required|exists:mct_locations,id',
            'type' => 'required|integer|between:1,3',
            'review_id' => 'required_if:type,3'
        );
        //Validate location
        $this->isInputValid();

        //Fields to select
        $fields = array('id');

        //Build where clause
        $whereClause = array(
            array(
                'where' => 'where',
                'column' => 'user_id',
                'operator' => '=',
                'operand' => $this->user['id']
            ),
            array(
                'where' => 'where',
                'column' => 'location_id',
                'operator' => '=',
                'operand' => $this->input['location_id']
            ),
            array(
                'where' => 'where',
                'column' => 'type',
                'operator' => '=',
                'operand' => $this->input['type']
            )
        );

        if ($this->input['type'] == 3) {//Review
            $whereClause[] = array(
                'where' => 'where',
                'column' => 'id',
                'operator' => '=',
                'operand' => $this->input['review_id']
            );
        }//E# if statement
        //Get feel model
        $feelModel = $this->select($fields, $whereClause, 1);

        if ($feelModel) {//Exists
            $feelModel->delete();
            //Get success message
            $message = \Lang::get($this->package . '::' . $this->controller . '.api.unfeel.' . $this->input ['type']);

            //Throw API success Exception
            throw new \Api200Exception(array_only($feelModel->toArray(), array('id')), $message);
        } else {//404
            //Set notification
            $this->notification = array(
                'field' => 'id',
                'type' => \Lang::get($this->package . '::' . $this->controller . '.data.type.' . $this->input['type']),
                'value' => $this->input['location_id'],
            );

            //Throw VRM not found error
            throw new \Api404Exception($this->notification);
        }//E# if statement
    }

//E# postUnfeel() function

    /**
     * S# postFeel() function
     * Favourite, rate or review a location
     * Favourite: type == 1, no other field is needed
     * Rate: type == 2, rate field is needed and should be between 1 and 5
     * Review: type == 3, review field is need
     * 
     * @param int $id Location
     * @return json 
     */
    public function postFeel() {

        //Define validation rules
        $this->validationRules = array(
            'location_id' => 'required|exists:mct_locations,id',
            'type' => 'required|integer|between:1,3',
            'rate' => 'required_if:type,2|integer|between_if:type,2,1,5',
            'review' => 'required_if:type,3'
        );
        //Validate location
        $this->isInputValid();

        if ($this->input ['type'] == 1 || $this->input ['type'] == 2) {//Favourite location: NB: Can only be one row
            //Fields to select
            $fields = array('*');

            //Build where clause
            $whereClause = array(
                array(
                    'where' => 'where',
                    'column' => 'user_id',
                    'operator' => '=',
                    'operand' => $this->user['id']
                ),
                array(
                    'where' => 'where',
                    'column' => 'location_id',
                    'operator' => '=',
                    'operand' => $this->input['location_id']
                ),
                array(
                    'where' => 'where',
                    'column' => 'type',
                    'operator' => '=',
                    'operand' => $this->input['type']
                )
            );
            //Get feel model
            $feelModel = $this->select($fields, $whereClause, 1);

            //Cache feeling
            $feeling = $this->input ['type'] == 2 ? $this->input['rate'] : '';

            if ($feelModel) {//Exists
                $feelModel->feeling = $feeling;
                $feelModel->save();
            } else {//Create
                //Define feeling row
                $feelingRow = array(
                    'user_id' => $this->user['id'],
                    'location_id' => $this->input['location_id'],
                    'type' => $this->input['type'],
                    'feeling' => $feeling,
                    'status' => 1,
                    'ip'=>  $this->input['ip'],
                    'agent'=>  $this->input['agent'],
                    'created_by' => $this->user['id'],
                    'updated_by' => $this->user['id']
                );
                //Get feel model
                $feelModel = $this->createIfValid($feelingRow, true);
            }//E# if statement
        } else {//Review
            //Define feeling row
            $feelingRow = array(
                'user_id' => $this->user['id'],
                'location_id' => $this->input['location_id'],
                'type' => $this->input['type'],
                'feeling' => $this->input['review'],
                'status' => 1,
                'created_by' => $this->user['id'],
                'updated_by' => $this->user['id']
            );
            //Get feel model
            $feelModel = $this->createIfValid($feelingRow, true);
        }//E# if statement
        //Get success message
        $message = \Lang::get($this->package . '::' . $this->controller . '.notification.feel.' . $this->input ['type']);

        //Throw API success Exception
        throw new \Api200Exception(array_only($feelModel->toArray(), array('id')), $message);
    }

//E# postFeel() function
}

//E# FeelController() function