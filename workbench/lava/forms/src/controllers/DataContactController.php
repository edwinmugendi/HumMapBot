<?php
namespace Lava\Forms;

/**
* S# DataContactController() function
* DataContactController* @author Edwin Mugendi
*/
class DataContactController extends FormsBaseController {

//Controller
public $controller = 'data_contact';

//Imageable
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

//E# DataContactController() function