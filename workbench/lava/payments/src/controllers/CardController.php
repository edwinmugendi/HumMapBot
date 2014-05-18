<?php

namespace Lava\Payments;

/**
 * S# CardController() function
 * Card Controller
 * @author Edwin Mugendi
 */
class CardController extends PaymentsBaseController {

    //Controller
    public $controller = 'card';
    //Lazy load
    public $lazyLoad = array();

    /**
     * S# postSync() function
     * Sync cards on App55
     */
    public function postSync() {
        //Sync card on app55
        $this->callController(\Util::buildNamespace('payments', 'app55', 1), 'sync');
    }

//E# postSync() function

    /**
     * S# deleteCard() function
     * Delete card from db and app55
     * 
     * @param string $token Card token
     */
    public function deleteCard($token) {
        $cardModel = $this->getCardIfItExists($token);

        if ($cardModel) {//Card exists
            if ($cardModel->user && ($cardModel->user->id == $this->user['id'])) {//User owns this card
                //Build delete data
                $deleteData = array(
                    'app55UserId' => $cardModel->user->app55_id,
                    'token' => $token
                );
                //Delete card on app55
                $deleteCardResponse = $this->callController(\Util::buildNamespace('payments', 'app55', 1), 'deleteCard', array($deleteData));

                if ($deleteCardResponse['status']) {//Card deleted
                    
                    //Delete card on our database
                    $cardModel->delete();
                    
                    //Get success message
                    $message = \Lang::get($this->package . '::' . $this->controller . '.api.delete', array('field' => 'token', 'value' => $this->input['token']));

                    throw new \Api200Exception(array($this->input['token']), $message);
                } else {//Error occur

                    throw new \Api500Exception($deleteCardResponse['response']);
                }//E# if else statemetn
            } else {
                //Set notification
                $this->notification = array(
                    'field' => 'token',
                    'type' => 'Card',
                    'value' => $this->input['token'],
                );

                //Throw 403 error
                throw new \Api403Exception($this->notification);
            }
        } else {
            //Set notification
            $this->notification = array(
                'field' => 'token',
                'type' => 'Card',
                'value' => $this->input['token'],
            );

            //Throw 404 error
            throw new \Api404Exception($this->notification);
        }//E# if else statement
    }

//E# deleteCard() function

   
    /**
     * S# getCardIfItExists() function
     * Get card by token
     * 
     * @param string $token Card token
     * @return Model Card Model if exists or false
     */
    private function getCardIfItExists($token) {
        //Add token to inputs
        $this->input['token'] = $token;

        //Validation rules
        $this->validationRules = array(
            'token' => 'required'
        );
        //Validate inputs
        $this->isInputValid();

        //Parameters
        $parameters['lazyLoad'] = array('user');

        //Get card by token
        return $this->getModelByField('token', $this->input['token'], $parameters);
    }

//E# getCardIfItExists() function
}

//E# CardController() function