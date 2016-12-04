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

        $parameters = array();

        $parameters['lazyLoad'] = array('sessions', 'messages', 'updates');

        $this->view_data['org_model'] = $this->callController(\Util::buildNamespace('organizations', 'organization', 1), 'getModelByField', array('id', $this->org['id'], $parameters));

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
}

//E# DashboardController() function