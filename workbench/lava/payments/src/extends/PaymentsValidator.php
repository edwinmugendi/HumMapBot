<?php

namespace Lava\Payments;

use Symfony\Component\Translation\TranslatorInterface;
use Carbon\Carbon;
use Lava\Accounts\UserController;
use Lava\Products\ProductController;
use Lava\Merchants\LocationController;
use Lava\Products\PromotionController;
use Lava\Payments\TransactionController;

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
     * S# validateDeleteCard() function
     * Validate Id Delete
     * @param array $attribute Validation attribute
     * @param boolean $id The id
     * @param array $parameters Parameters
     */
    public function validateDeleteCard($attribute, $id, $parameters) {
        //Create card controller
        $cardController = new \Lava\Payments\CardController();

        //Set scope
        $parameters['scope'] = array('statusOne');

        //Get card by id
        $card_model = $cardController->getModelByField('id', $id, $parameters);

        if ($card_model) {//Card does not exist
            //Instantiate a new user controller
            $user_controller = new UserController();

            //Get user model by token
            $user_model = $user_controller->getModelByField('token', $this->data['token']);

            if ($card_model->created_by == $user_model->id) {

                //Delete card on stripe
                $stripe_controller = new \Lava\Payments\StripeController();
                $stripe_response = $stripe_controller->deleteCard($user_model->stripe_id, $card_model->card_token);
                $card_model->deleted_on_stripe = $stripe_response['status'] ? 1 : 0;

                $card_model->status = 2;
                $card_model->save();

                if ($card_model->card_token == $user_model->card_id) {
                    $user_model->card_id = '';

                    $user_model->save();
                }//E# if statement
                //Get success message
                $message = \Lang::get($cardController->package . '::' . $cardController->controller . '.notification.deleted');

                throw new \Api200Exception(array('id' => $card_model->id, 'id' => $id), $message);
            }
        }//E# if statement
        //Set notification
        $cardController->notification = array(
            'field' => 'id',
            'type' => 'Card',
            'value' => $id,
        );

        //Throw VRM not found error
        throw new \Api404Exception($cardController->notification);

        return false;
    }

//E# validateDeleteCard() function

    /**
     * S# replaceDeleteCard() function
     * Replace status parameter in login validaion string
     * @param $string $message The message
     * @param $string $attribute The attribute
     * @param $string $rule The rule
     * @param array $parameters The parameters
     */
    protected function replaceDeleteCard($message, $attribute, $rule, $parameters) {
        return $this->message;
    }

//E# replaceDeleteCard() function

    /**
     * S# calculateDistance() function
     * Calculate distance between 2 coordinates
     * @param type $lat1 latitude 1
     * @param type $lon1 longitude 1
     * @param type $lat2 latitude 2
     * @param type $lon2 longitude 2
     * @param type $unit N = Nautical miles, K = Kilometre, M = miles
     * 
     * @return float
     */
    function calculateDistance($lat1, $lon1, $lat2, $lon2, $unit) {

        $theta = $lon1 - $lon2;

        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));

        $dist = acos($dist);

        $dist = rad2deg($dist);

        $miles = $dist * 60 * 1.1515;

        $unit = strtoupper($unit);

        if ($unit == 'K') {
            return ($miles * 1.609344);
        } else if ($unit == 'N') {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

//E# if statement

    /**
     * S# validateProcessTransactionWithStamps() function
     * Validate process transaction with stamps
     * @param array $attribute Validation attribute
     * @param array $value The password
     * @param array $parameters Parameters
     */
    public function validateProcessTransactionWithStamps($attribute, $vehicle_id, $parameters) {

        //Payment controller
        $payment_controller = new PaymentController();

        //Product controller
        $product_controller = new ProductController();

        //Location
        $parameters = array('location', 'merchant');

        //Get product by id
        $product_model = $product_controller->callController(\Util::buildNamespace('products', 'product', 1), 'getModelByField', array('id', $this->data['product_id'], $parameters));

        if ($product_model && $product_model->location && $product_model->merchant) {//Product found
            //Calculate Distance
            $distance = $this->calculateDistance($this->data['location']['lat'], $this->data['location']['lng'], $product_model->location->lat, $product_model->location->lng, 'K');

            if ($distance <= 0.5) {//Within 500 meters
                //Cache location stamps
                $location_stamps = (int) $product_model->location->loyalty_stamps;

                if ($product_model->loyable && $location_stamps) {//Product is loyable
                    //User controller
                    $user_controller = new UserController();

                    //Get user model by id
                    $user_model = $user_controller->callController(\Util::buildNamespace('accounts', 'user', 1), 'getModelByField', array('token', $this->data['token']));

                    //Get loyalty stamps
                    $stamp_model = $payment_controller->getLocationStamps($product_model->location->id, $user_model->id);

                    //Cache user stamps
                    $user_stamps = $stamp_model ? $stamp_model->feeling : 0;

                    //Get vehiclel model
                    $vehicle_model = $this->validateUserOwnsVehicle($attribute, $this->data['vehicle_id'], $parameters);

                    if ($vehicle_model) {//User ownes this vehicle_id
                        if ($user_stamps >= $location_stamps) {//User has sufficient stamps
                            //Build transaction array
                            $transaction_array = array(
                                'transaction_date' => Carbon::now(),
                                'vehicle_id' => $vehicle_model->id,
                                'vrm' => $vehicle_model->vrm,
                                'gateway' => 'stamps',
                                'amount' => $vehicle_model->type == 2 ? $product_model->price_2 : $product_model->price_1,
                                'currency_id' => $product_model->location->currency_id_text,
                                'description' => \Lang::get($payment_controller->package . '::' . $payment_controller->controller . '.api.freeStampWash'),
                                'user_id' => $user_model->id,
                                'product_id' => $product_model->id,
                                'location_id' => $product_model->location->id,
                                'vehicle_id' => $this->data['vehicle_id'],
                                'ip' => $user_controller->input['ip'],
                                'agent' => $user_controller->input['agent'],
                                'merchant_id' => $product_model->merchant->id,
                                'stamps_issued' => 0,
                                'user_smsed' => 0,
                                'user_emailed' => 0,
                                'user_pushed' => 0,
                                'merchant_smsed' => 0,
                                'merchant_emailed' => 0,
                                'status' => 1,
                                'created_by' => $user_model->id,
                                'updated_by' => $user_model->id,
                                'workflow' => 5, //Stamps
                            );

                            if ($this->data['location']) {//Set transaction location
                                $transaction_array['lat'] = $this->data['location']['lat'];
                                $transaction_array['lng'] = $this->data['location']['lng'];
                            }//E# if statement
                            //Create transaction
                            $transaction_model = $user_controller->callController(\Util::buildNamespace('payments', 'transaction', 1), 'createIfValid', array($transaction_array, true));

                            if ($transaction_model) {//Transaction created in the database
                                //Reset the loyalty stamps for this location
                                $stamp_model->feeling = 0;

                                //Save stamps
                                $stamp_model->save();

                                //After processing
                                $payment_controller->afterProcessing('stamps', $transaction_model, $product_model, $user_model, $vehicle_model);

                                //Save transaction
                                $transaction_model->save();

                                //Build stamps
                                $stamps = array(
                                    'issued' => 0,
                                    'user_total' => 0,
                                    'location_stamps' => $product_model->location->loyalty_stamps
                                );

                                //Build gateway response
                                $gateway_response = array(
                                    'status' => 1,
                                    'message' => \Lang::get($payment_controller->package . '::' . $payment_controller->controller . '.validation.processTransactionWithStamps.transaction.1')
                                );
                                //Build notification
                                $this->notification = array(
                                    'gateway' => $gateway_response,
                                    'transaction' => $transaction_model->toArray(),
                                    'stamps' => $stamps
                                );
                                throw new \Api200Exception($this->notification, $gateway_response['message']);
                            } else {//Database error
                                //Set message
                                $this->message = \Lang::get($payment_controller->package . '::' . $payment_controller->controller . '.validation.processTransactionWithStamps.dbError');

                                //Throw 500 Exception
                                throw new \Api500Exception($this->message);
                            }//E# if else statement
                        } else {//You don't have enough stamps
                            //Set message
                            $this->message = \Lang::get($payment_controller->package . '::' . $payment_controller->controller . '.validation.processTransactionWithStamps.insufficientStamps', (array('name' => $product_model->name, 'locationStamps' => $location_stamps, 'userStamps' => $user_stamps)));

                            return false;
                        }//E# if statement
                    } else {//Don't own this vehicle_id
                        //Set notification
                        $payment_controller->notification = array(
                            'field' => 'vehicle_id',
                            'type' => 'Vehicle',
                            'value' => $vehicle_id,
                        );

                        //Throw not found error
                        throw new \Api404Exception($payment_controller->notification);
                    }//E# if statement
                } else {//Product not loyable or location does not have a loyalty stamps
                    //Set message
                    $this->message = \Lang::get($payment_controller->package . '::' . $payment_controller->controller . '.validation.processTransactionWithStamps.productNotLoyable', array('name' => $product_model->name));

                    return false;
                }//E# if else statement
            } else {

                //Set notification
                $payment_controller->notification = array(
                    'field' => 'gps',
                    'type' => 'Distance',
                    'value' => 'Invalid',
                );

                //Set message
                $this->message = \Lang::get($payment_controller->package . '::' . $payment_controller->controller . '.validation.processTransactionWithStamps.notNearEnough');

                //Throw 403 error
                throw new \Api403Exception($payment_controller->notification, $this->message);
            }//E# if else statement
        } else {//No such product
            //Set notification
            $product_controller->notification = array(
                'field' => 'id',
                'type' => 'Product',
                'value' => $this->data['product_id'],
            );

            //Throw product id not found error
            throw new \Api404Exception($product_controller->notification);
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
    public function validateProcessTransaction($attribute, $vehicle_id, $parameters) {

        //Cache promotion id
        $promotion_id = array_key_exists('promotion_id', $this->data) ? $this->data['promotion_id'] : false;

        //Payment controller
        $payment_controller = new PaymentController();

        //Product controller
        $product_controller = new ProductController();

        //Transaction controller
        $transaction_controller = new TransactionController();

        //Location
        $parameters = array('location', 'merchant');

        //Get product by id
        $product_model = $product_controller->callController(\Util::buildNamespace('products', 'product', 1), 'getModelByField', array('id', $this->data['product_id'], $parameters));

        if ($product_model && $product_model->location && $product_model->merchant) {//Product found
            //Calculate Distance
            $distance = $this->calculateDistance($this->data['location']['lat'], $this->data['location']['lng'], $product_model->location->lat, $product_model->location->lng, 'K');

            if ($distance <= 0.5) {//Within range
                //User controller
                $user_controller = new UserController();

                //Get user model by id
                $user_model = $user_controller->callController(\Util::buildNamespace('accounts', 'user', 1), 'getModelByField', array('token', $this->data['token']));

                //Get vehiclel model
                $vehicle_model = $this->validateUserOwnsVehicle($attribute, $this->data['vehicle_id'], $parameters);

                if ($vehicle_model) {//User owns this vehicle
                    //Cache price and surcharge
                    $price = $vehicle_model->type == 2 ? $product_model->price_2 : $product_model->price_1;
                    $surcharge = $product_model->location->surcharge;

                    //Promotion Controller
                    $promotion_controller = new PromotionController();

                    if ($promotion_id) {//Promotion has been set
                        //Get Promotion model by id
                        $promotion_model = $promotion_controller->getModelByField('id', $promotion_id);

                        if ($promotion_model) {//Promotion model exists
                            //Prepare price
                            $promotion_array = $promotion_controller->prepareRedeemablePromotions(array($promotion_model->toArray()), $price, $surcharge);

                            if ($promotion_array && array_key_exists('price', $promotion_array[0])) {//Price is set
                                $amount = $promotion_array[0]['price'];
                            }//E# if statement
                        }//E# if statement
                    }//E# if statement

                    if (!isset($amount)) {//Amount is not set
                        $amount = round((floatval($price) + floatval($surcharge)), 2);
                    }//E# if statement

                    if (!floatval($price)) {
                        $amount = 0;
                    }//E# if statement
                    //Transaction array
                    $transaction_array = array(
                        'transaction_date' => Carbon::now(),
                        //Set other fields
                        'vehicle_id' => $this->data['vehicle_id'],
                        'vrm' => $vehicle_model->vrm,
                        'user_id' => $user_model->id,
                        'description' => $product_model->name . ' ' . $product_model->location->name,
                        'product_id' => $product_model->id,
                        'location_id' => $product_model->location->id,
                        'amount' => $amount,
                        'currency_id' => $product_model->location->currency_id_text,
                        'stamps_issued' => ((int) $product_model->location->loyalty_stamps) ? 1 : 0,
                        'merchant_id' => $product_model->merchant->id,
                        'user_smsed' => 0,
                        'user_emailed' => 0,
                        'user_pushed' => 0,
                        'merchant_smsed' => 0,
                        'merchant_emailed' => 0,
                        'workflow' => 1, //Started
                        'ip' => $user_controller->input['ip'],
                        'agent' => $user_controller->input['agent'],
                        'status' => 1,
                        'created_by' => $user_controller->user['id'],
                        'updated_by' => $user_controller->user['id'],
                    );

                    //Create transaction
                    $transaction_model = $transaction_controller->createIfValid($transaction_array, true);

                    if ($this->data['location']) {//Set transaction location
                        $transaction_model->lat = $this->data['location']['lat'];
                        $transaction_model->lng = $this->data['location']['lng'];
                    }//E# if statement

                    if ($amount) {//Amount is greater than 0
                        $paymentInfo = array(
                            'stripe_id' => $user_model->stripe_id,
                            'card_token' => $this->data['card_token'],
                            'amount' => $amount,
                            'currency_id' => $product_model->location->currency_id_text,
                            'description' => $product_model->location->currency_id_text . ' ' . $amount . ' payment for ' . $product_model->name . '(#' . $product_model->id . ') ' . ' by ' . $user_model->first_name . ' ' . $user_model->last_name . '(#' . $user_model->id . ') whose vrm is ' . $vehicle_model->vrm . ' (#' . $vehicle_model->id . '). TX_ID #' . $transaction_model->id,
                            'metadata' => array(
                                'transaction_id' => $transaction_model->id,
                                'user_id' => $user_model->id,
                                'user_name' => $user_model->first_name . ' ' . $user_model->last_name,
                                'email' => $user_model->email,
                                'phone' => $user_model->phone,
                                'product_id' => $this->data['product_id'],
                                'product_name' => $product_model->name,
                                'vehicle_id' => $vehicle_model->id,
                                'vrm' => $vehicle_model->vrm,
                                'merchant_id' => $product_model->merchant->id,
                                'merchant' => $product_model->merchant->name,
                            )
                        );

                        //Set the gateway
                        $transaction_model->gateway = $gateway = 'stripe';

                        //Attempt to transaction
                        $transaction_response = $payment_controller->transact($gateway, $paymentInfo);

                        if ($transaction_response['status']) {//Gateway transaction succeeded
                            //Set workflow
                            $transaction_model->workflow = 3;

                            //Set transaction id
                            $transaction_model->gateway_tran_id = $transaction_response['response']->id;

                            //Set promotion id
                            $transaction_model->promotion_id = $promotion_id ? $promotion_id : 0;
                        } else {//Gateway transaction failed
                            //Set workflow
                            $transaction_model->workflow = 2;

                            //Set stamp
                            $transaction_model->stamps_issued = 0;
                        }//E# if else statement
                        //Set card
                        $transaction_model->card_used = $user_controller->callController(\Util::buildNamespace('payments', 'card', 1), 'getVerbativeCardUsed', array($this->data['card_token']));
                        $transaction_model->card_token = $this->data['card_token'];
                    } else {
                        $transaction_model->gateway = 'promotion';
                        $transaction_model->workflow = 4;
                    }//E# if else statement

                    if ($amount) {//Amount is greater than 0
                        if ($transaction_response['status']) {
                            //After processing
                            $payment_controller->afterProcessing('card', $transaction_model, $product_model, $user_model, $vehicle_model);

                            //Build gateway response
                            $gateway_response = array(
                                'status' => 1,
                                'message' => \Lang::get($payment_controller->package . '::' . $payment_controller->controller . '.validation.processTransaction.transaction.1')
                            );

                            if ($promotion_id) {//Promotion id
                                //Redeem the promotion
                                $user_controller->updatePivotTable($user_model, 'promotions', $promotion_id, array('redeemed' => 1, 'transaction_id' => $transaction_model->id, 'updated_at' => Carbon::now()));
                            }//E# if statement
                        } else {
                            //Build gateway response
                            $gateway_response = array(
                                'status' => 0,
                                'message' => \Lang::get($payment_controller->package . '::' . $payment_controller->controller . '.validation.processTransaction.transaction.0')
                            );
                        }//E# if else statement
                    } else {
                        //After processing
                        $payment_controller->afterProcessing('promotion', $transaction_model, $product_model, $user_model, $vehicle_model);

                        //Build gateway response
                        $gateway_response = array(
                            'status' => 1,
                            'message' => \Lang::get($payment_controller->package . '::' . $payment_controller->controller . '.validation.processTransaction.transaction.1')
                        );

                        if ($promotion_id) {//Promotion id
                            //Redeem the promotion
                            $user_controller->updatePivotTable($user_model, 'promotions', $promotion_id, array('redeemed' => 1, 'transaction_id' => $transaction_model->id, 'updated_at' => Carbon::now()));
                        }//E# if statement
                    }//E# if else statement
                    //Get loyalty stamps
                    $stamp_model = $payment_controller->getLocationStamps($transaction_model->location_id, $user_model->id);

                    //Build stamps 
                    $stamps = array(
                        'issued' => (int) $transaction_model->stamps_issued,
                        'user_total' => $stamp_model ? (int) $stamp_model->feeling : 0,
                        'location_stamps' => (int) $product_model->location->loyalty_stamps
                    );

                    //Save transaction
                    $transaction_model->save();

                    //Check for referral
                    $referral_controller = new \Lava\Products\ReferralController();
                    $referral_controller->awardReferral($transaction_model->id, $user_model);

                    //Build notification
                    $this->notification = array(
                        'gateway' => $gateway_response,
                        'transaction' => $transaction_model->toArray(),
                        'stamps' => $stamps
                    );

                    throw new \Api200Exception($this->notification, $gateway_response['message']);
                } else {//Don't own this vehicle_id
                    //Set notification
                    $payment_controller->notification = array(
                        'field' => 'vehicle_id',
                        'type' => 'Vehicle',
                        'value' => $vehicle_id,
                    );

                    //Throw not found error
                    throw new \Api403Exception($payment_controller->notification);
                }//E# if statement
            } else {

                //Set notification
                $payment_controller->notification = array(
                    'field' => 'gps',
                    'type' => 'Distance',
                    'value' => 'Invalid',
                );

                //Set message
                $this->message = \Lang::get($payment_controller->package . '::' . $payment_controller->controller . '.validation.processTransaction.notNearEnough');

                //Throw 403 error
                throw new \Api403Exception($payment_controller->notification, $this->message);
            }//E# if else statement
        } else {//No such product
            //Set notification
            $product_controller->notification = array(
                'field' => 'id',
                'type' => 'Product',
                'value' => $this->data['product_id'],
            );

            //Throw product id not found error
            throw new \Api404Exception($product_controller->notification);
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
    public function validatePrepareTransaction($attribute, $product_id, $parameters) {
        //TODO: get default card details
        //TODO: Get promotions
        //TODO: Calculate price
        //TODO: Check surcharge
        //Get user model by id
        //product controller
        $product_controller = new ProductController();

        $parameters = array('merchant');

        //Get product by id
        $product_model = $product_controller->callController(\Util::buildNamespace('products', 'product', 1), 'getModelByField', array('id', $this->data['product_id']));

        if ($product_model) {//Product found
            //User controller
            $user_controller = new UserController();

            //Parameters
            $parameters = array('cards', 'unredeemed_promotions');

            //Get user model by id
            $user_model = $user_controller->callController(\Util::buildNamespace('accounts', 'user', 1), 'getModelByField', array('token', $this->data['token'], $parameters));

            $vehicle_id = isset($this->data['vehicle_id']) ? $this->data['vehicle_id'] : $user_model->vehicle_id;

            //Get vehiclel model
            $vehicle_model = $this->validateUserOwnsVehicle($attribute, $this->data['vehicle_id'], $parameters);
            if ($vehicle_model) {//Vehicle exists
                if ($user_model->cards->count()) {//User has cards
                    $default_card = false;

                    //Card fields to return
                    $card_fields = array('id', 'card_token', 'gateway', 'exp_month', 'exp_year', 'last4', 'brand');

                    foreach ($user_model->cards as $single_card) {
                        if ($single_card->id == $user_model->card_id) {//User has specified a default card
                            $default_card = $single_card->card_token;
                            $user_controller->notification['card'] = array_only($single_card->toArray(), $card_fields);
                            break;
                        }//E# if statement
                    }//E# foreach statement

                    if (!$default_card) {//Set default card as the last added card
                        //Last card
                        $last_card = $user_model->cards[((int) $user_model->cards->count() - 1)]->toArray();

                        $user_controller->notification['card'] = array_only($last_card, $card_fields);

                        //Save default card
                        $user_model->card_id = $last_card['id'];

                        //Save user
                        $user_model->save();
                    }//E# if statement
                    //VRM
                    $user_controller->notification['vehicle'] = array(
                        'vehicle_id' => $vehicle_model->id,
                        'type' => $vehicle_model->type
                    );

                    //PROMOTIONS
                    $promotions = array();
                    $amount = ((int) $vehicle_model->type == 2) ? $product_model->price_2 : $product_model->price_1;

                    $surcharge = $product_model->location->surcharge;

                    if ($user_model->unredeemed_promotions) {//Promotions exist
                        //Get promotions
                        $promotions = $product_controller->callController(\Util::buildNamespace('products', 'promotion', 1), 'locationRedeemablePromotions', array($product_model->location->id, $user_model->unredeemed_promotions->toArray(), $amount, $surcharge));
                    }//E# if statement
                    //Build transaction
                    $transaction = array(
                        'amount' => $amount,
                        'currency_id' => $product_model->location->currency_id_text,
                        'surcharge' => $surcharge,
                        'promotions' => $promotions,
                    );

                    $user_controller->notification['transaction'] = $transaction;

                    //Get success message
                    $message = \Lang::get('payments::payment.validation.prepareTransaction.success');

                    throw new \Api200Exception($user_controller->notification, $message);
                } else {
                    //Set error message
                    $this->message = \Lang::get('payments::payment.validation.prepareTransaction.noCard');
                }//E# if else statement
            }//E# if statement
        } else {//No such product
            //Set notification
            $product_controller->notification = array(
                'field' => 'id',
                'type' => 'Product',
                'value' => $this->data['product_id'],
            );

            //Throw product id not found error
            throw new \Api404Exception($product_controller->notification);
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
