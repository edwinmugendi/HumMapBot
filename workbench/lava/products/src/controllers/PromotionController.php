<?php

namespace Lava\Products;

use Carbon\Carbon;

/**
 * S# PromotionsController() function
 * Promotion controller
 * @author Edwin Mugendi
 */
class PromotionController extends ProductsBaseController {

    //Controller
    public $controller = 'promotion';

    /**
     * S# locationRedeemablePromotions() function
     * Get the redeemable promotions for this location
     * 
     * @param int $locationId Location id
     * @param array $promotions Promotions that can be redeemed
     * @param float $amount Transaction amount - needed when calculating effective price
     * @param float $surcharge Surcharge  - needed when calculating effective price
     * 
     * @return array Prepared promotions
     * 
     */
    public function locationRedeemablePromotions($locationId, $promotions, $amount, $surcharge) {
        //Cache redeemable promotions
        $redeemablePromotions = array();

        foreach ($promotions as $singlePromotion) {//Loop via the promotions
            if ($singlePromotion['location_id']) {
                if ($singlePromotion['location_id'] == $locationId) {
                    $redeemablePromotions[] = $singlePromotion;
                }//E# if else statement    
            } else {
                $redeemablePromotions[] = $singlePromotion;
            }//E# if else statement
        }//E# foreach statement
        //Return prepared redeemable promotions
        return $this->prepareRedeemablePromotions($redeemablePromotions, $amount, $surcharge);
    }

//E# locationRedeemablePromotions() function

    /**
     * S# prepareRedeemablePromotions() function
     * Get the redeemable promotions for this location
     * 
     * @param array $promotions Promotions that can be redeemed
     * @param float $amount Transaction amount - needed when calculating effective price
     * @param float $surcharge Surcharge  - needed when calculating effective price
     * 
     * @return array Prepared promotions
     * 
     */
    public function prepareRedeemablePromotions($promotions, $amount, $surcharge) {
        //Cache redeemable promotions
        $redeemablePromotions = array();
        foreach ($promotions as $singlePromotion) {//Loop via the promotions
            //Calculate effective price
            $effectivePrice = $this->calculateEffectivePrice($singlePromotion['type'], $singlePromotion['value'], $amount);

            //Define promo
            $promo = array(
                'price' => (string) round((floatval($effectivePrice) + floatval($surcharge)), 2),
                'id' => $singlePromotion['id'],
                'description' => $singlePromotion['description'],
                'expiry_date' => $singlePromotion['expiry_date'],
                'code' => $singlePromotion['code'],
                'type' => $singlePromotion['type'],
                'value' => $singlePromotion['value']
            );
            $redeemablePromotions[] = $promo;
        }//E# foreach statement
        //Return redeemable promotions
        return $redeemablePromotions;
    }

//E# prepareRedeemablePromotions() function

    /**
     * S# calculateEffectivePrice() function
     * Calculate the effective price after applying promotion
     * 
     * @param int $type Promotion type. Percentage or fixed
     * @param int $promotionValue Promotion value
     * @param float $priceBeforeCode Price before applying code
     * 
     * @return float Effective price
     */
    public function calculateEffectivePrice($type, $promotionValue, $priceBeforeCode) {
        /*
          var_dump($type);
          var_dump($promotionValue);
          dd($priceBeforeCode);
         * 
         */
        if ($type == 1) {//Fixed value
            //Calculate effective price
            $effectivePrice = $priceBeforeCode - $promotionValue;

            return $effectivePrice > 0 ? $effectivePrice : 0;
        } else if ($type == 2) {//Percentage
            //Calculate effective price
            $effectivePrice = $priceBeforeCode - (($promotionValue * $priceBeforeCode) / 100);

            return $effectivePrice > 0 ? $effectivePrice : 0;
        } else {
            return $priceBeforeCode;
        }
    }

//E# calculateEffectivePrice() function

    /**
     * S# prepareModelToReturn() function
     * Prepare relation
     * 
     * @param array $rawRelation Raw relation
     */
    public function prepareModelToReturn($rawPromotion) {
        return array_except($rawPromotion, array('pivot', 'claimed'));
    }

//E# prepareModelToReturn() function

    /**
     * S# postRedeemPromotion() function
     * Redeem a promotion code if valid
     * 
     * @param string $code Promotion code
     * @return boolean true if redeemed, false else
     */
    public function postRedeemPromotion($code) {

        //Add merchant id to inputs for validation
        $this->input['code'] = $code;

        //Define validation rules
        $this->validationRules = array(
            'code' => 'required|isPromotionCodeValid'
        );
        //Validate merchant
        $this->isInputValid();
    }

//E# postRedeemPromotion() function
    /**
     * S# claimPromotionCode() function
     * Claim promotion code
     * 
     * @param Controller $promotionController Controller
     * @param Model $promotionModel Model
     * @throws APISucessException
     */
    public function claimPromotionCode(&$promotionController, &$promotionModel) {
        //Claim
        $promotionModel->users()->attach($promotionController->user['id']);

        //Get success message
        $message = \Lang::get($this->package . '::' . $this->controller . '.api.redeemPromotion', array('code' => $promotionModel->code));

        //Throw new API Success Exception
        throw new \Api200Exception(array_only($promotionModel->toArray(), array('id')), $message);
    }

//E# claimPromotionCode() function
}

//E# PromotionController() function