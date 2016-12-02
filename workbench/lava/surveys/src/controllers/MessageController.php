<?php

namespace Lava\Surveys;

/**
 * S# MessageController() function
 * Message controller
 * @author Edwin Mugendi
 */
class MessageController extends SurveysBaseController {

    //Controller
    public $controller = 'message';

    /**
     * S# injectDataSources() function
     * @author Edwin Mugendi
     * Inject data source. This are mainly select
     * 
     * @param array $dataSource Data source
     */
    public function injectDataSources() {

        //Get this organization session id
        $this->view_data['dataSource']['session_id'] = $this->callController(\Util::buildNamespace('surveys', 'session', 1), 'getOrganizationsHtmlSelect', array($this->org['id'], 'id', array('full_name'), \Lang::get('common.select')));

        //Get and set type options to data source
        $this->view_data['dataSource']['type'] = \Lang::get($this->package . '::' . $this->controller . '.data.type');
    }

//E# injectDataSources() function
}

//E# MessageController() function