<?php

namespace Lava\Accounts;

use Carbon\Carbon;

/**
 * S# DashboardController() function
 * Dashboard Controller
 * @author Edwin Mugendi
 */
class DashboardController extends AccountsBaseController {

    //Controller
    public $controller = 'dashboard';
    //Owned by
    public $ownedBy = array('organization');

    /**
     * S# injectControllerSpecificJs() method
     * @author Edwin Mugendi
     * Inject controller specific js
     * @param string $js javascript
     */
    public function injectControllerSpecificJs(&$js) {
        $js['start_date'] = $this->view_data['start_date']->format('Y-m-d');
        $js['end_date'] = $this->view_data['end_date']->format('Y-m-d');
    }

//E# injectControllerSpecificJs() method

    /**
     * S# getDashboard() function
     * @author Edwin Mugendi
     * Render Dashboard Page
     * @return page Dashboard Page
     */
    public function getDashboard() {
        //Turn off imageable	
        $this->imageable = false;
        //Add validation assets
        $this->add_validation_assets = true;
        //Prepare view data
        $this->view_data = $this->prepareViewData('dashboard');

        //Start date
        $this->view_data['start_date'] = Carbon::now();
        $this->view_data['end_date'] = $this->view_data['start_date']->copy();
        //End date
        $this->view_data['start_date']->subDays(6);

        //Set list side bar
        $this->view_data['sideBar'] = '';

        $this->view_data['dashboardView'] = '';

        //Set layout's title
        $this->layout->title = \Lang::get($this->view_data['package'] . '::' . $this->view_data['controller'] . '.' . $this->view_data['page'] . '.title');

        //Get and set layout's inline javascript
        $this->layout->inlineJs = $this->injectInlineJs($this->view_data);

        //Register css and js assets for this page
        $this->layout->assets = $this->registerAssets($this->view_data);

        //Set layout's top bar partial
        $this->layout->topBarPartial = $this->getTopBarPartialView();

        //Set layout's side bar partial
        $this->layout->sideBarPartial = $this->getSideBarPartialView();

        //Load content view
        $this->view_data['contentView'] = \View::make($this->view_data['package'] . '::' . $this->view_data['controller'] . '.' . $this->view_data['view'])
                ->with('view_data', $this->view_data);

        //Set container view
        $this->layout->containerView = $this->getContainerViewPartialView();

        //Register templates
        $this->layout->containerView .= $this->registerListTemplates();

        //Render page
        return $this->layout;
    }

//E# getDashboard() function

    /**
     * S# getGraph() function
     * Get graph
     */
    public function getGraph() {

        //Start and end date
        $start_date = new Carbon($this->input['start_date']);
        $end_date = new Carbon($this->input['end_date']);

        //Fields
        $fields = array('*');

        //Where clause
        $whereClause = array(
            array(
                'where' => 'whereBetween',
                'column' => 'date',
                'operand' => array($start_date, $end_date)
            ),
            array(
                'where' => 'where',
                'column' => 'workflow',
                'operator' => '=',
                'operand' => 1
            )
        );

        if ($this->user['role_id'] == 2) {
            $whereClause[] = array(
                'where' => 'where',
                'column' => 'merchant_id',
                'operator' => '=',
                'operand' => $this->user['merchant_id']
            );
        }//E# if statement
        //Order by id in descending order
        $parameters['orderBy'][] = array('date' => 'asc');

        //Status
        $parameters['scope'] = array('statusOne');

        //Get model
        $transaction_model = $this->callController(\Util::buildNamespace('payments', 'transaction', 1), 'select', array($fields, $whereClause, 2, $parameters));

        //Line chart
        $line_chart = array();
        $transaction_count = $transaction_total = 0;
        $unique_customer_ids = $top_customers_array = $new_customers_array = $line_graph = array();
        if ($transaction_model) {
            //Get unique customer ids
            $unique_customer_ids = array_unique($transaction_model->lists('user_id'));

            foreach ($transaction_model as $single_model) {
                //Increment total and count
                $transaction_count++;
                $transaction_total +=$single_model->amount;

                /* Top customer */

                if (array_key_exists($single_model->user_id, $top_customers_array)) {
                    $top_customers_array[$single_model->user_id]['amount'] += $single_model->amount;
                    $top_customers_array[$single_model->user_id]['count'] += 1;
                } else {
                    $top_customers_array[$single_model->user_id] = array(
                        'name' => $single_model->user_id_text,
                        'user_id' => $single_model->user_id,
                        'amount' => $single_model->amount,
                        'count' => 1,
                    );
                }//E# if else statement

                /* Line Graph* */
                $unix_timestamp = strtotime($single_model->date);

                if (array_key_exists($unix_timestamp, $line_graph)) {
                    $line_graph[$unix_timestamp][1] += (float) $single_model->amount;
                } else {
                    $line_graph[$unix_timestamp] = array($unix_timestamp, (float) $single_model->amount);
                }//E# if else statement
            }//E# foreach statement
        }//E# if else statement
        //Get new customer count
        $new_customers = $this->getNewCustomerCount($unique_customer_ids, $start_date);

        //Sort top customer
        $top_customers = $this->sortTopCustomers($top_customers_array);

        $line_chart = array();

        foreach ($line_graph as $single_graph) {
            $single_graph[0] = '' . $single_graph[0] . '000';

            $line_chart[] = $single_graph;
        }//E# foreach statement

        $graph_min_date = $graph_max_date = 0;

        if ($line_chart) {
            $graph_min_date = $line_chart[0][0];
            $graph_max_date = $line_chart[count($line_chart) - 1][0];
        }//E# if statement
        //dd($top_customers_array);
        return json_encode([
            'transaction_count' => number_format($transaction_count),
            'transaction_total' => number_format($transaction_total, 2),
            'new_customers' => number_format($new_customers),
            'graph_data' => $line_chart,
            'top_customers' => $top_customers,
            'graph_min_date' => $graph_min_date,
            'graph_max_date' => $graph_max_date,
        ]);
    }

//E# getGraph() function

    private function sortTopCustomers($top_customers_array) {
        //Prepare view data
        $this->view_data = $this->prepareViewData('top_customer');

        $top_customer_view = '';
        $colors = array('aero', 'green', 'blue');
        $color_index = 0;
        foreach ($top_customers_array as $single_customer) {

            $this->view_data['color'] = $colors[$color_index];
            $this->view_data['single_customer'] = $single_customer;
            //Top customer view
            $top_customer_view .= \View::make($this->view_data['package'] . '::' . $this->view_data['controller'] . '.topCustomerView')
                    ->with('view_data', $this->view_data);

            $color_index++;

            if ($color_index == 4) {
                $color_index = 0;
            }//E# if else statement
        }//E# foreach statement

        return $top_customer_view;
    }

    /**
     * S# getNewCustomerCount() function
     * 
     * Get new customer count
     * 
     * @param array $unique_user_ids Unique user ids
     * @param Object $start_date Start date
     */
    private function getNewCustomerCount($unique_user_ids, $start_date) {
        $count = 0;

        foreach ($unique_user_ids as $single_user_id) {
            //Fields
            $fields = array('*');

            //Where clause
            $whereClause = array(
                array(
                    'where' => 'where',
                    'column' => 'date',
                    'operator' => '<',
                    'operand' => $start_date->format('Y-m-d')
                ),
                array(
                    'where' => 'where',
                    'column' => 'workflow',
                    'operator' => '=',
                    'operand' => 1
                ),
                array(
                    'where' => 'where',
                    'column' => 'user_id',
                    'operator' => '=',
                    'operand' => $single_user_id
                )
            );

            if ($this->user['role_id'] == 2) {
                $whereClause[] = array(
                    'where' => 'where',
                    'column' => 'merchant_id',
                    'operator' => '=',
                    'operand' => $this->user['merchant_id']
                );
            }//E# if statement
            //Status
            $parameters['scope'] = array('statusOne');

            //Get model
            $transaction_model = $this->callController(\Util::buildNamespace('payments', 'transaction', 1), 'select', array($fields, $whereClause, 1, $parameters));

            if (!$transaction_model) {
                $count++;
            }//E# if statement
        }//E# foreach statement

        return $count;
    }

//E# getNewCustomerCount() function

    private function checkIfDayExists($array, $value) {
        $index = 0;
        foreach ($array as $singleData) {
            if ($singleData['y'] == $value) {
                return $index;
            }//E# if else statement
            $index++;
        }//E# foreach statement

        return -1;
    }

}

//E# DashboardController() function