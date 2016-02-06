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
     * @param  string   $promotion_code
     * @param  mixed   $parameters
     * @return bool
     */
    protected function validateIsPromotionCodeValid($attribute, $promotion_code, $parameters) {
        
        $promotion_controller = new PromotionController();

        //Get promotion model by code
        $promotion_model = $promotion_controller->getModelByField('code', $promotion_code);

        if ($promotion_model) {//Exists
            if ($promotion_model->claimed) {//Redeemed
                if ($promotion_model->claimed->pivot->redeemed) {
                    //Set error message
                    $this->message = \Lang::get($promotion_controller->package . '::' . $promotion_controller->controller . '.validation.isPromotionCodeValid.redeemed', array('code' => $promotion_code));
                } else {
                    //Set error message
                    $this->message = \Lang::get($promotion_controller->package . '::' . $promotion_controller->controller . '.validation.isPromotionCodeValid.claimed', array('code' => $promotion_code));
                }//E# if else statement
            } else {//Has not redeemed
                //Now
                $now = Carbon::now();

                $promoExpiryDate = Carbon::createFromFormat('Y-m-d G:i:s', $promotion_model->expiry_date);
                
                if ($promoExpiryDate->gt($now)) {
                    if ($promotion_model->new_customer) {//Only for new customers
                        //TODO check if customer has a transaction for this location
                        //Fields to select
                        $fields = array('*');

                        //Build where clause
                        $whereClause = array(
                            array(
                                'where' => 'where',
                                'column' => 'user_id',
                                'operator' => '=',
                                'operand' => $promotion_controller->user['id']
                            )
                        );

                        if ($promotion_model->type == 2) {
                            $whereClause[] = array(
                                'where' => 'where',
                                'column' => 'location_id',
                                'operator' => '=',
                                'operand' => $promotion_model->location_id
                            );
                        }//E# if statement
                        
                        //Get user by email and verification code
                        $transaction_model = $promotion_controller->callController(\Util::buildNamespace('payments', 'transaction', 1), 'select', array($fields, $whereClause, 1));

                        if ($transaction_model) {//Has a transaction for this location
                            //Set error message
                            $this->message = \Lang::get($promotion_controller->package . '::' . $promotion_controller->controller . '.validation.isPromotionCodeValid.newCustomers', array('code' => $code));
                        } else {//Claim
                            //Claim this promotion code
                            $promotion_controller->claimPromotionCode($promotion_controller, $promotion_model);
                        }//E# if else statement
                    } else {//Claim
                        //Claim this promotion code
                        $promotion_controller->claimPromotionCode($promotion_controller, $promotion_model);
                    }//E# if else statement
                } else {//Expired
                    //Set error message
                    $this->message = \Lang::get($promotion_controller->package . '::' . $promotion_controller->controller . '.validation.isPromotionCodeValid.expired', array('code' => $code));
                }//E# if else statement
            }//E# if else statement
        } else {//Don't exist
            //Set notification
            $promotion_controller->notification = array(
                'field' => 'code',
                'type' => 'Promotion',
                'value' => $code,
            );


            //Throw VRM not found error
            throw new \Api404Exception($promotion_controller->notification);
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
