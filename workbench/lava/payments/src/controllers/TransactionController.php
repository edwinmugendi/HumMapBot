<?php

namespace Lava\Payments;

/**
 * S# TransactionController() function
 * Transaction Controller
 * @author Edwin Mugendi
 */
class TransactionController extends PaymentsBaseController {

    //Controller
    public $controller = 'transaction';

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

        //Get this organization user id
        $this->view_data['dataSource']['user_id'] = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getMerchantsHtmlSelect', array($this->merchant['id'], 'id', array('first_name', 'last_name'), \Lang::get('common.select')));

        //Get this organization promotion id
        $this->view_data['dataSource']['promotion_id'] = $this->callController(\Util::buildNamespace('products', 'promotion', 1), 'getMerchantsHtmlSelect', array($this->merchant['id'], 'id', array('code'), \Lang::get('common.select')));

        //Get this organization product id
        $this->view_data['dataSource']['product_id'] = $this->callController(\Util::buildNamespace('products', 'product', 1), 'getMerchantsHtmlSelect', array($this->merchant['id'], 'id', array('name'), \Lang::get('common.select')));

        //Get this organization location id
        $this->view_data['dataSource']['location_id'] = $this->callController(\Util::buildNamespace('merchants', 'location', 1), 'getMerchantsHtmlSelect', array($this->merchant['id'], 'id', array('name'), \Lang::get('common.select')));

        //Get this organization merchant id
        $this->view_data['dataSource']['merchant_id'] = array('' => 'Select', $this->merchant['id'] => $this->merchant['name']);

        //Get and set workflow options to data source
        $this->view_data['dataSource']['workflow'] = \Lang::get($this->package . '::' . $this->controller . '.data.workflow');

        //Get and set gateway options to data source
        $this->view_data['dataSource']['gateway'] = \Lang::get($this->package . '::' . $this->controller . '.data.gateway');

        //Get and set gateway options to data source
        $this->view_data['dataSource']['gateway'] = \Lang::get($this->package . '::' . $this->controller . '.data.gateway');
    }

//E# injectDataSources() function

    /**
     * S# controllerSpecificWhereClause() function
     * @author Edwin Mugendi
     * 
     * Set controller specific where clause
     * @param array $fields Fields
     * @param array $where_clause Where clause
     * @param array $parameters Parameters
     */
    public function controllerSpecificWhereClause(&$fields, &$where_clause, &$parameters) {

        if (array_key_exists('format', $this->input) && ($this->input['format'] == 'json')) {//From API
            if (array_key_exists('id', $this->input)) {

                //Get model by id
                $transaction_model = $this->getModelByField('id', $this->input['id']);

                //dd($transaction_model->count());
                if ($transaction_model && ($transaction_model->status == 1) && ($transaction_model->user_id == $this->user['id'])) {
                    $message = \Lang::get($this->package . '::' . $this->controller . '.notification.list');

                    $transaction_array = $transaction_model->toArray();

                    unset($transaction_array['user']);

                    //Throw Transaction not found error
                    throw new \Api200Exception($transaction_array, $message);
                } else {
                    //Set notification
                    $this->notification = array(
                        'field' => 'transaction_id',
                        'type' => 'Transaction',
                        'value' => $this->input['id'],
                    );

                    //Throw Transaction not found error
                    throw new \Api404Exception($this->notification);
                }//E# if else statement
            } else {
            $where_clause[] = array(
                'where' => 'where',
                'column' => 'user_id',
                'operator' => '=',
                'operand' => $this->user['id']
            );
        }//E# if else statement
        }//E# if statement
    }

//E# controllerSpecificWhereClause() function
}

//E# TransactionController() function