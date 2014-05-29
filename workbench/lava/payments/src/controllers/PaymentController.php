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
    
    
    public function getLocationStamps($locationId,$userId){
        //Fields to select
        $fields = array('*');

        //Build where clause
        $whereClause = array(
            array(
                'where' => 'where',
                'column' => 'user_id',
                'operator' => '=',
                'operand' => $userId
            ),
            array(
                'where' => 'where',
                'column' => 'location_id',
                'operator' => '=',
                'operand' => $locationId
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
    /**
     * S# updateLoyaltyStamp() function
     * Update users loyalty stamp
     * 
     * @param integer $locationId Location id
     * @param integer $userId User id
     * 
     */
    private function updateLoyaltyStamp($locationId, $userId) {
        //Get Loyalty stamp
        $feelModel = $this->getLocationStamps($locationId, $userId);
        
        if ($feelModel) {//Stamp exists
            //Increment stamp by one
            $feelModel->feeling = ((int) $feelModel->feeling + 1);

            //Save stamps
            $feelModel->save();
        } else {//Stamp does not exist
            //Define feeling array
            $feelArray = array(
                'user_id' => $userId,
                'location_id' => $locationId,
                'feeling' => 1,
                'type' => 4
            );

            //Create users stamp
            $this->callController(\Util::buildNamespace('merchants', 'feel', 1), 'createIfValid', array($feelArray, true));
        }//E# if else statement
    }

//E# updateLoyaltyStamp() function

    public function afterProcessing(&$transactionModel, &$productModel, &$userModel) {
        //Update loyalty stamps
        $this->updateLoyaltyStamp($transactionModel->location_id, $transactionModel->user_id);

        //Notify merchant
        $this->notifyLocation($transactionModel, $productModel, $userModel);

        //Notify user
        $this->notifyUser($transactionModel, $productModel, $userModel);
    }

    public function notifyUser(&$transactionModel, &$productModel, &$userModel) {

        //Transaction date
        $date = Carbon::createFromFormat('Y-m-d G:i:s', $transactionModel->created_at);

        //Message parameters
        $parameters = array(
            'name' => $userModel->first_name . ' ' . $userModel->last_name,
            'tranId' => $transactionModel->id,
            'product' => $productModel->name,
            'productId' => $productModel->id,
            'vrm' => $transactionModel->vrm,
            'location' => $productModel->location->name,
            'day' => $date->format('d/m/y'),
            'time' => $date->format(' h:i A')
        );
        if ($userModel->notify_push && $userModel->push_token && $userModel->os) {//Push
            //Set os to parameters
            $parameters['os'] = $userModel->os;
            //Converse
            $sent = $this->callController(\Util::buildNamespace('messages', 'message', 1), 'converse', array('push', null, null, $userModel->id, $userModel->push_token, 'transactionUser', \Config::get('app.locale'), $parameters));
        }//E# if statement

        if ($userModel->notify_sms && $userModel->phone) {//SMS
            //Converse
            $sent = $this->callController(\Util::buildNamespace('messages', 'message', 1), 'converse', array('sms', null, null, $userModel->id, array($userModel->phone), 'transactionUser', \Config::get('app.locale'), $parameters));
        }//E# if statement


        if ($userModel->notify_email) {//Email
            //Converse
            $sent = $this->callController(\Util::buildNamespace('messages', 'message', 1), 'converse', array('email', null, null, $userModel->id, $userModel->email, 'transactionUser', \Config::get('app.locale'), $parameters));
        }//E# if statement
    }

//E# notifyUser() function

    public function notifyLocation(&$transactionModel, &$productModel, &$userModel) {
        //Transaction date
        $date = Carbon::createFromFormat('Y-m-d G:i:s', $transactionModel->created_at);

        //Message parameters
        $parameters = array(
            'name' => $userModel->first_name . ' ' . $userModel->last_name,
            'tranId' => $transactionModel->id,
            'product' => $productModel->name,
            'pdtId' => $productModel->id,
            'currency' => $transactionModel->currency,
            'amount' => $transactionModel->amount,
            'vrm' => $transactionModel->vrm,
            'location' => $productModel->location->name,
            'day' => $date->format('d/m/y'),
            'time' => $date->format(' h:i A')
        );

        //Define email recipients
        $emailRecipients = array();

        if ($productModel->location->email_1) {//Add email
            $emailRecipients[] = $productModel->location->email_1;
        }//E# if statement

        if ($productModel->location->email_2) {//Add email
            $emailRecipients[] = $productModel->location->email_2;
        }//E# if statement

        if ($productModel->location->email_3) {//Add email
            $emailRecipients[] = $productModel->location->email_3;
        }//E# if statement

        if ($emailRecipients) {//Email
            //Converse
            $sent = $this->callController(\Util::buildNamespace('messages', 'message', 1), 'converse', array('email', null, null, $transactionModel->location_id, $emailRecipients, 'transactionMerchant', \Config::get('app.locale'), $parameters));
        }//E# if statement
        //Define sms recipients    
        $smsRecipients = array();

        if ($productModel->location->phone_1) {//Add phone
            $smsRecipients[] = $productModel->location->phone_1;
        }//E# if statement

        if ($productModel->location->phone_2) {//Add phone
            $smsRecipients[] = $productModel->location->phone_2;
        }//E# if statement

        if ($productModel->location->phone_3) {//Add phone
            $smsRecipients[] = $productModel->location->phone_3;
        }//E# if statement 

        if ($smsRecipients) {//SMS
            //Converse
            $sent = $this->callController(\Util::buildNamespace('messages', 'message', 1), 'converse', array('sms', null, null, $transactionModel->location_id, $smsRecipients, 'transactionMerchant', \Config::get('app.locale'), $parameters));
        }//E# if statement
    }

    public function process() {
        $this->validationRules = array(
            'product_id' => 'required',
            'location' => 'latLng',
            'card_token' => 'required',
            'amount' => 'required',
            'currency' => 'required',
            'promotion_id' => 'integer',
            'vrm' => 'required|processTransaction',
        );

        $this->isInputValid();
    }

    /**
     * 
     */
    public function prepare() {
        $this->validationRules = array(
            'vrm' => 'integer',
            'product_id' => 'required|prepareTransaction',
        );

        $this->isInputValid();
    }

    public function transact($gateway, $paymentInfo) {
        return $this->callController(\Util::buildNamespace('payments', $gateway, 1), 'createTransaction', array($paymentInfo));
    }

    public function prepareTransactionArray($gateway, $gatewayTransaction) {
        return $this->callController(\Util::buildNamespace('payments', $gateway, 1), 'prepareTransactionArray', array($gatewayTransaction));
    }

}

//E# PaymentController() function