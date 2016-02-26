<?php

namespace Lava\Merchants;

/**
 * S# MerchantController() function
 * Merchants controller
 * @author Edwin Mugendi
 */
class MerchantController extends MerchantsBaseController {

    //Controller
    public $controller = 'merchant';
    
    /**
     * S# injectDataSources() function
     * @author Edwin Mugendi
     * Inject data source. This are mainly select
     * 
     * @param array $dataSource Data source
     */
    public function injectDataSources() {

        //Get and set country options for this country
        $this->view_data['dataSource']['country_id'] = $this->callController(\Util::buildNamespace('locations', 'country', 1), 'getSelectOptions');

        //Get and set timezone options for this country
        $this->view_data['dataSource']['timezone_id'] = $this->callController(\Util::buildNamespace('locations', 'timezone', 1), 'getSelectOptions');

        //Get and set currency options for this country
        $this->view_data['dataSource']['currency_id'] = $this->callController(\Util::buildNamespace('locations', 'currency', 1), 'getSelectOptions');

        //Get and set workflow options to data source
        $this->view_data['dataSource']['workflow'] = \Lang::get($this->package . '::' . $this->controller . '.data.workflow');

        //Get and set date format options to data source
        $this->view_data['dataSource']['date_format'] = \Lang::get($this->package . '::' . $this->controller . '.data.date_format');
    }

//E# injectDataSources() function

    /**
     * S# sessionMerchant() function
     * 
     * @author Edwin Mugendi
     * 
     * Get logged in user's merchant
     * @return array The logged in user's merchant
     */
    protected function sessionMerchant($user_model) {
        $merchant_id = $user_model['merchant_id'];
        //Set the default merchant

        foreach ($user_model['merchants'] as $single_merchant) {
            if ($single_merchant['default']) {
                $merchant_id = $single_merchant['id'];
            }//E# if statement
        }//E# foreach statement
        //Fields to select
        $fields = array('*');

        //Set where clause
        $whereClause = array(
            array(
                'where' => 'where',
                'column' => 'id',
                'operator' => '=',
                'operand' => $merchant_id
            )
        );

        //Set per page to parameters
        $parameters['lazyLoad'] = array('currency');

        //Set scope
        $parameters['scope'] = array('statusOne');

        //Select this merchants models
        $merchant_model = $this->select($fields, $whereClause, 1, $parameters);

        $session_merchant = \Session::put('merchant', $merchant_model);

        //Build Merchant Selector View
        $this->buildMerchantSelectorView($user_model['merchants'], $merchant_id);

        return $session_merchant;
    }

//E# sessionMerchant() function

    /**
     * S# postChangeMerchant() function
     * 
     * Change Merchant
     * 
     */
    public function postChangeMerchant() {
        
        //Set parameters
        $parameters['lazyLoad'] = array('merchants');

        //Get user model
        $user_model = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getModelByField', array('id', $this->user['id'], $parameters));

        $merchant_name = '';
        foreach ($user_model['merchants'] as $single_merchant) {
            if ($single_merchant['id'] == $this->input['merchant_id']) {
                $single_merchant['default'] = 1;
                $merchant_name = $single_merchant['name'];
            } else {
                $single_merchant['default'] = 0;
            }//E# if else statement
            $single_merchant->save();
        }//E# foreach statement
        
        //Session merchant
        $this->sessionMerchant($user_model);

        //Set notification
        $this->notification = array(
            'type' => 'success',
            'message' => \Lang::get($this->package . '::' . $this->controller . '.view.merchant_changed', array('name' => $merchant_name))
        );

        //Redirect to dashboard
        return \Redirect::to('/')->with('notification', $this->notification);
    }

//E# postChangeMerchant() function

    /**
     * S# buildMerchantSelectorView() function
     * 
     * Build the merchant selector view at the top and session it
     * 
     * @param Array $merchants User merchants
     * @param int $merchant_id Default merchant id
     */
    private function buildMerchantSelectorView($merchants, $merchant_id) {
        $this->view_data = $this->prepareViewData('selector');

        $this->view_data['merchants'] = $merchants;
        $this->view_data['merchant_id'] = $merchant_id;

        $merchant_selector_view = \View::make($this->view_data['package'] . '::' . $this->view_data['controller'] . '.merchantSelectorView')
                        ->with('view_data', $this->view_data)->render();

        \Session::put('merchant_selector_view', $merchant_selector_view);
    }

}

//E# MerchantController() function