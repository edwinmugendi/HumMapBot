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
        //Get and set channel options to data source
        $this->view_data['dataSource']['channel'] = \Lang::get($this->package . '::' . $this->controller . '.data.channel');
    }

//E# injectDataSources() function
}

//E# SessionController() function