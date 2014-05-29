<?php

namespace Lava\Payments;

use Symfony\Component\Translation\TranslatorInterface;
use Carbon\Carbon;
use Lava\Accounts\VehicleController;
use Lava\Accounts\UserController;
use Lava\Products\ProductController;
use Lava\Merchants\LocationController;

/**
 * S# PaymentsValidator() function
 * Payments Validator
 * @author Edwin Mugendi
 * @todo We are extending the Messages Validator because PHP does not offer multiple inheritance. We extend alphabetically
 */
class PaymentsValidator extends \Lava\Messages\MessagesValidator {

    //Message object
    private $message;

    /**
     * S# validateProcessTransaction() function
     * Validate process transaction
     * @param array $attribute Validation attribute
     * @param array $value The password
     * @param array $parameters Parameters
     */
    public function validateProcessTransaction($attribute, $vrm, $parameters) {
        //TODO: Send SMS to merchant
        //TODO: Send email to merchant
        //TODO: Send SMS to consumer
        //TODO: Send push to consumer
        //TODO: Send email to consumer
        //TODO: Save loyalty stamps by location
        //Product controller
        $productController = new ProductController();

        //Location
        $parameters = array('location');

        //Get product by id
        $productModel = $productController->callController(\Util::buildNamespace('products', 'product', 1), 'getModelByField', array('id', $this->data['product_id'], $parameters));

        if ($productModel) {//Product found
            //User controller
            $userController = new UserController();

            //Get user model by id
            $userModel = $userController->callController(\Util::buildNamespace('accounts', 'user', 1), 'getModelByField', array('token', $this->data['token']));

            //Payment controller
            $paymentController = new PaymentController();

            $paymentInfo = array(
                'app55UserId' => $userModel->app55_id,
                'cardToken' => $this->data['card_token'],
                'amount' => $this->data['amount'],
                'currency' => $this->data['currency'],
                'description' => $this->data['product_id']
            );

            $gateway = 'app55';

            //Attempt to transaction
            $transactionResponse = $paymentController->transact($gateway, $paymentInfo);

            if ($transactionResponse['status']) {//Transaction succeeded
                $transactionArray = $paymentController->prepareTransactionArray($gateway, $transactionResponse['response']);

                $transactionArray['user_id'] = $userModel->id;
                $transactionArray['product_id'] = $productModel->id;
                $transactionArray['location_id'] = $productModel->location->id;

                if ($this->data['location']) {//Set transaction location
                    $transactionArray['lat'] = $this->data['location']['lat'];
                    $transactionArray['lng'] = $this->data['location']['lng'];
                }//E# if statement

                if ($this->data['promotion_id']) {//Promotion id
                    $transactionArray['promotion_id'] = $this->data['promotion_id'];

                    //Redeem the promotion
                    $userController->updatePivotTable($userModel, 'promotions', $this->data['promotion_id'], array('redeemed' => 1));
                }//E# if statement
                //Set transaction vrm
                $transactionArray['vrm'] = $this->data['vrm'];

                //Set agent
                $transactionArray['agent'] = \Request::server('HTTP_USER_AGENT');

                //Build card used
                $transactionArray['card_used'] = $userController->callController(\Util::buildNamespace('payments', 'card', 1), 'getVerbativeCardUsed', array($this->data['card_token']));

                //Set card token
                $transactionArray['card_token'] = $this->data['card_token'];

                //Set card token
                $transactionArray['stamps_issued'] = 1;

                //Create transaction
                $transactionModel = $userController->callController(\Util::buildNamespace('payments', 'transaction', 1), 'createIfValid', array($transactionArray, true));

                if ($transactionModel) {
                    //After processing
                    $paymentController->afterProcessing($transactionModel, $productModel, $userModel);

                    //Get loyalty stamps
                    $stampModel = $paymentController->getLocationStamps($transactionModel->location_id, $userModel->id);

                    //Build stamps 
                    $stamps = array(
                        'issued' => (int) $transactionModel->stamps_issued,
                        'user_total' => $stampModel ? (int) $stampModel->feeling : 0,
                        'location_stamps' => (int) $productModel->location->loyalty_stamps
                    );

                    //Build notification
                    $this->notification = array(
                        'transaction' => $transactionModel->toArray(),
                        'stamps' => $stamps
                    );
                    throw new \Api200Exception($this->notification, array('id'));
                } else {
                    //TODO 500 error
                }//E# if else statement
            } else {
                
            }//E# if else statement
            dd($transactionResponse);
        } else {//No such product
            //Set notification
            $productController->notification = array(
                'field' => 'id',
                'type' => 'Product',
                'value' => $this->data['product_id'],
            );

            //Throw product id not found error
            throw new \Api404Exception($productController->notification);
        }//E# if else statement

        return false;
    }

//E# validateProcessTransaction() function
    /**
     * S# replaceProcessTransaction() function
     * Replace status parameter in login validaion string
     * @param $string $message The message
     * @param $string $attribute The attribute
     * @param $string $rule The rule
     * @param array $parameters The parameters
     */
    protected function replaceProcessTransaction($message, $attribute, $rule, $parameters) {
        return $this->message;
    }

//E# replaceProcessTransaction() function

    /**
     * S# validatePrepareTransaction() function
     * Validate prepare transaction
     * @param array $attribute Validation attribute
     * @param array $value The password
     * @param array $parameters Parameters
     */
    public function validatePrepareTransaction($attribute, $productId, $parameters) {
        //TODO: get default card details
        //TODO: Get promotions
        //TODO: Calculate price
        //TODO: Check surcharge
        //Get user model by id
        //product controller
        $productController = new ProductController();

        $parameters = array('merchant');

        //Get product by id
        $productModel = $productController->callController(\Util::buildNamespace('products', 'product', 1), 'getModelByField', array('id', $this->data['product_id']));

        if ($productModel) {//Product found
            //User controller
            $userController = new UserController();

            //Parameters
            $parameters = array('cards', 'unredeemed_promotions');

            //Get user model by id
            $userModel = $userController->callController(\Util::buildNamespace('accounts', 'user', 1), 'getModelByField', array('token', $this->data['token'], $parameters));

            $vrm = '';
            if (isset($this->data['vrm'])) {
                //Get vehiclel model
                $vehicleModel = $this->validateUserOwnsVrm($attribute, $this->data['vrm'], $parameters);

                //Set vrm
                $vrm = $this->data['vrm'];
            } else {
                //Get vehicle model
                $vehicleModel = $userController->callController(\Util::buildNamespace('accounts', 'vehicle', 1), 'getModelByField', array('vrm', $userModel->vrm));

                //Set vrm
                $vrm = $userModel->vrm;
            }//E# if else statement

            if ($vehicleModel) {//Vehicle exists
                if ($userModel->cards->count()) {//User has cards
                    $defaultCardFound = false;
                    foreach ($userModel->cards as $singleCard) {
                        if ($singleCard->token == $userModel->card) {//User has specified a default card
                            $defaultCardFound = true;
                            $userController->notification['card'] = $singleCard->toArray();
                            break;
                        }//E# if statement
                    }//E# foreach statement

                    if (!$defaultCardFound) {//Set default card as the last added card
                        $userController->notification['card'] = $userModel->cards[((int) $userModel->cards->count() - 1)]->toArray();
                    }//E# if statement
                    //CHECK PROMOTIONS
                    if ($userModel->unredeemed_promotions) {
                        foreach ($userModel->unredeemed_promotions as $singlePromotion) {
                            $userController->notification['promotions'][] = array_only($singlePromotion->toArray(), array('id', 'type', 'value'));
                        }//E# foreach statement
                    } else {
                        $userController->notification['promotions'] = array();
                    }//E# if else statement
                    //VRM
                    $userController->notification['vehicle'] = array(
                        'vrm' => $vehicleModel->vrm,
                        'type' => $vehicleModel->type
                    );

                    //PRODUCT
                    $userController->notification['product'] = array(
                        'id' => $productModel->id,
                        'price_4X2' => $productModel->price_4X2,
                        'price_4X4' => $productModel->price_4X4
                    );

                    //PROMOTIONS
                    $promotions = array();
                    if ($userModel->unredeemed_promotions) {//Promotions exist
                        foreach ($userModel->unredeemed_promotions->toArray() as $singlePromotion) {
                            $promotions[] = array_except($singlePromotion, array('claimed','pivot'));
                        }//E# foreach statement
                    }//E# if statement
                    $userController->notification['promotions'] = $promotions;

                    //GET MERCHANT
                    //Location controller
                    $locationController = new LocationController();

                    $parameters['lazyLoad'] = array('merchant');

                    //Get location by id
                    $locationModel = $locationController->callController(\Util::buildNamespace('merchants', 'location', 1), 'getModelByField', array('id', $productModel->location_id, $parameters));

                    //Surcharge
                    if ($locationModel->merchant->surcharge) {//Merchant has surcharge
                        $userController->notification['transaction'] = array(
                            'surcharge' => $locationModel->merchant->surcharge,
                            'currency' => $locationModel->merchant->currency
                        );
                    } else {
                        $userController->notification['transaction'] = array(
                            'surcharge' => $locationModel->merchant->surcharge,
                            'currency' => 0
                        );
                    }//E# if else statement
                    //Get success message
                    $message = \Lang::get('payments::payment.api.prepareTransaction');

                    throw new \Api200Exception($userController->notification, $message);
                } else {
                    //Set error message
                    $this->message = \Lang::get('payments::payment.validation.prepareTransaction.noCard');
                }
            } else {//User don't own this car
                //Set message
                $this->message = \Lang::get('accounts::vehicle.validation.userOwns', array('vrm' => $vrm));
            }//E# if else statement
        } else {//No such product
            //Set notification
            $productController->notification = array(
                'field' => 'id',
                'type' => 'Product',
                'value' => $this->data['product_id'],
            );

            //Throw product id not found error
            throw new \Api404Exception($productController->notification);
        }//E# if else statement

        return false;
    }

//E# validatePrepareTransaction() function
    /**
     * S# replacePrepareTransaction() function
     * Replace status parameter in login validaion string
     * @param $string $message The message
     * @param $string $attribute The attribute
     * @param $string $rule The rule
     * @param array $parameters The parameters
     */
    protected function replacePrepareTransaction($message, $attribute, $rule, $parameters) {
        return $this->message;
    }

//E# replacePrepareTransaction() function
}
