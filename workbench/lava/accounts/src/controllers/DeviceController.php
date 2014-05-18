<?php

namespace Lava\Accounts;

/**
 * S# DeviceController() function
 * Account controller
 * @author Edwin Mugendi
 */
class DeviceController extends AccountsBaseController {

    //Controller
    public $controller = 'device';

    /**
     * S# beforeCreating() function
     * @author Edwin Mugendi
     * Call this just before creating the model
     * Can be used to prepare the inputs
     * @param array $input The input
     * @return 
     */
    public function beforeCreating() {
        $this->input['user_id'] = $this->user['id'];
        $this->input['status'] = 1;
        $this->input['created_by'] = $this->user['id'] ? $this->user['id'] : 1;
        $this->input['updated_by'] = $this->user['id'] ? $this->user['id'] : 1;
    }

//E# beforeCreating() function
}

//E# DeviceController() function