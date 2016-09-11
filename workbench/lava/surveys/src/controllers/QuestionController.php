<?php

namespace Lava\Surveys;

/**
 * S# QuestionController() function
 * Question controller
 * @author Edwin Mugendi
 */
class QuestionController extends SurveysBaseController {

    //Controller
    public $controller = 'question';

    /**
     * S# injectDataSources() function
     * @author Edwin Mugendi
     * Inject data source. This are mainly select
     * 
     * @param array $dataSource Data source
     */
    public function injectDataSources() {
        //Get and set type options to data source
        $this->view_data['dataSource']['type'] = \Lang::get($this->package . '::' . $this->controller . '.data.type');
    }

//E# injectDataSources() function
}

//E# QuestionController() function