<?php

namespace Lava\Forms;

/**
 * S# ContactController() function
 * Contact controller
 * @author Edwin Mugendi
 */
class ContactController extends FormsBaseController {

    //Controller
    public $controller = 'contact';

    /**
     * S# injectDataSources() function
     * @author Edwin Mugendi
     * Inject data source. This are mainly select
     * 
     * @param array $dataSource Data source
     */
    public function injectDataSources() {
        //Get and set gender options to data source
        $this->view_data['dataSource']['gender'] = \Lang::get($this->package . '::' . $this->controller . '.data.gender');
        
                //Get and set workflow options to data source
        $this->view_data['dataSource']['workflow'] = \Lang::get($this->package . '::' . $this->controller . '.data.workflow');

        //Get and set food chicken options to data source
        $this->view_data['dataSource']['food_fish'] = $this->view_data['dataSource']['food_chicken'] = \Lang::get($this->package . '::' . $this->controller . '.data.yes_no');
    }

//E# injectDataSources() function
}

//E# ContactController() function