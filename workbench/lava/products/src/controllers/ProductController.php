<?php

namespace Lava\Products;

/**
 * S# ProductsController() function
 * Product controller
 * @author Edwin Mugendi
 */
class ProductController extends ProductsBaseController {

    //Controller
    public $controller = 'product';
    public $imageable = true;

    /**
     * S# injectDataSources() function
     * @author Edwin Mugendi
     * Inject data source. This are mainly select
     * 
     * @param array $dataSource Data source
     */
    public function injectDataSources() {

        //Get this organization merchant id
        $this->view_data['dataSource']['merchant_id'] = array('' => 'Select', $this->merchant['id'] => $this->merchant['name']);

        //Get this organization location id
        $this->view_data['dataSource']['location_id'] = $this->callController(\Util::buildNamespace('merchants', 'location', 1), 'getMerchantsHtmlSelect', array($this->merchant['id'], 'id', array('name'), \Lang::get('common.select')));

        //Get and set loyable options to data source
        $this->view_data['dataSource']['loyable'] = \Lang::get($this->package . '::' . $this->controller . '.data.loyable');
    }

//E# injectDataSources() function
}

//E# ProductController() function