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

    public function getCard($token = null) {
        if (is_null($token)) {//Get users cards
            //Lazy load to load
            $parameters['lazyLoad'] = array('cards');

            //Get user by token
            $userModel = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getModelByField', array('token', $this->input['token'], $parameters));

            $pluralController = $this->controller . 's';

            if ($this->subdomain == 'api') {//From API
                //Get success message
                $message = \Lang::get($this->package . '::' . $this->controller . '.api.getAll');

                throw new \Api200Exception($userModel->$pluralController->toArray(), $message);
            }//E# if else statement
        } else {//Get a single vehicle
            $this->input['token'] = $token;
            $this->validationRules = array(
                'token' => 'required'
            );
            //Validate vehicle
            $this->isInputValid();
            //Parameters
            $parameters['lazyLoad'] = array('user');

            $cardModel = $this->getModelByField('token', $this->input['token'], $parameters);

            if ($cardModel) {
                if ($cardModel->user && ($cardModel->user->id == $this->user['id'])) {
                    //Get success message
                    $message = \Lang::get($this->package . '::' . $this->controller . '.api.getSingle', array('field' => 'token', 'value' => $this->input['token']));

                    throw new \Api200Exception(array_except($cardModel->toArray(), array('user')), $message);
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

                //Throw Locationf not found error
                throw new \Api404Exception($this->notification);
            }
        }
    }

}

//E# CardController() function