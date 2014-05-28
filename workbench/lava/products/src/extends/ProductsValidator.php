<?php

namespace Lava\Products;

use Symfony\Component\Translation\TranslatorInterface;
use Carbon\Carbon;

/**
 * S# ProductsValidator() function
 * Products Validator
 * @author Edwin Mugendi
 * @todo We are extending the Payments Validator because PHP does not offer multiple inheritance. We extend alphabetically
 */
class ProductsValidator extends \Lava\Payments\PaymentsValidator {

    //Message object
    private $message;

    /**
     * S# validateIsPromotionCodeValid() function
     * Validate promotion code
     *
     * @author Edwin Mugendi <edwinmugendi@gmail.com>
     * @param  string  $attribute
     * @param  mixed   $value
     * @param  mixed   $parameters
     * @return bool
     */
    protected function validateIsPromotionCodeValid($attribute, $code, $parameters) {
        $promotionController = new PromotionController();

        //Get promotion model by code
        $promotionModel = $promotionController->getModelByField('code', $code);

        if ($promotionModel) {//Exists
            if ($promotionModel->claimed) {//Redeemed
                if ($promotionModel->claimed->pivot->redeemed) {
                    //Set error message
                    $this->message = \Lang::get($promotionController->package . '::' . $promotionController->controller . '.validation.isPromotionCodeValid.redeemed', array('code' => $code));
                } else {
                    //Set error message
                    $this->message = \Lang::get($promotionController->package . '::' . $promotionController->controller . '.validation.isPromotionCodeValid.claimed', array('code' => $code));
                }//E# if else statement
            } else {//Has not redeemed
                //Now
                $now = Carbon::now();

                $promoExpiryDate = Carbon::createFromFormat('Y-m-d G:i:s', $promotionModel->expiry_date);
                if ($promoExpiryDate->gt($now)) {
                    if ($promotionModel->new_customer) {//Only for new customers
                        //TODO check if customer has a transaction for this location
                        //Fields to select
                        $fields = array('*');

                        //Build where clause
                        $whereClause = array(
                            array(
                                'where' => 'where',
                                'column' => 'user_id',
                                'operator' => '=',
                                'operand' => $promotionController->user['id']
                            )
                        );

                        if ($promotionModel->type == 2) {
                            $whereClause[] = array(
                                'where' => 'where',
                                'column' => 'location_id',
                                'operator' => '=',
                                'operand' => $promotionModel->location_id
                            );
                        }
                        //Get user by email and verification code
                        $transactionModel = $promotionController->callController(\Util::buildNamespace('payments', 'transaction', 1), 'select', array($fields, $whereClause, 1));

                        if ($transactionModel) {//Has a transaction for this location
                            //Set error message
                            $this->message = \Lang::get($promotionController->package . '::' . $promotionController->controller . '.validation.isPromotionCodeValid.newCustomers', array('code' => $code));
                        } else {//Claim
                            //Claim this promotion code
                            $promotionController->claimPromotionCode($promotionController, $promotionModel);
                        }//E# if else statement
                    } else {//Claim
                        //Claim this promotion code
                        $promotionController->claimPromotionCode($promotionController, $promotionModel);
                    }//E# if else statement
                } else {//Expired
                    //Set error message
                    $this->message = \Lang::get($promotionController->package . '::' . $promotionController->controller . '.validation.isPromotionCodeValid.expired', array('code' => $code));
                }//E# if else statement
            }//E# if else statement
        } else {//Don't exist
            //Set notification
            $promotionController->notification = array(
                'field' => 'code',
                'type' => 'Promotion',
                'value' => $code,
            );


            //Throw VRM not found error
            throw new \Api404Exception($promotionController->notification);
        }//E# if else statement
        return false;
    }

//E# validateIsCodeValid() function

    /**
     * S# replaceIsPromotionCodeValid() function
     * Replace all place-holders for the is_promotion_code_valid rule.
     *
     * @author Edwin Mugendi <edwinmugendi@gmail.com>
     * @param  string  $message
     * @param  string  $attribute
     * @param  string  $rule
     * @param  array   $parameters
     * @return string
     */
    protected function replaceIsPromotionCodeValid($message, $attribute, $rule, $parameters) {
        return $this->message;
    }

//E# replaceIsPromotionCodeValid() function
}
