<?php

namespace Lava\Surveys;

use Carbon\Carbon;

/**
 * S# UpdateController() function
 * Update controller
 * @author Edwin Mugendi
 */
class UpdateController extends SurveysBaseController {

    //Controller
    public $controller = 'update';

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
        //Get and set type options to data source
        $this->view_data['dataSource']['type'] = \Lang::get($this->package . '::' . $this->controller . '.data.type');
    }

//E# injectDataSources() function
}

//E# UpdateController() function