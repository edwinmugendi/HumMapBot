<?php
namespace Lava\Forms;

/**
* S# TestingController() function
* TestingController* @author Edwin Mugendi
*/
class TestingController extends FormsBaseController {

//Controller
public $controller = 'testing';

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

//E# TestingController() function