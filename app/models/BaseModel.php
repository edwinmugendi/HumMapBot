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
        
        if (array_key_exists('token',$userController->input)) {//Token exists
             
            //Get user model by token
            return $userController->getModelByField('token', $userController->input['token']);
            
        }//E# if statement
        
        return null;
    }

//E# getUserIfTokenExists() function
}//E# BaseModel() class
