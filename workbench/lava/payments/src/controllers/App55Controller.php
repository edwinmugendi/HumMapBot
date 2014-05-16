<?php

namespace Lava\Payments;

/**
 * S# App55Controller() function
 * App55 Controller
 * @author Edwin Mugendi
 */
class App55Controller extends PaymentsBaseController {

    //Controller
    public $controller = 'app55';
    //Lazy load
    public $lazyLoad = array();
    //Gateway
    private $gateway;
    //Response
    private $response;

    public function prepareTransactionArray($app55Transaction) {
        /**
          object(stdClass)#284 (7) {
          ["id"]=>
          string(18) "140507161003_34177"
          ["type"]=>
          string(4) "sale"
          ["description"]=>
          string(1) "1"
          ["currency"]=>
          string(3) "GBP"
          ["code"]=>
          string(9) "succeeded"
          ["amount"]=>
          string(2) "12"
          ["auth_code"]=>
          string(5) "06603"
          }
         * */
        $transaction = array(
            'gateway_tran_id' => $app55Transaction->id,
            'gateway_code' => $app55Transaction->auth_code,
            'amount' => $app55Transaction->amount,
            'currency' => 'GBP',
            'description' => $app55Transaction->description,
            'status' => 1
        );

        return $transaction;
    }

    /**
     * S# createTransaction() function
     * Create Card on App55
     */
    public function createTransaction($paymentInfo) {
        try {
            //Instantiate App55 object
            $this->gateway = new \App55_Gateway(\App55_Environment::$sandbox, trim(\Config::get($this->package . '::thirdParty.app55.apiKey')), trim(\Config::get($this->package . '::thirdParty.app55.apiSecret')));

            $this->response = $this->gateway->createTransaction(
                            new \App55_User(array(
                        'id' => $paymentInfo['app55UserId']
                            )), new \App55_Card(array(
                        'token' => $paymentInfo['cardToken']
                            )), new \App55_Transaction(array(
                        'amount' => $paymentInfo['amount'],
                        'currency' => $paymentInfo['currency'],
                        'description' => $paymentInfo['description'],
                        'commit' => true
                            ))
                    )->send();

            $this->notification = array(
                'status' => 1,
                'response' => $this->response->transaction
            );
        } catch (\App55_ApiException $e) {
            $this->notification = array(
                'status' => 0,
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            );
        } catch (\Exception $e) {
            $this->notification = array(
                'status' => 0,
                'message' => $e->getMessage(),
                'code' => 500
            );
        }//E# try catch block

        return $this->notification;
    }

//E# createTransaction() function

    /**
     * S# sync() function
     * Sync out local card to those in App55
     * 
     */
    public function sync() {
        try {
            //Instantiate App55 object
            $this->gateway = new \App55_Gateway(\App55_Environment::$sandbox, trim(\Config::get($this->package . '::thirdParty.app55.apiKey')), trim(\Config::get($this->package . '::thirdParty.app55.apiSecret')));

            //Lazy load to load
            $parameters['lazyLoad'] = array('cards');

            //Get user by id
            $userModel = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getModelByField', array('id', $this->user['id'], $parameters));

            $cardsToRetain = array();

            $savedCards = $userModel->cards;
            $dbCardTokens = $userModel->cards->lists('token');
            $app55user = $userModel->app55;
            //$service = $this->app55;

            $this->response = $this->gateway->listCards(
                            new \App55_User(
                            array('id' => $app55user->id)
                            )
                    )->send();

            $app55CardTokens = array();

            foreach ($this->response->cards as $singleCard) {
                array_push($app55CardTokens, $singleCard->token);

                if (in_array($singleCard->token, $dbCardTokens)) {//Clean
                } else {//Create in the database
                    $cardToCreate = $this->buildCardModelData($this->user['id'], $singleCard);
                    //Save users card
                    $cardModel = $this->callController(\Util::buildNamespace('payments', 'card', 1), 'createIfValid', array($cardToCreate, true));
                }//E# if statement
            }//E# foreach statement

            $dbCardTokensToDelete = array_diff($dbCardTokens, $app55CardTokens);

            if ($dbCardTokensToDelete) {//Delete card on db
                $userModel->cards()->whereIn('token', $dbCardTokensToDelete)->delete();
            }//# if statement

            if ($this->subdomain == 'api') {//From API
                //Get success message
                $message = \Lang::get($this->package . '::' . $this->controller . '.api.sync');

                throw new \Api200Exception($app55CardTokens, $message);
            }//E# if else statement
        } catch (\App55_ApiException $e) {
            $this->notification = array(
                'status' => 0,
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            );
        }

        return $this->notification;
    }

//E# sync() function

    private function buildCardModelData($userId, $app55Card) {
        $card = array();

        $address = (isset($app55Card->address)) ? (array) $app55Card->address : (array) $app55Card;

        $card = array(
            'gateway_id' => 1,
            'token' => $app55Card->token,
            'number' => $app55Card->number,
            'type' => $app55Card->type,
            'user_id' => $userId,
            'expiry' => $app55Card->expiry,
            'address_country' => array_get($address, 'country'),
            'address_city' => array_get($address, 'city'),
            'address_street' => array_get($address, 'street'),
            'address_postal_code' => array_get($address, 'postal_code'),
        );

        return $card;
    }

    /**
     * S# createUser() function
     * Create user on App55
     * @param int $userId User id 
     * @param string $email Email address 
     * @param string $password Password 
     * @param string $firstName First name 
     * @param string $lastName Last name
     * @param string $phone Phone number 
      @return Object Response object with status  = 1 or 0
     */
    public function createUser($userInfo) {

        //Required user fields
        $userData = array(
            'email' => $userInfo['email'],
            'password' => $userInfo['password'],
            'password_confirm' => $userInfo['password']
        );

        //Check if optional user fields exist
        if (array_key_exists('first_name', $userInfo) && $userInfo['first_name']) {//First name not ''
            $userData['first'] = $userInfo['first_name'];
        }//E# if statement

        if (array_key_exists('last_name', $userInfo) && $userInfo['last_name']) {//Last name not ''
            $userData['last'] = $userInfo['last_name'];
        }//E# if statement

        if (array_key_exists('phone', $userInfo) && $userInfo['phone']) {//Phone not ''
            $userData['phone'] = $userInfo['phone'];
        }//E# if statement
        try {
            //Instantiate App55 object
            $this->gateway = new \App55_Gateway(\App55_Environment::$sandbox, trim(\Config::get($this->package . '::thirdParty.app55.apiKey')), trim(\Config::get($this->package . '::thirdParty.app55.apiSecret')));

            //Create App55 user
            $this->response = $this->gateway->createUser(new \App55_User($userData))->send();

            //Build response
            $this->response = array(
                'status' => 1,
                'response' => $this->response
            );
        } catch (\App55_ApiException $e) {
            $this->response = array(
                'status' => 0,
                'response' => $e->getMessage()
            );
        } catch (\Exception $e) {
            $this->response = array(
                'status' => 0,
                'response' => $e->getMessage()
            );
        }//E# try catch block

        return $this->response;
    }

//E# createUser() function

    /**
     * S# createCard() function
     * Create Card on App55
     */
    public function createCard() {

        try {
            //Instantiate App55 object
            $this->gateway = new \App55_Gateway(\App55_Environment::$sandbox, trim(\Config::get($this->package . '::thirdParty.app55.apiKey')), trim(\Config::get($this->package . '::thirdParty.app55.apiSecret')));

            $this->response = $this->gateway->createCard(
                            new \App55_User(array(
                        'id' => 4733
                            )), new \App55_Card(array(
                        'address' => new \App55_Address(array(
                            'street' => '8 Exchange Quay',
                            'city' => 'Manchester',
                            'postal_code' => 'M5 3EJ',
                            'country' => 'GB'
                                )),
                        'holder_name' => 'APP55 USER',
                        'number' => '4111111111111111',
                        'expiry' => '03/2015',
                        'security_code' => '240'
                            ))
                    )->send();
        } catch (\App55_ApiException $e) {
            
        }
        dd('created');
    }

//E# createCard() function

    /**
     * S# deleteCard() function
     * Delete card on app55
     * 
     * @param array $deleteData Delete data
     * 
     */
    public function deleteCard($deleteData) {
        try {
            //Instantiate App55 object
            $this->gateway = new \App55_Gateway(\App55_Environment::$sandbox, trim(\Config::get($this->package . '::thirdParty.app55.apiKey')), trim(\Config::get($this->package . '::thirdParty.app55.apiSecret')));

            //Delete card on app55
            $this->response = $this->gateway->deleteCard(
                            new \App55_User(array(
                        'id' => $deleteData['app55UserId']
                            )), new \App55_Card(array(
                        'token' => $deleteData['token']
                            ))
                    )->send();

            $this->response = array(
                'status' => 1,
                'response' => array(
                    'sig' => $this->response->sig,
                    'ts' => $this->response->ts
                )
            );
        } catch (\App55_ApiException $e) {
            $this->response = array(
                'status' => 0,
                'response' => $e->getMessage()
            );
        } catch (\Exception $e) {
            $this->response = array(
                'status' => 0,
                'response' => $e->getMessage()
            );
        }//E# try catch block

        return $this->response;
    }

}

//E# App55Controller() function