<?php

namespace Lava\Payments;

/**
 * S# StripeController() function
 * Stripe Controller
 * @author Edwin Mugendi
 */
class StripeController extends PaymentsBaseController {

    //Controller
    public $controller = 'stripe';
    //Lazy load
    public $lazyLoad = array();
    //Gateway
    private $gateway;
    //Response
    private $response;

    public function __construct() {
        parent::__construct();

        \Stripe\Stripe::setApiKey(\Config::get('thirdParty.stripe.api_secret'));
    }

//E# contruct() function

    public function prepareTransactionArray($status, $stripeTransaction) {

        $transaction = array();
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
        $transaction['gateway'] = 'stripe';
        $transaction['amount'] = $stripeTransaction->amount;
        $transaction['currency'] = $stripeTransaction->currency;

        if ($status) {
            $transaction['gateway_tran_id'] = $stripeTransaction->id;
            $transaction['gateway_code'] = $stripeTransaction->auth_code;
            $transaction['status'] = 1;
        } else {
            $transaction['gateway_tran_id'] = 0;
            $transaction['gateway_code'] = $stripeTransaction->auth_code;
            $transaction['status'] = 0;
        }//E# if else statement

        return $transaction;
    }

    /**
     * S# createTransaction() function
     * Create Card on Stripe
     */
    public function createTransaction($paymentInfo) {
        try {
            //Instantiate Stripe object
            $this->gateway = new \Stripe_Gateway(\Stripe_Environment::$sandbox, trim(\Config::get($this->package . '::thirdParty.stripe.apiKey')), trim(\Config::get($this->package . '::thirdParty.stripe.apiSecret')));

            $this->response = $this->gateway->createTransaction(
                            new \Stripe_User(array(
                        'id' => $paymentInfo['stripeUserId']
                            )), new \Stripe_Card(array(
                        'token' => $paymentInfo['cardToken']
                            )), new \Stripe_Transaction(array(
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
        } catch (\Stripe_ApiException $e) {
            $this->notification = array(
                'status' => 0,
                'response' => $e->getMessage(),
                'code' => $e->getCode()
            );
        } catch (\Exception $e) {
            $this->notification = array(
                'status' => 0,
                'response' => $e->getMessage(),
                'code' => 500
            );
        }//E# try catch block

        return $this->notification;
    }

//E# createTransaction() function

    /**
     * S# sync() function
     * Sync out local card to those in Stripe
     * 
     */
    public function sync() {
        try {
            //Instantiate Stripe object
            $this->gateway = new \Stripe_Gateway(\Stripe_Environment::$sandbox, trim(\Config::get($this->package . '::thirdParty.stripe.apiKey')), trim(\Config::get($this->package . '::thirdParty.stripe.apiSecret')));

            //Lazy load to load
            $parameters['lazyLoad'] = array('cards');

            //Get user by id
            $userModel = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getModelByField', array('id', $this->user['id'], $parameters));

            $cardsToRetain = array();

            $savedCards = $userModel->cards;
            $dbCardTokens = $userModel->cards->lists('token');

            //List cards on stripe
            $this->response = $this->gateway->listCards(
                            new \Stripe_User(
                            array('id' => $userModel->stripe_id)
                            )
                    )->send();


            $stripeCardTokens = array();

            foreach ($this->response->cards as $singleCard) {
                array_push($stripeCardTokens, $singleCard->token);

                if (in_array($singleCard->token, $dbCardTokens)) {//Clean
                } else {//Create in the database
                    $cardToCreate = $this->buildCardModelData($this->user['id'], $singleCard);
                    //Save users card
                    $cardModel = $this->callController(\Util::buildNamespace('payments', 'card', 1), 'createIfValid', array($cardToCreate, true));
                }//E# if statement
            }//E# foreach statement

            $dbCardTokensToDelete = array_diff($dbCardTokens, $stripeCardTokens);

            if ($dbCardTokensToDelete) {//Delete card on db
                $userModel->cards()->whereIn('token', $dbCardTokensToDelete)->delete();
            }//# if statement

            if ($this->subdomain == 'api') {//From API
                //Get success message
                $message = \Lang::get($this->package . '::' . $this->controller . '.api.sync');

                throw new \Api200Exception($stripeCardTokens, $message);
            }//E# if else statement
        } catch (\Stripe_ApiException $e) {
            $this->notification = array(
                'status' => 0,
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            );
        }

        return $this->notification;
    }

//E# sync() function

    private function buildCardModelData($userId, $stripeCard) {
        $card = array();

        $address = (isset($stripeCard->address)) ? (array) $stripeCard->address : (array) $stripeCard;

        $card = array(
            'gateway_id' => 1,
            'token' => $stripeCard->token,
            'number' => $stripeCard->number,
            'type' => $stripeCard->type,
            'user_id' => $userId,
            'expiry' => $stripeCard->expiry,
            'address_country' => array_get($address, 'country'),
            'address_city' => array_get($address, 'city'),
            'address_street' => array_get($address, 'street'),
            'address_postal_code' => array_get($address, 'postal_code'),
        );

        return $card;
    }

    /**
     * S# createUser() function
     * Create user on Stripe
     * 
     * @param int $userId User id 
     * @param string $email Email address 
     * @param string $password Password 
     * @param string $firstName First name 
     * @param string $lastName Last name
     * @param string $phone Phone number
     * @param json $description. JSON of all the other fields 
     * 
     * @return array Response
     */
    public function createUser($userInfo) {

        //Required user fields
        $userData = array(
            'email' => $userInfo['email'],
            'description' => $userInfo['description'],
            'metadata' => array_except($userInfo, array('description'))
        );

        try {
            //Create user on stripe
            $this->response = \Stripe\Customer::create($userData);

            //Build response
            $this->response = array(
                'status' => 1,
                'response' => $this->response
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
     * 
     * Create Card on Stripe
     * 
     * @param str $stripe_id Stripe customer id 
     * @param str $stripe_card_token Stripe card token
     * 
     * @return array Response
     */
    public function createCard($stripe_id, $stripe_card_token) {

        try {
            //Get customer
            $customer = \Stripe\Customer::retrieve($stripe_id);

            //Attached card to customer on stripe
            $this->response = $customer->sources->create(array(
                'source' => $stripe_card_token
            ));

            //Build response
            $this->response = array(
                'status' => 1,
                'response' => $this->response
            );
        } catch (\Exception $e) {
            $this->response = array(
                'status' => 0,
                'response' => $e->getMessage()
            );
        }

        return $this->response;
    }

//E# createCard() function

    /**
     * S# deleteCard() function
     * 
     * Delete card on stripe
     * 
     * @param str $stripe_id Stripe customer id 
     * @param str $stripe_card_token Stripe card token
     * 
     * @return array Response
     */
    public function deleteCard($stripe_id, $stripe_card_token) {
        try {

            //Get customer
            $customer = \Stripe\Customer::retrieve($stripe_id);

            //Delete customer's card on Stripe
            $this->response = $customer
                    ->sources
                    ->retrieve($stripe_card_token)
                    ->delete();

            //Build response
            $this->response = array(
                'status' => 1,
                'response' => $this->response
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

//E# StripeController() function