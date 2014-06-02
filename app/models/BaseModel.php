<?php


/**
 * S# BaseModel() Class
 * @author Edwin Mugendi
 * Base Model
 */

class BaseModel extends \Eloquent {

    //This will be set if a valid user token is passed
    public $loggedInUser;

    public function __construct() {
        parent::__construct();

        $this->loggedInUser = $this->getUserIfTokenExists();
    }

    /**
     * S# getUserIfTokenExists() function
     * If the user token exist, cache the user
     */
    public function getUserIfTokenExists() {
       
        //Create user controller
        $userController = new Lava\Accounts\UserController();
        
        if ($userController->input['token']) {//Token exists
            
            //Get user model by token
            $this->loggedInUser = $userController->getModelByField('token', $userController->input['token']);
            
        }//E# if statement
    }

//E# getUserIfTokenExists() function
}//E# BaseModel() class
