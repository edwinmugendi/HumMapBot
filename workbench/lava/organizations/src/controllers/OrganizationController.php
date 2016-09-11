<?php

namespace Lava\Organizations;

/**
 * S# OrganizationController() function
 * Organizations controller
 * @author Edwin Mugendi
 */
class OrganizationController extends OrganizationsBaseController {

    //Controller
    public $controller = 'organization';

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
     * S# updateOrgSession() function
     * 
     * Update Org Session
     * 
     */
    public function updateOrgSession($org_id) {
        //Fields to select
        $fields = array('*');

        //Set where clause
        $where_clause = array(
            array(
                'where' => 'where',
                'column' => 'id',
                'operator' => '=',
                'operand' => $org_id
            )
        );

        //Set per page to parameters
        $parameters['lazyLoad'] = array('currency');

        //Set scope
        $parameters['scope'] = array('statusOne');

        //Select this organizations models
        $org_model = $this->select($fields, $where_clause, 1, $parameters);

        $session_org = \Session::put('org', $org_model);
    }

//E# updateOrgSession() function

    /**
     * S# sessionOrg() function
     * @author Edwin Mugendi
     * Get logged in user's organization
     * @return array The logged in user's organization
     */
    protected function sessionOrg($user_model) {
        $org_id = $user_model['organization_id'];

        //Set the default organization
        foreach ($user_model['organizations'] as $single_org) {
            if ($single_org['default']) {
                $org_id = $single_org['id'];
            }//E# if statement
        }//E# foreach statement
        //Fields to select
        $fields = array('*');

        //Set where clause
        $where_clause = array(
            array(
                'where' => 'where',
                'column' => 'id',
                'operator' => '=',
                'operand' => $org_id
            )
        );

        //Set per page to parameters
        $parameters['lazyLoad'] = array('currency');

        //Set scope
        $parameters['scope'] = array('statusOne');

        //Select this organizations models
        $org_model = $this->select($fields, $where_clause, 1, $parameters);

        $session_org = \Session::put('org', $org_model);

        if (!$user_model['organizations']) {
            $user_model['organizations'][] = $org_model->toArray();
        }
        //Build Organization Selector View
        $this->buildOrganizationSelectorView($user_model['organizations'], $org_id);

        return $session_org;
    }

//E# sessionOrg() function

    /**
     * S# postChangeOrg() function
     * 
     * Change Organization
     * 
     */
    public function postChangeOrg() {

        //Set parameters
        $parameters['lazyLoad'] = array('organizations');

        //Get user model
        $user_model = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getModelByField', array('id', $this->user['id'], $parameters));

        $org_name = '';
        foreach ($user_model['organizations'] as $single_org) {
            if ($single_org['id'] == $this->input['org_id']) {
                $single_org['default'] = 1;
                $org_name = $single_org['name'];
            } else {
                $single_org['default'] = 0;
            }//E# if else statement
            $single_org->save();
        }//E# foreach statement
        //Session organization
        $this->sessionOrg($user_model);

        //Set notification
        $this->notification = array(
            'type' => 'success',
            'message' => \Lang::get($this->package . '::' . $this->controller . '.view.organization_changed', array('name' => $org_name))
        );

        //Redirect to dashboard
        return \Redirect::route('userDashboard')->with('notification', $this->notification);
    }

//E# postChangeOrg() function

    /**
     * S# postChangeApp() function
     * 
     * Change App
     * 
     */
    public function postChangeApp() {

        //Get user model
        $user_model = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'changeUserApp', array($this->input['app']));

        //Set notification
        $this->notification = array(
            'type' => 'success',
            'message' => \Lang::get($this->package . '::' . $this->controller . '.view.app_changed', array('name' => \Str::upper($this->input['app'])))
        );

        //Redirect to dashboard
        return \Redirect::route('userDashboard')->with('notification', $this->notification);
    }

//E# postChangeApp() function

    /**
     * S# buildOrganizationSelectorView() function
     * 
     * Build the organization selector view at the top and session it
     * 
     * @param model $org_model Organization model
     * @param Array $organizations User organizations
     * @param int $org_id Default organization id
     */
    private function buildOrganizationSelectorView($organizations, $org_id) {
        $this->view_data = $this->prepareViewData('selector');

        $this->view_data['organizations'] = $organizations;
        $this->view_data['org_id'] = $org_id;

        $org_selector_view = \View::make($this->view_data['package'] . '::' . $this->view_data['controller'] . '.organizationSelectorView')
                        ->with('view_data', $this->view_data)->render();

        \Session::put('org_selector_view', $org_selector_view);
    }

}

//E# OrganizationController() function