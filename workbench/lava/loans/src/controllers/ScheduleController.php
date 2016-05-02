<?php

namespace Lava\Loans;

/**
 * S# SchedulesController() function
 * Schedule controller
 * @author Edwin Mugendi
 */
class ScheduleController extends LoansBaseController {

    //Controller
    public $controller = 'schedule';

    /**
     * S# injectDataSources() function
     * @author Edwin Mugendi
     * Inject data source. This are mainly select
     * 
     * @param array $dataSource Data source
     */
    public function injectDataSources() {
        //Get this loans user id
        $this->view_data['dataSource']['loan_id'] = $this->callController(\Util::buildNamespace('loans', 'loan', 1), 'getMerchantsHtmlSelect', array($this->merchant['id'], 'id', array('principal','user_id_text',), \Lang::get('common.select'), ' '));

        $this->view_data['dataSource']['loan_id'] = array('1' => '12 days');
    }

//E# injectDataSources() function
}

//E# ScheduleController() function