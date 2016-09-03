<?php

namespace Lava\Accounts;

/**
 * S# AppController() function
 * App controller
 * @author Edwin Mugendi
 */
class AppController extends AccountsBaseController {

    //Controller
    public $controller = 'app';

    public function getRegister() {
        $this->view_data = $this->prepareViewData('register');

        return \View::make($this->view_data['package'] . '::' . $this->view_data['controller'] . '.registerView');
    }

}

//E# AppController() function