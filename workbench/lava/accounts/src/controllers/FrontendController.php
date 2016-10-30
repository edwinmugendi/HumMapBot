<?php

namespace Lava\Accounts;

/**
 * S# FrontendController() function
 * Frontend controller
 * 
 * @author Edwin Mugendi
 * 
 */
class FrontendController extends AccountsBaseController {

    //Controller
    public $controller = 'frontend';
    public $theme = 'frontend';

    /**
     * S# getRegistration() function
     * @author Edwin Mugendi
     * Load the following pages
     * 1. Register page
     * 2. Login page
     * 3. Reset password page
     * 4. Forgot password page
     */
    public function getHome() {

        $this->layout = 'layouts.frontend';

        $this->setupLayout();

        //Prepare view data
        $this->view_data = $this->prepareViewData('frontend');


        //Set layout's title
        $this->layout->title = \Lang::get($this->view_data['package'] . '::' . $this->view_data['controller'] . '.' . $this->view_data['page'] . '.title');

        //Get and set layout's inline javascript
        $this->layout->inlineJs = $this->injectInlineJs($this->view_data);

        //Register css and js assets for this page
        $this->layout->assets = $this->registerAssets($this->view_data);

        //Set layout's top bar partial
        $this->layout->topBarPartial = '';

        //Set layout's side bar partial
        $this->layout->sideBarPartial = '';

        //Load slider view
        $this->view_data['sliderView'] = \View::make($this->view_data['package'] . '::' . $this->view_data['controller'] . '.subpage.sliderView')
                ->with('view_data', $this->view_data);

        //Load content view
        $this->view_data['contentView'] = \View::make($this->view_data['package'] . '::' . $this->view_data['controller'] . '.' . $this->view_data['view'])
                ->with('view_data', $this->view_data);

        //Set container view
        $this->layout->containerView = $this->view_data['contentView'];

        //Render page
        return $this->layout;
    }

//E# getRegistration() function
}

//E# FrontendController() function