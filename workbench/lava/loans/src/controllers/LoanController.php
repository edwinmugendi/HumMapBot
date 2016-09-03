<?php

namespace Lava\Loans;

/**
 * S# LoansController() function
 * Loan controller
 * @author Edwin Mugendi
 */
class LoanController extends LoansBaseController {

    //Controller
    public $controller = 'loan';
    
    //Owned by
    public $ownedBy = array('merchant', 'user');

    /**
     * S# injectDataSources() function
     * @author Edwin Mugendi
     * Inject data source. This are mainly select
     * 
     * @param array $dataSource Data source
     */
    public function injectDataSources() {
        //Get this accounts user id
        $this->view_data['dataSource']['user_id'] = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getMerchantsHtmlSelect', array($this->merchant['id'], 'id', array('full_name'), \Lang::get('common.select')));

        //Get this accounts officer id
        $this->view_data['dataSource']['officer_id'] = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getMerchantsHtmlSelect', array($this->merchant['id'], 'id', array('full_name'), \Lang::get('common.select')));

        //Get this loans user id
        $this->view_data['dataSource']['plan_id'] = $this->callController(\Util::buildNamespace('loans', 'loan', 1), 'getMerchantsHtmlSelect', array($this->merchant['id'], 'id', array('period', 'period_cycle', 'interest_rate', 'pay_every', 'cycle'), \Lang::get('common.select'), ' '));

        $this->view_data['dataSource']['plan_id'] = array('1' => '12 days');

        //Get and set on schedule options to data source
        $this->view_data['dataSource']['on_schedule'] = \Lang::get($this->package . '::' . $this->controller . '.data.on_schedule');

        //Get and set currency options to data source
        $this->view_data['dataSource']['currency'] = \Lang::get($this->package . '::' . $this->controller . '.data.currency');

        //Get and set workflow options to data source
        $this->view_data['dataSource']['workflow'] = \Lang::get($this->package . '::' . $this->controller . '.data.workflow');

        //Get and set use options to data source
        $this->view_data['dataSource']['use'] = \Lang::get($this->package . '::' . $this->controller . '.data.use');

        //Get and set purpose options to data source
        $this->view_data['dataSource']['purpose'] = \Lang::get($this->package . '::' . $this->controller . '.data.purpose');

        //Get and set period cycle options to data source
        $this->view_data['dataSource']['period_cycle'] = $this->view_data['dataSource']['cycle'] = \Lang::get($this->package . '::' . $this->controller . '.data.cycle');
    }

//E# injectDataSources() function
}

//E# LoanController() function