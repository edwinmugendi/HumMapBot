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
     * S# getPromotion() function
     * 1. Get promotion by id
     * 2. Get all valid users promotions
     * @param int $promotionId Promotion id
     * return single promotion or and array of promotions
     */
    public function getPromotion($promotionId = null) {
        if (is_null($promotionId)) {//Get List promotions
            $pluralController = 'unredeemedPromotions';

            //Lazy load to load
            $parameters['lazyLoad'] = array($pluralController);

            //Get user by token
            $userModel = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getModelByField', array('token', $this->input['token'], $parameters));


            if ($this->subdomain == 'api') {//From API
                //Get success message
                $message = \Lang::get($this->package . '::' . $this->controller . '.api.getAll');

                $promotionArray = array();
                foreach ($userModel->$pluralController->toArray() as $singlePromotion) {
                    $promotionArray[] = $this->preparePromotion($singlePromotion);
                }//E# foreach statement

                throw new \Api200Exception($promotionArray, $message);
            }//E# if else statement
        } else {//Get a single vehicle
            $this->input['promotion_id'] = $promotionId;

            $this->validationRules = array(
                'promotion_id' => 'required|integer'
            );
            //Validate vehicle
            $this->isInputValid();

            //Fields to select
            $fields = array('*');

            //Build where clause
            $whereClause = array(
                array(
                    'where' => 'where',
                    'column' => 'id',
                    'operator' => '=',
                    'operand' => $this->input['promotion_id']
                ),
                array(
                    'where' => 'where',
                    'column' => 'expiry_date',
                    'operator' => '<',
                    'operand' => Carbon::now()
                )
            );

            //Get promotion model by id and not expired
            $promotionModel = $this->select($fields, $whereClause, 1);

            if ($promotionModel) {
                if ($promotionModel->user_owns) {
                    //Get success message
                    $message = \Lang::get($this->package . '::' . $this->controller . '.api.getSingle', array('field' => 'id', 'value' => $this->input['promotion_id']));

                    $promotionArray = $this->preparePromotion($promotionModel->toArray());

                    throw new \Api200Exception($promotionArray, $message);
                } else {
                    //Set notification
                    $this->notification = array(
                        'field' => 'id',
                        'type' => 'Promotion',
                        'value' => $this->input['promotion_id'],
                    );

                    //Throw 403 found error
                    throw new \Api403Exception($this->notification);
                }
            } else {
                //Set notification
                $this->notification = array(
                    'field' => 'id',
                    'type' => 'Promotion',
                    'value' => $this->input['promotion_id'],
                );

                //Throw Locationf not found error
                throw new \Api404Exception($this->notification);
            }
        }
    }

//E# getPromotion() function

    /**
     * S# preparePromotion() function
     * Prepare Promotion
     * 
     * @param array $rawPromotion Raw promotion
     */
    private function preparePromotion($rawPromotion) {
        return array_except($rawPromotion, array('claimed', 'pivot'));
    }//E# preparePromotion() function

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