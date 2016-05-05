<?php

namespace Lava\Loans;

/**
 * S# OffersController() function
 * Offer controller
 * @author Edwin Mugendi
 */
class OfferController extends LoansBaseController {

    //Controller
    public $controller = 'offer';

    /**
     * S# injectDataSources() function
     * @author Edwin Mugendi
     * Inject data source. This are mainly select
     * 
     * @param array $dataSource Data source
     */
    public function injectDataSources() {

        //Get this accounts user id
        $this->view_data['dataSource']['user_id'] = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getMerchantsHtmlSelect', array($this->merchant['id'], 'id', array('first_name', 'last_name'), \Lang::get('common.select')));

        //Get this accounts officer id
        $this->view_data['dataSource']['officer_id'] = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getMerchantsHtmlSelect', array($this->merchant['id'], 'id', array('first_name', 'last_name'), \Lang::get('common.select')));

        //Get this loans user id
        $this->view_data['dataSource']['plan_id'] = $this->callController(\Util::buildNamespace('loans', 'loan', 1), 'getMerchantsHtmlSelect', array($this->merchant['id'], 'id', array('period', 'period_cycle', 'interest_rate', 'pay_every', 'cycle'), \Lang::get('common.select'), ' '));

        $this->view_data['dataSource']['plan_id'] = array('1' => '12 days');

        //Get and set currency options to data source
        $this->view_data['dataSource']['currency'] = \Lang::get($this->package . '::' . $this->controller . '.data.currency');

        //Get and set workflow options to data source
        $this->view_data['dataSource']['workflow'] = \Lang::get($this->package . '::' . $this->controller . '.data.workflow');
    }

//E# injectDataSources() function
}

//E# OfferController() function