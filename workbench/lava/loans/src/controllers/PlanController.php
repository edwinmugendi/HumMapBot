<?php

namespace Lava\Loans;

/**
 * S# PlanController() function
 * Plan controller
 * @author Edwin Mugendi
 */
class PlanController extends LoansBaseController {

    //Controller
    public $controller = 'plan';

    /**
     * S# injectDataSources() function
     * @author Edwin Mugendi
     * Inject data source. This are mainly select
     * 
     * @param array $dataSource Data source
     */
    public function injectDataSources() {

        //Get and set period cycle options to data source
        $this->view_data['dataSource']['period_cycle'] = $this->view_data['dataSource']['cycle'] = \Lang::get($this->package . '::' . $this->controller . '.data.cycle');
    }

//E# injectDataSources() function
}

//E# PlanController() function