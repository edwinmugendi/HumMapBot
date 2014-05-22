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
     * S# getFeel() function
     * Favourite, rate or review a location
     * Favourite: type == 1, no other field is needed
     * Rate: type == 2, rate field is needed and should be between 1 and 5
     * Review: type == 3, review field is need
     * 
     * @param int $id Location
     * @return json 
     */
    public function getFeel($id) {
        //Add location id to inputs for validation
        $this->input['id'] = $id;

        //Define validation rules
        $this->validationRules = array(
            'id' => 'required|exists:mct_locations,id',
            'type' => 'required|integer|between:1,3',
            'rate' => 'required_if:type,2|integer|between_if:type,2,1,5',
            'review' => 'required_if:type,3'
        );
        //Validate location
        $this->isInputValid();

        if ($this->input['type'] == 1 || $this->input['type'] == 2) {//Favourite location: NB: Can only be one row
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
                    'operand' => $id
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
            $feeling = $this->input['type'] == 2 ? $this->input['rate'] : '';

            if ($feelModel) {//Exists
                $feelModel->feeling = $feeling;
                $feelModel->save();
            } else {//Create
                //Define feeling row
                $feelingRow = array(
                    'user_id' => $this->user['id'],
                    'location_id' => $id,
                    'type' => $this->input['type'],
                    'feeling' => $feeling
                );
                //Get feel model
                $feelModel = $this->createIfValid($feelingRow, true);
            }//E# if statement
        } else {//Review
            //Define feeling row
            $feelingRow = array(
                'user_id' => $this->user['id'],
                'location_id' => $id,
                'type' => $this->input['type'],
                'feeling' => $this->input['review']
            );
            //Get feel model
            $feelModel = $this->createIfValid($feelingRow, true);
        }//E# if statement
        //Get success message
        $message = \Lang::get($this->package . '::' . $this->controller . '.api.feel.' . $this->input['type'], array('field' => 'id', 'value' => $this->input['id']));

        //Throw API success Exception
        throw new \Api200Exception(array_only($feelModel->toArray(), array('id')), $message);
    }

//E# postFeel() function
    
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
    public function postFeel($id) {
        //Add location id to inputs for validation
        $this->input['id'] = $id;

        //Define validation rules
        $this->validationRules = array(
            'id' => 'required|exists:mct_locations,id',
            'type' => 'required|integer|between:1,3',
            'rate' => 'required_if:type,2|integer|between_if:type,2,1,5',
            'review' => 'required_if:type,3'
        );
        //Validate location
        $this->isInputValid();

        if ($this->input['type'] == 1 || $this->input['type'] == 2) {//Favourite location: NB: Can only be one row
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
                    'operand' => $id
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
            $feeling = $this->input['type'] == 2 ? $this->input['rate'] : '';

            if ($feelModel) {//Exists
                $feelModel->feeling = $feeling;
                $feelModel->save();
            } else {//Create
                //Define feeling row
                $feelingRow = array(
                    'user_id' => $this->user['id'],
                    'location_id' => $id,
                    'type' => $this->input['type'],
                    'feeling' => $feeling
                );
                //Get feel model
                $feelModel = $this->createIfValid($feelingRow, true);
            }//E# if statement
        } else {//Review
            //Define feeling row
            $feelingRow = array(
                'user_id' => $this->user['id'],
                'location_id' => $id,
                'type' => $this->input['type'],
                'feeling' => $this->input['review']
            );
            //Get feel model
            $feelModel = $this->createIfValid($feelingRow, true);
        }//E# if statement
        //Get success message
        $message = \Lang::get($this->package . '::' . $this->controller . '.api.feel.' . $this->input['type'], array('field' => 'id', 'value' => $this->input['id']));

        //Throw API success Exception
        throw new \Api200Exception(array_only($feelModel->toArray(), array('id')), $message);
    }

//E# postFeel() function
}

//E# FeelController() function