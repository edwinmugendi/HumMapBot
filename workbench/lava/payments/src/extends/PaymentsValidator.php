<?php

namespace Lava\Payments;

use Symfony\Component\Translation\TranslatorInterface;
use Carbon\Carbon;
use Lava\Accounts\VehicleController;
use Lava\Accounts\UserController;
use Lava\Products\ProductController;
use Lava\Merchants\LocationController;
use Lava\Products\PromotionController;

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
     * S# validateProcessTransactionWithStamps() function
     * Validate process transaction with stamps
     * @param array $attribute Validation attribute
     * @param array $value The password
     * @param array $parameters Parameters
     */
    public function validateProcessTransactionWithStamps($attribute, $vrm, $parameters) {

        //Payment controller
        $paymentController = new PaymentController();

        //Product controller
        $productController = new ProductController();

        //Location
        $parameters = array('location');

        //Get product by id
        $productModel = $productController->callController(\Util::buildNamespace('products', 'product', 1), 'getModelByField', array('id', $this->data['product_id'], $parameters));

        if ($productModel) {//Product found
            //Cache location stamps
            $locationStamps = (int) $productModel->location->loyalty_stamps;

            if ($productModel->loyable && $locationStamps) {//Product is loyable
                //User controller
                $userController = new UserController();

                //Get user model by id
                $userModel = $userController->callController(\Util::buildNamespace('accounts', 'user', 1), 'getModelByField', array('token', $this->data['token']));

                //Get loyalty stamps
                $stampModel = $paymentController->getLocationStamps($productModel->location->id, $userModel->id);

                //Cache user stamps
                $userStamps = (int) $stampModel->feeling;

                //Get vehiclel model
                $vehicleModel = $this->validateUserOwnsVrm($attribute, $this->data['vrm'], $parameters);

                if ($vehicleModel) {//User ownes this vrm
                    if ($userStamps >= $locationStamps) {//User has sufficient stamps
                        //Build transaction array
                        $transactionArray = array(
                            'gateway' => 'stamps',
                            'gateway_tran_id' => "0",
                            'gateway_code' => 0,
                            'amount' => $vehicleModel->type == 2 ? $productModel->price_2 : $productModel->price_1,
                            'currency' => $productModel->currency,
                            'description' => \Lang::get($paymentController->package . '::' . $paymentController->controller . '.api.freeStampWash'),
                            'user_id' => $userModel->id,
                            'product_id' => $productModel->id,
                            'location_id' => $productModel->location->id,
                            'vrm' => $this->data['vrm'],
                            'agent' => \Request::server('HTTP_USER_AGENT'),
                            'stamps_issued' => 0,
                            'status' => 2
                        );

                        if ($this->data['location']) {//Set transaction location
                            $transactionArray['lat'] = $this->data['location']['lat'];
                            $transactionArray['lng'] = $this->data['location']['lng'];
                        }//E# if statement
                        //Create transaction
                        $transactionModel = $userController->callController(\Util::buildNamespace('payments', 'transaction', 1), 'createIfValid', array($transactionArray, true));

                        if ($transactionModel) {//Transaction created in the database
                            //Reset the loyalty stamps for this location
                            $stampModel->feeling = 0;

                            //Save stamps
                            $stampModel->save();

                            //After processing
                            $paymentController->afterProcessing('stamps', $transactionModel, $productModel, $userModel);

                            //Build stamps
                            $stamps = array(
                                'issued' => 0,
                                'user_total' => 0,
                                'location_stamps' => $productModel->location->loyalty_stamps
                            );

                            //Build gateway response
                            $gatewayResponse = array(
                                'status' => 1,
                                'message' => \Lang::get($paymentController->package . '::' . $paymentController->controller . '.validation.processTransactionWithStamps.transaction.1')
                            );
                            //Build notification
                            $this->notification = array(
                                'gateway' => $gatewayResponse,
                                'transaction' => $transactionModel->toArray(),
                                'stamps' => $stamps
                            );
                            throw new \Api200Exception($this->notification, $gatewayResponse['message']);
                        } else {//Database error
                            //Set message
                            $this->message = \Lang::get($paymentController->package . '::' . $paymentController->controller . '.validation.processTransactionWithStamps.dbError');

                            //Throw 500 Exception
                            throw new \Api500Exception($this->message);
                        }//E# if else statement
                    } else {//You don't have enough stamps
                        //Set message
                        $this->message = \Lang::get($paymentController->package . '::' . $paymentController->controller . '.validation.processTransactionWithStamps.insufficientStamps', (array('name' => $productModel->name, 'locationStamps' => $locationStamps, 'userStamps' => $userStamps)));

                        return false;
                    }//E# if statement
                } else {//Don't own this vrm
                    //Set notification
                    $paymentController->notification = array(
                        'field' => 'vrm',
                        'type' => 'Vehicle',
                        'value' => $vrm,
                    );

                    //Throw not found error
                    throw new \Api403Exception($paymentController->notification);
                }//E# if statement
            } else {//Product not loyable or location does not have a loyalty stamps
                //Set message
                $this->message = \Lang::get($paymentController->package . '::' . $paymentController->controller . '.validation.processTransactionWithStamps.productNotLoyable', array('name' => $productModel->name));

                return false;
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

//E# validateProcessTransactionWithStamps() function

    /**
     * S# replaceProcessTransactionWithStamps() function
     * Return Process transaction with stamps error message
     * @param $string $message The message
     * @param $string $attribute The attribute
     * @param $string $rule The rule
     * @param array $parameters The parameters
     */
    protected function replaceProcessTransactionWithStamps($message, $attribute, $rule, $parameters) {
        return $this->message;
    }

//E# replaceProcessTransactionWithStamps() function
    /**
     * S# validateProcessTransaction() function
     * Validate process transaction
     * @param array $attribute Validation attribute
     * @param array $value The password
     * @param array $parameters Parameters
     */
    public function validateProcessTransaction($attribute, $vrm, $parameters) {

        //Cache promotion id
        $promotionId = array_key_exists('promotion_id', $this->data) ? $this->data['promotion_id'] : false;

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

            //Get vehiclel model
            $vehicleModel = $this->validateUserOwnsVrm($attribute, $this->data['vrm'], $parameters);

            if ($vehicleModel) {//User owns this vehicle
                //Cache price and surcharge
                $price = $vehicleModel->type == 2 ? $productModel->price_2 : $productModel->price_1;
                $surcharge = $productModel->location->surcharge;

                //Promotion Controller
                $promotionController = new PromotionController();

                if ($promotionId) {//Promotion has been set
                    //Get Promotion model by id
                    $promotionModel = $promotionController->getModelByField('id', $promotionId);

                    if ($promotionModel) {//Promotion model exists
                        //Prepare price
                        $promotionArray = $promotionController->prepareRedeemablePromotions(array($promotionModel->toArray()), $price, $surcharge);

                        //dd($promotionArray);
                        if ($promotionArray && array_key_exists('price', $promotionArray[0])) {//Price is set
                            $amount = $promotionArray[0]['price'];
                        }//E# if statement
                    }//E# if statement
                }//E# if statement

                if (!isset($amount)) {//Amount is not set
                    $amount = round((floatval($price) + floatval($surcharge)), 2);
                }//E# if statement

                if (!floatval($price)) {
                    $amount = 0;
                }

                $transactionArray = array();

                if ($this->data['location']) {//Set transaction location
                    $transactionArray['lat'] = $this->data['location']['lat'];
                    $transactionArray['lng'] = $this->data['location']['lng'];
                }//E# if statement
                //Set other fields
                $transactionArray['vrm'] = $this->data['vrm'];
                $transactionArray['user_id'] = $userModel->id;
                $transactionArray['description'] = $productModel->name . ' ' . $productModel->location->name;
                $transactionArray['product_id'] = $productModel->id;
                $transactionArray['location_id'] = $productModel->location->id;
                $transactionArray['agent'] = \Request::server('HTTP_USER_AGENT');
                $transactionArray['amount'] = $amount;
                $transactionArray['currency'] = $productModel->location->currency;
                $transactionArray['stamps_issued'] = ((int) $productModel->location->loyalty_stamps) ? 1 : 0;

                if ($amount) {//Amount is greater than 0
                    $paymentInfo = array(
                        'app55UserId' => $userModel->app55_id,
                        'cardToken' => $this->data['card_token'],
                        'amount' => $amount,
                        'currency' => $productModel->location->currency,
                        'description' => $this->data['product_id']
                    );

                    //Set the gateway
                    $transactionArray['gateway'] = $gateway = 'app55';

                    //Attempt to transaction
                    $transactionResponse = $paymentController->transact($gateway, $paymentInfo);


                    if ($transactionResponse['status']) {//Gateway transaction succeeded
                        //Prepare transaction
                        $gatewayResponse = $paymentController->prepareTransactionArray($gateway, $transactionResponse['status'], $transactionResponse['response']);
                        //Merge transaction and gateway response
                        $transactionArray = array_merge($transactionArray, $gatewayResponse);
                        //Set promotion id
                        $transactionArray['promotion_id'] = $promotionId ? $promotionId : 0;
                    } else {//Gateway transaction failed
                        //Prepare transaction
                        $gatewayResponse = $paymentController->prepareTransactionArray($gateway, $transactionResponse['status'], $transactionResponse['response']);

                        //Merge transaction and gateway response
                        $transactionArray = array_merge($transactionArray, $gatewayResponse);
                        //Set stamp
                        $transactionArray['stamps_issued'] = 0;
                    }//E# if else statement
                    //Set card
                    $transactionArray['card_used'] = $userController->callController(\Util::buildNamespace('payments', 'card', 1), 'getVerbativeCardUsed', array($this->data['card_token']));
                    $transactionArray['card_token'] = $this->data['card_token'];
                } else {
                    $transactionArray['gateway'] = 'promotion';
                    $transactionArray['status'] = 3;
                }//E# if else statement
                //Create transaction
                $transactionModel = $userController->callController(\Util::buildNamespace('payments', 'transaction', 1), 'createIfValid', array($transactionArray, true));

                if ($transactionModel) {//Transaction created
                    if ($amount) {//Amount is greater than 0
                        if ($transactionResponse['status']) {
                            //After processing
                            $paymentController->afterProcessing('card', $transactionModel, $productModel, $userModel);

                            //Build gateway response
                            $gatewayResponse = array(
                                'status' => 1,
                                'message' => \Lang::get($paymentController->package . '::' . $paymentController->controller . '.validation.processTransaction.transaction.1')
                            );

                            if ($promotionId) {//Promotion id
                                //Redeem the promotion
                                $userController->updatePivotTable($userModel, 'promotions', $promotionId, array('redeemed' => 1, 'transaction_id' => $transactionModel->id, 'updated_at' => Carbon::now()));
                            }//E# if statement
                        } else {
                            //Build gateway response
                            $gatewayResponse = array(
                                'status' => 0,
                                'message' => \Lang::get($paymentController->package . '::' . $paymentController->controller . '.validation.processTransaction.transaction.0')
                            );
                        }//E# if else statement
                    } else {
                        //After processing
                        $paymentController->afterProcessing('promotion', $transactionModel, $productModel, $userModel);

                        //Build gateway response
                        $gatewayResponse = array(
                            'status' => 1,
                            'message' => \Lang::get($paymentController->package . '::' . $paymentController->controller . '.validation.processTransaction.transaction.1')
                        );

                        if ($promotionId) {//Promotion id
                            //Redeem the promotion
                            $userController->updatePivotTable($userModel, 'promotions', $promotionId, array('redeemed' => 1, 'transaction_id' => $transactionModel->id, 'updated_at' => Carbon::now()));
                        }//E# if statement
                    }//E# if else statement
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
                        'gateway' => $gatewayResponse,
                        'transaction' => $transactionModel->toArray(),
                        'stamps' => $stamps
                    );

                    throw new \Api200Exception($this->notification, $gatewayResponse['message']);
                } else {//DB error
                    //Set message
                    $this->message = \Lang::get($paymentController->package . '::' . $paymentController->controller . '.validation.processTransaction.dbError');

                    //Throw 500 Exception
                    throw new \Api500Exception($this->message);
                }//E# if else statement
            } else {//Don't own this vrm
                //Set notification
                $paymentController->notification = array(
                    'field' => 'vrm',
                    'type' => 'Vehicle',
                    'value' => $vrm,
                );

                //Throw not found error
                throw new \Api403Exception($paymentController->notification);
            }//E# if statement
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
                            $userController->notification['card'] = array_only($singleCard->toArray(), array('name', 'number', 'expiry', 'token'));
                            break;
                        }//E# if statement
                    }//E# foreach statement

                    if (!$defaultCardFound) {//Set default card as the last added card
                        $userController->notification['card'] = array_only($userModel->cards[((int) $userModel->cards->count() - 1)]->toArray(), array('name', 'number', 'expiry', 'token'));
                    }//E# if statement
                    //VRM
                    $userController->notification['vehicle'] = array(
                        'vrm' => $vehicleModel->vrm,
                        'type' => $vehicleModel->type
                    );

                    /*
                      $userController->notification['product'] = array(
                      'id' => $productModel->id,
                      'price' => ((int)$vehicleModel->type == 2)  ? $productModel->price_2 : $productModel->price_1,
                      );
                     */
                    //PROMOTIONS
                    $promotions = array();
                    $amount = ((int) $vehicleModel->type == 2) ? $productModel->price_2 : $productModel->price_1;

                    $surcharge = $productModel->location->surcharge;

                    if ($userModel->unredeemed_promotions) {//Promotions exist
                        //Get promotions
                        $promotions = $productController->callController(\Util::buildNamespace('products', 'promotion', 1), 'locationRedeemablePromotions', array($productModel->location->id, $userModel->unredeemed_promotions->toArray(), $amount, $surcharge));
                    }//E# if statement
                    //Build transaction
                    $transaction = array(
                        'amount' => $amount,
                        'currency' => $productModel->location->currency,
                        'surcharge' => $surcharge,
                        'promotions' => $promotions,
                    );

                    $userController->notification['transaction'] = $transaction;

                    //GET MERCHANT
                    //Location controller
                    $locationController = new LocationController();

                    $parameters['lazyLoad'] = array('merchant');

                    //Get location by id
                    $locationModel = $locationController->callController(\Util::buildNamespace('merchants', 'location', 1), 'getModelByField', array('id', $productModel->location_id, $parameters));

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
