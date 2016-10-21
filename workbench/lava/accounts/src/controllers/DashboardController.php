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

        //Get form details
        $this->getFormDetails();

        //Set list side bar
        $this->view_data['sideBar'] = '';

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
     * S# getFormDetails() function
     * 
     * Get form details
     * 
     * 
     */
    private function getFormDetails() {
        //Fields to select
        $fields = array('*');

        //Build where clause
        $where_clause = array(
            array(
                'where' => 'where',
                'column' => 'user_id',
                'operator' => '=',
                'operand' => $this->user['id']
            ),
            array(
                'where' => 'where',
                'column' => 'status',
                'operator' => '=',
                'operand' => 1
            )
        );

        //Select form model
        $form_model = $this->callController(\Util::buildNamespace('surveys', 'form', 1), 'select', array($fields, $where_clause, 2));

        //Form count
        $this->view_data['form_count'] = count($form_model);

        $this->view_data['forms'] = array();
        if ($form_model) {
            foreach ($form_model as $single_form) {
                $fields = array('*');
                $where_clause = array();
                $parameters['count'] = true;

                $form_controller = \Str::lower(str_replace(' ', '_', $single_form->name));
                //Select form model
                $form_model_count = $this->callController(\Util::buildNamespace('forms', $form_controller, 1), 'select', array($fields, $where_clause, 2, $parameters));

                $this->view_data['forms'][] = array(
                    'name' => $single_form->name,
                    'count' => $form_model_count,
                );
            }//E# foreach statement   
        }//E# if statement
    }

//E# getFormDetails() function
}

//E# DashboardController() function