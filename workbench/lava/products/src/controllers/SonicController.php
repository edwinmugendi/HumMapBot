<?php

namespace Lava\Products;

/**
 * S# SonicController() function
 * Sonic controller
 * @author Edwin Mugendi
 */
class SonicController extends ProductsBaseController {

    //Controller
    public $controller = 'sonic';

    /**
     * S# getCallback() function
     * Callback
     */
    public function getCallback() {

        //IP check 
        if (!\App::environment('local')) {
            if (!in_array($this->input['ipAddress'], \Config::get('thirdParty.sonic.trustedIps'))) {
                return "Untrusted IP";
            }//E# if statement
        }//E# if statement
        //Prepare Application user id
        if (array_key_exists('applicationUserId', $this->input)) {
            $this->input['user_id'] = $this->input['applicationUserId'];
        }//E# if statement
        //Prepare event id
        if (array_key_exists('eventId', $this->input)) {
            $this->input['event_id'] = $this->input['eventId'];
        }//E# if statement
        //Prepare rewards
        if (array_key_exists('rewards', $this->input)) {
            $this->input['points'] = $this->input['rewards'];
        }//E# if statement
        //Prepare item name
        if (array_key_exists('itemName', $this->input)) {
            $this->input['item_name'] = $this->input['itemName'];
        }//E# if statement
        //Validate the call using the signature
        if (md5($this->input['timestamp'] . $this->input['event_id'] . $this->input['user_id'] . $this->input['points'] . \Config::get('thirdParty.sonic.secret')) != $this->input['signature']) {
            //return;
        }//E# if statement
        //Get model by event id
        $sonicModel = $this->getModelByField('event_id', $this->input['event_id']);

        if ($sonicModel) {//Negative
            if (((int) $sonicModel->negated == 0)) {
                //Reduce points
                $sonicModel->points = ($sonicModel->points - $this->input['points']);

                //Mark as negated
                $sonicModel->negated = 1;

                $sonicModel->save();
            }//E# if statement
        } else {//Positive
            //Create sonic model
            $this->createIfValid($this->input, true);
        }//E# if statement

        return $this->input['event_id'] . ":OK";
    }

//E# getCallback() function
}

//E# SonicController() function