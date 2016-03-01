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
     * S# roleBasedWhereClause() function
     * @author Edwin Mugendi
     * Build where clause based on role
     * 
     * @param array $fields Fields
     * @param array $where_clause Where clause
     * @param array $parameters Parameters
     */
    public function roleBasedWhereClause($fields, &$where_clause, &$parameters) {
        if ($this->user['role_id'] == 2) {//Merchant
            $where_clause[] = array(
                'where' => 'where',
                'column' => 'merchant_id',
                'operator' => '=',
                'operand' => $this->merchant['id']
            );
        }
    }

    //E# roleBasedWhereClause() function

    /**
     * S# injectDataSources() function
     * @author Edwin Mugendi
     * Inject data source. This are mainly select
     * 
     * @param array $dataSource Data source
     */
    public function injectDataSources() {
        //Get this organization merchant id
        $this->view_data['dataSource']['merchant_id'] = $this->appGetCustomMerchantHtmlSelect();
                
        //Get this organization location id
        $this->view_data['dataSource']['location_id'] = $this->callController(\Util::buildNamespace('merchants', 'location', 1), 'getMerchantsHtmlSelect', array($this->merchant['id'], 'id', array('name'), \Lang::get('common.select')));

        //Get and set type options to data source
        $this->view_data['dataSource']['type'] = \Lang::get($this->package . '::' . $this->controller . '.data.type');

        //Get and set new customer options to data source
        $this->view_data['dataSource']['new_customer'] = \Lang::get($this->package . '::' . $this->controller . '.data.new_customer');
    }

//E# injectDataSources() function

    /**
     * S# appendCustomValidationRules() function
     * 
     * Append custom validation rules.
     * 
     * This mainly happens when we need to access the id of object. Eg when updating an object with unique validation rule in it
     * 
     * Make sure you have if else for create and update
     * if($this->crudId == 2){}
     */
    public function appendCustomValidationRules() {
        if ($this->crudId == 2) {
            $this->validationRules['code'] = 'required|unique:pdt_promotions,code,' . $this->input['id'] . ',id,status,1';
        }//E# if statement
    }

//E# appendCustomValidationRules() function

    /**
     * S# locationRedeemablePromotions() function
     * Get the redeemable promotions for this location
     * 
     * @param int $location_id Location id
     * @param array $promotions Promotions that can be redeemed
     * @param float $amount Transaction amount - needed when calculating effective price
     * @param float $surcharge Surcharge  - needed when calculating effective price
     * 
     * @return array Prepared promotions
     * 
     */
    public function locationRedeemablePromotions($location_id, $promotions, $amount, $surcharge) {
        //Cache redeemable promotions
        $redeemable_promotions = array();

        foreach ($promotions as $single_promotion) {//Loop via the promotions
            if ($single_promotion['location_id']) {
                if ($single_promotion['location_id'] == $location_id) {
                    $redeemable_promotions[] = $single_promotion;
                }//E# if else statement    
            } else {
                $redeemable_promotions[] = $single_promotion;
            }//E# if else statement
        }//E# foreach statement
        //Return prepared redeemable promotions
        return $this->prepareRedeemablePromotions($redeemable_promotions, $amount, $surcharge);
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
        $redeemable_promotions = array();
        foreach ($promotions as $single_promotion) {//Loop via the promotions
            //Calculate effective price
            $effective_price = $this->calculateEffectivePrice($single_promotion['type'], $single_promotion['value'], $amount);

            //Define promo
            $promo = array(
                'price' => (string) round((floatval($effective_price) + floatval($surcharge)), 2),
                'id' => $single_promotion['id'],
                'description' => $single_promotion['description'],
                'expiry_date' => $single_promotion['expiry_date'],
                'code' => $single_promotion['code'],
                'type' => $single_promotion['type'],
                'value' => $single_promotion['value']
            );
            $redeemable_promotions[] = $promo;
        }//E# foreach statement
        //Return redeemable promotions
        return $redeemable_promotions;
    }

//E# prepareRedeemablePromotions() function

    /**
     * S# calculateEffectivePrice() function
     * Calculate the effective price after applying promotion
     * 
     * @param int $type Promotion type. Percentage or fixed
     * @param int $promotion_value Promotion value
     * @param float $price_before_code Price before applying code
     * 
     * @return float Effective price
     */
    public function calculateEffectivePrice($type, $promotion_value, $price_before_code) {
        if ($type == 1) {//Fixed value
            //Calculate effective price
            $effective_price = $price_before_code - $promotion_value;

            return $effective_price > 0 ? $effective_price : 0;
        } else if ($type == 2) {//Percentage
            //Calculate effective price
            $effective_price = $price_before_code - (($promotion_value * $price_before_code) / 100);

            return $effective_price > 0 ? $effective_price : 0;
        } else {
            return $price_before_code;
        }//E#  if else statement
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
     * S# isModelViewable() function
     * Is model viewable
     * 
     * @param array $model Model
     */
    public function isModelViewable($model) {
        //Now    
        $now = Carbon::now();
        //Expiry date    
        $expiryDate = Carbon::createFromFormat('Y-m-d G:i:s', $model['expiry_date']);

        return $expiryDate->gt($now) ? true : false;
    }

//E# isModelViewable() function

    /**
     * S# postClaimPromotion() function
     * Claim a promotion code if valid
     * 
     * @param string $code Promotion code
     * @return boolean true if redeemed, false else
     */
    public function postClaimPromotion() {

        //Define validation rules
        $this->validationRules = array(
            'promotion_code' => 'required|isPromotionCodeValid'
        );
        //Validate merchant
        $this->isInputValid();
    }

//E# postClaimPromotion() function

    /**
     * S# claimPromotionCode() function
     * Claim promotion code
     * 
     * @param Controller $promotion_controller Controller
     * @param Model $promotion_model Model
     * @throws APISucessException
     */
    public function claimPromotionCode(&$promotion_controller, &$promotion_model) {
        //Claim
        $promotion_model->users()->attach($promotion_controller->user['id'], array(
            'ip' => $this->input['ip'],
            'agent' => $this->input['agent'],
            'status' => 1,
            'created_by' => $promotion_controller->user['id'],
            'updated_by' => $promotion_controller->user['id'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
                )
        );

        //Get success message
        $message = \Lang::get($this->package . '::' . $this->controller . '.notification.is_promotion_code_valid.claimed', array('code' => $promotion_model->code));

        //Throw new API Success Exception
        throw new \Api200Exception(array_only($promotion_model->toArray(), array('id')), $message);
    }

//E# claimPromotionCode() function
}

//E# PromotionController() function