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
        $this->view_data['start_date']->subDays(29);


        //Pie chart
        $this->view_data['pie_chart'] = array();

        //Set list side bar
        $this->view_data['sideBar'] = '';

        $this->view_data['dashboardView'] = '';

        //Manager view
        $this->view_data['dashboardView'] = \View::make($this->view_data['package'] . '::' . $this->view_data['controller'] . '.managerView')
                ->with('view_data', $this->view_data);

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

    private function getManagerData() {
        $parameters = array();

        //Set lazy load 
        $parameters['lazyLoad'] = array('locations', 'departments', 'job_categories', 'grades', 'employees');

        //Get user model by id
        $this->view_data['org_structure'] = $this->callController(\Util::buildNamespace('organizations', 'organization', 1), 'getModelByField', array('id', $this->org['id'], $parameters));

        //Get org structure
        $org_struture = $this->view_data['org_structure']->toArray();

        //Locations pie chart
        $this->view_data['pie_chart']['locations'] = $this->getChartData('locations', 'location_id', $org_struture);

        //Departments pie chart
        $this->view_data['pie_chart']['departments'] = $this->getChartData('departments', 'department_id', $org_struture);

        //Job Categories pie chart
        $this->view_data['pie_chart']['job_categories'] = $this->getChartData('job_categories', 'job_category_id', $org_struture);

        //Grades pie chart
        $this->view_data['pie_chart']['grades'] = $this->getChartData('grades', 'grade_id', $org_struture);
    }

    /**
     * S# getChartData() function
     */
    private function getChartData($structure, $structure_id, $org_model) {
        $pie_chart = array();
        foreach ($org_model[$structure] as $single_relation) {
            $datum['label'] = $single_relation['name'];
            $datum['data'] = 0;
            foreach ($org_model['employees'] as $single_user) {
                if ($single_user[$structure_id] == $single_relation['id']) {
                    $datum['data'] +=1;
                }//E# if statement
            }//E# foreach statement

            $pie_chart[] = $datum;
        }//E# foreach statement
        $total = 0;
        foreach ($pie_chart as $single_datum) {
            $total += $single_datum['data'];
        }//E# foreach statement
        $total_users = count($org_model['employees']);

        if ($total < $total_users) {
            $datum['label'] = \Lang::get($this->view_data['package'] . '::' . $this->view_data['controller'] . '.' . $this->view_data['page'] . '.managerView.employee.not_assigned');
            $datum['data'] = (int) ($total_users - $total);

            $pie_chart[] = $datum;
        }//E# if statement

        foreach ($pie_chart as &$single_datum) {
            $single_datum['label'] = $single_datum['label'] . ' (' . $single_datum['data'] . ')';
        }//E# foreach statement

        return $pie_chart;
    }

//E# getChartData() function

    /**
     * S# injectControllerSpecificJs() method
     * @author Edwin Mugendi
     * Inject controller specific js
     * @param string $js javascript
     */
    public function injectControllerSpecificJs(&$js) {
        $js['pie_chart'] = $this->view_data['pie_chart'];
    }

//E# injectControllerSpecificJs() method
}

//E# DashboardController() function