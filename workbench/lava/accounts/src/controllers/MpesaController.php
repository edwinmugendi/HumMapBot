<?php

namespace Lava\Accounts;

/**
 * S# MpesaController() function
 * Mpesa controller
 * @author Edwin Mugendi
 */
class MpesaController extends AccountsBaseController {

    //Controller
    public $controller = 'mpesa';

    /**
     * S# injectDataSources() function
     * @author Edwin Mugendi
     * Inject data source. This are mainly select
     * 
     * @param array $dataSource Data source
     */
    public function injectDataSources() {
        //Get and set currency options to data source
        $this->view_data['dataSource']['currency'] = \Lang::get($this->package . '::' . $this->controller . '.data.currency');

        //Get this accounts user id
        $this->view_data['dataSource']['user_id'] = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getMerchantsHtmlSelect', array($this->merchant['id'], 'id', array('full_name'), \Lang::get('common.select')));

        //Get and set type options to data source
        $this->view_data['dataSource']['type'] = \Lang::get($this->package . '::' . $this->controller . '.data.type');

        //Get and set class options to data source
        $this->view_data['dataSource']['class'] = \Lang::get($this->package . '::' . $this->controller . '.data.class');
    }

//E# injectDataSources() function
}

//E# MpesaController() function