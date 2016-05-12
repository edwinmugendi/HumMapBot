<?php

namespace Lava\Accounts;

/**
 * S# LogController() function
 * Log controller
 * @author Edwin Mugendi
 */
class LogController extends AccountsBaseController {

    //Controller
    public $controller = 'log';

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

        //Get and set type options to data source
        $this->view_data['dataSource']['type'] = \Lang::get($this->package . '::' . $this->controller . '.data.type');

        //Get and set in out options to data source
        $this->view_data['dataSource']['in_out'] = \Lang::get($this->package . '::' . $this->controller . '.data.in_out');
    }

//E# injectDataSources() function
}

//E# LogController() function