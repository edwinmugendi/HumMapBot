<?php

namespace Lava\Payments;

use Carbon\Carbon;

/**
 * S# PaymentController() function
 * Payment controller
 * @author Edwin Mugendi
 */
class PaymentController extends PaymentsBaseController {

    //Controller
    public $controller = 'payment';
    //Lazy load
    public $lazyLoad = array();

    /**
     * S# processWithStamps() function
     * Process trancation with loyalty stamps
     */
    public function processWithStamps() {
        $this->validationRules = array(
            'product_id' => 'required',
            'location' => 'latLng',
            'vehicle_id' => 'required|processTransactionWithStamps',
        );

        $this->isInputValid();
    }

//E# process() function
    /**
     * S# getLocationStamps() function
     * @author Edwin Mugendi
     * Get a users stamps on a certain location
     * 
     * @param integer $location_id Location id
     * @param integer $user_id User id
     * 
     * @return Model Feel Model or ''
     */
    public function getLocationStamps($location_id, $user_id) {
        //Fields to select
        $fields = array('*');

        //Build where clause
        $whereClause = array(
            array(
                'where' => 'where',
                'column' => 'user_id',
                'operator' => '=',
                'operand' => $user_id
            ),
            array(
                'where' => 'where',
                'column' => 'location_id',
                'operator' => '=',
                'operand' => $location_id
            ),
            array(
                'where' => 'where',
                'column' => 'type',
                'operator' => '=',
                'operand' => 4
            )
        );
        //Get feel model
        return $this->callController(\Util::buildNamespace('merchants', 'feel', 1), 'select', array($fields, $whereClause, 1));
    }

//E# getLocationStamps() function

    /**
     * S# updateLoyaltyStamp() function
     * Update users loyalty stamp
     * 
     * @param integer $location_id Location id
     * @param integer $user_id User id
     * 
     */
    private function updateLoyaltyStamp($location_id, $user_id) {
        //Get Loyalty stamp
        $feelModel = $this->getLocationStamps($location_id, $user_id);

        if ($feelModel) {//Stamp exists
            //Increment stamp by one
            $feelModel->feeling = ((int) $feelModel->feeling + 1);

            //Save stamps
            $feelModel->save();
        } else {//Stamp does not exist
            //Define feeling array
            $feelArray = array(
                'user_id' => $user_id,
                'location_id' => $location_id,
                'feeling' => 1,
                'type' => 4,
                'status' => $user_id,
                'created_by' => $user_id,
                'updated_by' => $user_id,
            );

            //Create users stamp
            $this->callController(\Util::buildNamespace('merchants', 'feel', 1), 'createIfValid', array($feelArray, true));
        }//E# if else statement
    }

//E# updateLoyaltyStamp() function

    /**
     * S# afterProcessing() function
     * 
     * Call this after successful credit card processing
     * 
     * @param string $card_or_stamps_or_promotion Card or loyalty stamps
     * @param model $transaction_model Transaction model
     * @param model $product_model Product model
     * @param model $user_model User model
     * @param model $vehicle_model Vehicle model
     * 
     */
    public function afterProcessing($card_or_stamps_or_promotion, &$transaction_model, &$product_model, &$user_model, &$vehicle_model) {
        if ((($card_or_stamps_or_promotion == 'card') || ($card_or_stamps_or_promotion == 'promotion')) && $transaction_model->stamps_issued) {//Update stamps only if transaction was processed with card
            //Update loyalty stamps
            $this->updateLoyaltyStamp($transaction_model->location_id, $transaction_model->user_id);
        }//E# if statement
        //Notify merchant
        $this->notifyLocation($card_or_stamps_or_promotion, $transaction_model, $product_model, $user_model, $vehicle_model);

        //Notify user
        $this->notifyUser($card_or_stamps_or_promotion, $transaction_model, $product_model, $user_model, $vehicle_model);
    }

//E# afterProcessing() function

    /**
     * S# notifyUser() function
     * Notify user of a successful transaction
     * 
     * @param string $card_or_stamps_or_promotion Card or loyalty stamps
     * @param model $transaction_model Transaction model
     * @param model $product_model Product model
     * @param model $user_model User model
     * @param model $vehicle_model Vehicle model
     * 
     */
    public function notifyUser($card_or_stamps_or_promotion, &$transaction_model, &$product_model, &$user_model, &$vehicle_model) {
        //Build template
        $template = 'transactionUser' . \Str::title(\Str::lower($card_or_stamps_or_promotion));

        //Transaction date
        $date = Carbon::createFromFormat('Y-m-d G:i:s', $transaction_model->created_at);

        //Message parameters
        $parameters = array(
            'name' => $user_model->first_name . ' ' . $user_model->last_name,
            'tranId' => $transaction_model->id,
            'product' => $product_model->name,
            'productId' => $product_model->id,
            'vrm' => $vehicle_model->vrm,
            'location' => $product_model->location->name,
            'day' => $date->format('d/m/y'),
            'time' => $date->format(' h:i A')
        );
        
        if ($user_model->notify_push && $user_model->push_token && $user_model->os) {//Push
            //Set os to parameters
            $parameters['os'] = $user_model->os;
            
            //Converse
            $sent = $this->callController(\Util::buildNamespace('messages', 'message', 1), 'converse', array('push', null, null, $user_model->id, $user_model->push_token, $template, \Config::get('app.locale'), $parameters));

            $transaction_model->user_pushed = 1;
        }//E# if statement

        if ($user_model->notify_sms && $user_model->phone) {//SMS
            //Converse
            $sent = $this->callController(\Util::buildNamespace('messages', 'message', 1), 'converse', array('sms', null, null, $user_model->id, array($user_model->phone), $template, \Config::get('app.locale'), $parameters));

            $transaction_model->user_smsed = 1;
        }//E# if statement


        if ($user_model->notify_email) {//Email
            //Converse
            $sent = $this->callController(\Util::buildNamespace('messages', 'message', 1), 'converse', array('email', null, null, $user_model->id, $user_model->email, $template, \Config::get('app.locale'), $parameters));

            $transaction_model->user_emailed = 1;
        }//E# if statement
    }

//E# notifyUser() function

    /**
     * S# notifyLocation() function
     * Notify location owner of a successful transaction
     * 
     * @param string $card_or_stamps_or_promotion Card or loyalty stamps
     * @param model $transaction_model Transaction model
     * @param model $product_model Product model
     * @param model $user_model User model
     * @param model $vehicle_model Vehicle model

     * 
     */
    public function notifyLocation($card_or_stamps_or_promotion, &$transaction_model, &$product_model, &$user_model, &$vehicle_model) {
        //Build template
        $template = 'transactionMerchant' . \Str::title(\Str::lower($card_or_stamps_or_promotion));

        //Transaction date
        $date = Carbon::createFromFormat('Y-m-d G:i:s', $transaction_model->created_at);

        //Message parameters
        $parameters = array(
            'name' => $user_model->first_name . ' ' . $user_model->last_name,
            'tranId' => $transaction_model->id,
            'product' => $product_model->name,
            'pdtId' => $product_model->id,
            'currencyId' => $transaction_model->currency_id,
            'amount' => $transaction_model->amount,
            'vrm' => $vehicle_model->vrm,
            'location' => $product_model->location->name,
            'day' => $date->format('d/m/y'),
            'time' => $date->format(' h:i A')
        );

        //Define email recipients
        $email_recipients = array();

        if ($product_model->location->email_1) {//Add email
            $email_recipients[] = $product_model->location->email_1;
        }//E# if statement

        if ($product_model->location->email_2) {//Add email
            $email_recipients[] = $product_model->location->email_2;
        }//E# if statement

        if ($product_model->location->email_3) {//Add email
            $email_recipients[] = $product_model->location->email_3;
        }//E# if statement

        if ($email_recipients) {//Email
            //Converse
            $sent = $this->callController(\Util::buildNamespace('messages', 'message', 1), 'converse', array('email', null, null, $transaction_model->location_id, $email_recipients, $template, \Config::get('app.locale'), $parameters));

            $transaction_model->merchant_emailed = 1;
        }//E# if statement
        //Define sms recipients    
        $sms_recipients = array();

        if ($product_model->location->phone_1) {//Add phone
            $sms_recipients[] = $product_model->location->phone_1;
        }//E# if statement

        if ($product_model->location->phone_2) {//Add phone
            $sms_recipients[] = $product_model->location->phone_2;
        }//E# if statement

        if ($product_model->location->phone_3) {//Add phone
            $sms_recipients[] = $product_model->location->phone_3;
        }//E# if statement 

        if ($sms_recipients) {//SMS
            //Converse
            $sent = $this->callController(\Util::buildNamespace('messages', 'message', 1), 'converse', array('sms', null, null, $transaction_model->location_id, $sms_recipients, $template, \Config::get('app.locale'), $parameters));

            $transaction_model->merchant_smsed = 1;
        }//E# if statement
    }

//E# notifyLocation() function

    /**
     * S# process() function
     * Process trancation with credit card
     */
    public function process() {
        $this->validationRules = array(
            'product_id' => 'required',
            'location' => 'latLng',
            'card_token' => 'required',
            'promotion_id' => 'integer',
            'vehicle_id' => 'required|integer|processTransaction',
        );

        $this->isInputValid();
    }

//E# process() function

    /**
     * S# prepare() function
     * Prepare trancation before processing it with credit card
     */
    public function prepare() {
        $this->validationRules = array(
            'product_id' => 'required|prepareTransaction',
        );

        $this->isInputValid();
    }

//E# prepare() function

    /**
     * transact() function
     * Call the gateway to process the payment
     * 
     * @param string $gateway Gateway
     * @param array $paymentInfo Payment Information
     * 
     * @return Array Gateway response
     */
    public function transact($gateway, $paymentInfo) {
        return $this->callController(\Util::buildNamespace('payments', $gateway, 1), 'createTransaction', array($paymentInfo));
    }

//E# transact() function
}

//E# PaymentController() function