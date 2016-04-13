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
    
    /**
     * S# roleBasedWhereClause() function
     * @author Edwin Mugendi
     * Build where clause based on role
     * 
     * @param array $fields Fields
     * @param array $where_clause Where clause
     * @param array $parameters Parameters
     */
    public function roleBasedWhereClause($fields, &$where_clause, &$parameters) {
        if ($this->user['role_id'] == 2) {//Merchant
            $where_clause[] = array(
                'where' => 'where',
                'column' => 'merchant_id',
                'operator' => '=',
                'operand' => $this->merchant['id']
            );
        }
    }

    //E# roleBasedWhereClause() function

    /**
     * S# injectDataSources() function
     * @author Edwin Mugendi
     * Inject data source. This are mainly select
     * 
     * @param array $dataSource Data source
     */
    public function injectDataSources() {

        //Get this organization merchant id
        $this->view_data['dataSource']['merchant_id'] = $this->appGetCustomMerchantHtmlSelect();

        //Get this organization location id
        $this->view_data['dataSource']['location_id'] = $this->callController(\Util::buildNamespace('merchants', 'location', 1), 'getMerchantsHtmlSelect', array($this->merchant['id'], 'id', array('name'), \Lang::get('common.select')));
        
       
        //Get and set loyable options to data source
        $this->view_data['dataSource']['loyable'] = \Lang::get($this->package . '::' . $this->controller . '.data.loyable');
        
        
    }

//E# injectDataSources() function
}

//E# ProductController() function