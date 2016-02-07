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
    //Lazy load
    public $lazyLoad = array();
    //Owned by
    public $ownedBy = array('user');

    /**
     * S# controllerSpecificWhereClause() function
     * @author Edwin Mugendi
     * 
     * Set controller specific where clause
     * @param array $fields Fields
     * @param array $whereClause Where clause
     * @param array $parameters Parameters
     */
    public function controllerSpecificWhereClause(&$fields, &$whereClause, &$parameters) {

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
            }//E# if statement
        }//E# if statement
    }

//E# controllerSpecificWhereClause() function
}

//E# TransactionController() function