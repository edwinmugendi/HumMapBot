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
        //TODO: 
        //TODO: Get promotions
        //TODO: Calculate price
        //TODO: Check surcharge
        //Get user model by id
        //Product controller
        $productController = new ProductController();

        $parameters = array('merchant');

        //Get product by id
        $productModel = $productController->callController(\Util::buildNamespace('products', 'product', 1), 'getModelByField', array('id', $this->data['product_id']));

        if ($productModel) {//Product found
            //User controller
            $userController = new UserController();

            $parameters = array('app55');

            //Get user model by id
            $userModel = $userController->callController(\Util::buildNamespace('accounts', 'user', 1), 'getModelByField', array('id', $userController->user['id'], $parameters));

            //Payment controller
            $paymentController = new PaymentController();

            $paymentInfo = array(
                'app55UserId' => $userModel->app55->id,
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

                if ($this->data['location']) {//Set transaction location
                    $transactionArray['lat'] = $this->data['location']['lat'];
                    $transactionArray['lng'] = $this->data['location']['lng'];
                }//E# if statement

                if ($this->data['promotion_id']) {//Promotion id
                    $transactionArray['promotion_id'] = $this->data['promotion_id'];
                }//E# if statement

                $transactionArray['vrm'] = $this->data['vrm'];

                //Create transaction
                $transactionModel = $userController->callController(\Util::buildNamespace('payments', 'transaction', 1), 'createIfValid', array($transactionArray, true));

                if ($transactionModel) {
                    throw new \ApiSuccessException($transactionModel->toArray(), array('id'));
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
    public function validatePrepareTransaction($attribute, $vrm, $parameters) {
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
            $vehicleModel = $this->validateUserOwnsVrm($attribute, $vrm, $parameters);

            if ($vehicleModel) {
                //User controller
                $userController = new UserController();

                $parameters = array('cards', 'unredeemed_promotions');

                //Get user model by id
                $userModel = $userController->callController(\Util::buildNamespace('accounts', 'user', 1), 'getModelByField', array('id', $userController->user['id'], $parameters));

                if ($userModel->cards) {//User has cards
                    $defaultCardFound = false;
                    foreach ($userModel->cards as $singleCard) {
                        if ($singleCard->token == $userModel->card) {//User has specified a default card
                            $defaultCardFound = true;
                            $userController->notification['card'] = $singleCard->toArray();
                            break;
                        }//E# if statement
                    }//E# foreach statement

                    if (!$defaultCardFound) {//Set default card as the last added card
                        $userController->notification = $userModel->card[($userModel->card->count() - 1)];
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
                        'drive_type' => $vehicleModel->drive_type
                    );
                    //PRODUCT
                    $userController->notification['product'] = array(
                        'id' => $productModel->id,
                        'price_4X2' => $productModel->price_4X2,
                        'price_4X4' => $productModel->price_4X4
                    );


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

                    throw new \ApiSuccessException($userController->notification, $message);
                } else {
                    //Set error message
                    $this->message = \Lang::get('payments::payment.validation.prepareTransaction.noCard');
                }
            } else {//User don't own this car
                //Set message
                $this->message = \Lang::get('accounts::vehicle.validation.userOwns', array('vrm' => $this->data['vrm']));
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
