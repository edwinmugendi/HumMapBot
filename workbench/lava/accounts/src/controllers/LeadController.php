<?php

namespace Lava\Accounts;

/**
 * S# LeadController() function
 * Lead Controller
 * @author Edwin Mugendi
 */
class LeadController extends AccountsBaseController {

    //Controller
    public $controller = 'lead';

    public function postWorkflow() {
        //dd($this->input);
        $this->validationRules = array(
            'id' => 'required|exists:acc_leads',
            'action' => 'required|integer',
        );

        $this->validator = \Validator::make($this->input, $this->validationRules);

        if ($this->validator->fails()) {
            //Set notification
            $this->notification = array(
                'type' => 'danger',
                'message' => $this->formatErrors($this->validator->messages()->all(':message,'))
            );
        } else {
            //TODO: Create Org
            //TODO: Create user
            //TODO: Send user Set password email
            //Get lead by id
            $lead_model = $this->getModelByField('id', $this->input['id']);

            //Get model by email
            $user_model = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getModelByField', array('email', $lead_model->email));
            
              
            if ($user_model) {//Exists already
                //Set notification
                $this->notification = array(
                    'type' => 'danger',
                    'message' => 'User with email already exists'
                );
            } else {//Email does not exists
                //Account created
                $account_created = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'createAccount', array($lead_model->toArray()));
                
                //Account created
                $lead_model->action = $this->input['action'];
                
                //Save lead 
                $lead_model->save();
                
                //Set notification
                $this->notification = array(
                    'type' => 'success',
                    'message' => 'Account created'
                );
            }//E# if else statement
        }//E# if else statement

        return $this->notification;
    }

    /**
     * S# getListSideBarPartialView() method
     * @author Edwin Mugendi
     * Return side bar partial view for each page
     * @return view the side bar partial view
     */
    public function getListSideBarPartialView() {
        //Get and return the global side bar partial
        return '';
    }

//E# getListSideBarPartialView() method

    /**
     * S# injectDataSources() function
     * @author Edwin Mugendi
     * Inject data source. This are mainly select
     * 
     * @param array $dataSource Data source
     */
    public function injectDataSources() {

        //Get and set country options for this country
        $this->view_data['dataSource']['country_id'] = $this->callController(\Util::buildNamespace('locations', 'country', 1), 'getSelectOptions', array('en', 'alphaList'));

        //Get and set workflow options to data source
        $this->view_data['dataSource']['workflow'] = \Lang::get($this->package . '::' . $this->controller . '.data.workflow');

        //Get and set action options to data source
        $this->view_data['dataSource']['action'] = \Lang::get($this->package . '::' . $this->controller . '.data.action');

        //Get and set source options to data source
        $this->view_data['dataSource']['source'] = \Lang::get($this->package . '::' . $this->controller . '.data.source');
    }

//E# injectDataSources() function
}

//E# LeadController() function