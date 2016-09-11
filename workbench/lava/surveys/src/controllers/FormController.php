<?php

namespace Lava\Surveys;

/**
 * S# FormController() function
 * Form controller
 * @author Edwin Mugendi
 */
class FormController extends SurveysBaseController {

    //Controller
    public $controller = 'form';
    
    public $imageable = true;
    /**
     * S# injectDataSources() function
     * @author Edwin Mugendi
     * Inject data source. This are mainly select
     * 
     * @param array $dataSource Data source
     */
    public function injectDataSources() {
        //Get and set workflow options to data source
        $this->view_data['dataSource']['workflow'] = \Lang::get($this->package . '::' . $this->controller . '.data.workflow');
    }

//E# injectDataSources() function
}

//E# FormController() function