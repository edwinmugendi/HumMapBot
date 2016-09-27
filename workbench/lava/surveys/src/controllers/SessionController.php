<?php

namespace Lava\Surveys;

/**
 * S# SessionController() function
 * Session controller
 * @author Edwin Mugendi
 */
class SessionController extends SurveysBaseController {

    //Controller
    public $controller = 'session';

    /**
     * S# injectDataSources() function
     * @author Edwin Mugendi
     * Inject data source. This are mainly select
     * 
     * @param array $dataSource Data source
     */
    public function injectDataSources() {
        //Get this organization form id
        $this->view_data['dataSource']['form_id'] = $this->callController(\Util::buildNamespace('surveys', 'form', 1), 'getOrganizationsHtmlSelect', array($this->org['id'], 'id', array('name'), \Lang::get('common.select')));

        //Get this organization question id
        $this->view_data['dataSource']['question_id'] = $this->callController(\Util::buildNamespace('surveys', 'question', 1), 'getOrganizationsHtmlSelect', array($this->org['id'], 'id', array('name'), \Lang::get('common.select')));
    }

//E# injectDataSources() function
}

//E# SessionController() function