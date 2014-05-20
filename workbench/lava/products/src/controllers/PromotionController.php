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
     * S# prepareRelation() function
     * Prepare relation
     * 
     * @param array $rawRelation Raw relation
     */
    public function prepareRelation($rawPromotion) {
        return array_except($rawPromotion, array('pivot', 'claimed'));
    }

//E# prepareRelation() function

    /**
     * S# postRedeemPromotion() function
     * Redeem a promotion code if valid
     * 
     * @param string $code Promotion code
     * @return boolean true if redeemed, false else
     */
    public function postRedeemPromotion($promotion_id) {

        //Add merchant id to inputs for validation
        $this->input['id'] = $promotion_id;

        //Define validation rules
        $this->validationRules = array(
            'id' => 'required|integer|isPromotionCodeValid'
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