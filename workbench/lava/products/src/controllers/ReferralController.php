<?php

namespace Lava\Products;

/**
 * S# ReferralsController() function
 * Referral controller
 * @author Edwin Mugendi
 */
class ReferralController extends ProductsBaseController {

    //Controller
    public $controller = 'referral';

    /**
     * S# postReferredBy() function
     * I was referred by
     * 
     */
    public function postReferredBy() {

        //Define validation rules
        $this->validationRules = array(
            'referral_code' => 'required|isReferralCodeValid'
        );
        //Validate merchant
        $this->isInputValid();
    }

//E# postReferredBy() function

    /**
     * S# injectDataSources() function
     * @author Edwin Mugendi
     * Inject data source. This are mainly select
     * 
     * @param array $dataSource Data source
     */
    public function injectDataSources() {
        //Get this organization user id
        $this->view_data['dataSource']['referrer_id'] = $this->view_data['dataSource']['referee_id'] = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getMerchantsHtmlSelect', array($this->merchant['id'], 'id', array('first_name', 'last_name'), \Lang::get('common.select')));

        //Get this organization promotion id
        $this->view_data['dataSource']['promotion_id'] = $this->callController(\Util::buildNamespace('products', 'promotion', 1), 'getMerchantsHtmlSelect', array($this->merchant['id'], 'id', array('code'), \Lang::get('common.select')));

        //Get and set workflow options to data source
        $this->view_data['dataSource']['workflow'] = \Lang::get($this->package . '::' . $this->controller . '.data.workflow');
    }

//E# injectDataSources() function
}

//E# ReferralController() function