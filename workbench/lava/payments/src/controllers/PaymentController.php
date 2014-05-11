<?php

namespace Lava\Payments;

/**
 * S# PaymentController() function
 * Payment controller
 * @author Edwin Mugendi
 */
class PaymentController extends PaymentsBaseController {

    //Controller
    public $controller = 'payment';
    //Lazy load
    public $lazyLoad = array();

    public function process() {
        $this->validationRules = array(
            'product_id' => 'required',
            'location' => 'latLng',
            'card_token' => 'required',
            'amount' => 'required',
            'currency' => 'required',
            'promotion_ids' => '',
            'vrm' => 'required|processTransaction',
        );

        $this->isInputValid();
    }

    /**
     * 
     */
    public function prepare() {
        $this->validationRules = array(
            'product_id' => 'required',
            'vrm' => 'required|prepareTransaction',
        );

        $this->isInputValid();
    }

    public function transact($gateway, $paymentInfo) {
        return $this->callController(\Util::buildNamespace('payments', $gateway, 1), 'createTransaction', array($paymentInfo));
    }

    public function prepareTransactionArray($gateway,$gatewayTransaction) {
        return $this->callController(\Util::buildNamespace('payments', $gateway, 1), 'prepareTransactionArray', array($gatewayTransaction));
    }
}

//E# PaymentController() function