<?php

namespace Lava\Accounts;

/**
 * S# ChatController() function
 * Chat controller
 * @author Edwin Mugendi
 */
class ChatController extends AccountsBaseController {

    //Controller
    public $controller = 'chat';

    /**
     * S# injectDataSources() function
     * @author Edwin Mugendi
     * Inject data source. This are mainly select
     * 
     * @param array $dataSource Data source
     */
    public function injectDataSources() {
        //Get this accounts user id
        $this->view_data['dataSource']['recipient_id'] = $this->view_data['dataSource']['sender_id'] = $this->view_data['dataSource']['user_id'] = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getOrganizationsHtmlSelect', array($this->org['id'], 'id', array('full_name'), \Lang::get('common.select')));

        //Get and set workflow options to data source
        $this->view_data['dataSource']['workflow'] = \Lang::get($this->package . '::' . $this->controller . '.data.workflow');

        //Get and set in out options to data source
        $this->view_data['dataSource']['in_out'] = \Lang::get($this->package . '::' . $this->controller . '.data.in_out');
    }

//E# injectDataSources() function
}

//E# ChatController() function