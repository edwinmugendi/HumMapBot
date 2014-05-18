<?php

namespace Lava\Accounts;

use Symfony\Component\Translation\TranslatorInterface;
use Carbon\Carbon;

class AccountsValidator extends \Illuminate\Validation\Validator {

    //Message object
    private $message;

    //TODO Set message fro the 2 validators and more accurate

    /**
     * S# validateLatLng() function
     * Validate latitude and longitude object exists
     * @param array $attribute Validation attribute
     * @param array $location The location array with latitude and longitude
     * @param array $parameters Parameters
     */
    public function validateLatLng($attribute, $location, $parameters) {

        if (array_key_exists('lat', $location) && array_key_exists('lng', $location)) {//Lat & lng exist
            $lat = (int) $location['lat'];
            $lng = (int) $location['lng'];

            if (($lat >= -90 && $lat <= 90) && ($lng >= -180 && $lng <= 180)) {//Valid
                return true;
            }//E# if statement
        }//# if statement

        return false;
    }

//E# validateLatLng() function

    /**
     * S# validateResetCode() function
     * Validate the reset code has not expired
     * @param array $attribute Validation attribute
     * @param array $resetCode The reset code
     * @param array $parameters Parameters
     */
    public function validateResetCode($attribute, $resetCode, $parameters) {

        $userController = new UserController();

        //Fields to select
        $fields = array('*');

        //Build where clause
        $whereClause = array(
            array(
                'where' => 'where',
                'column' => 'email',
                'operator' => '=',
                'operand' => $this->data['email']
            ),
            array(
                'where' => 'where',
                'column' => 'reset_code',
                'operator' => '=',
                'operand' => $this->data['reset_code']
            )
        );

        //Get user by email and reset code
        $userModel = $userController->select($fields, $whereClause, 1);

        if ($userModel) {//user exists
            //Create reset time and now
            $resetTime = new Carbon($userModel->reset_time);
            $now = Carbon::now();

            //Get time out from configs
            $timeout = \Config::get('accounts::account.resetCodeTimeout');

            //Find the difference in minutes
            $minutesDiff = $now->diffInMinutes($resetTime);

            if ($minutesDiff < $timeout) {//Within time out
                return true;
            }//E# if statement
        }//E# if statement

        return false;
    }

//E# validateResetCode() function

    /**
     * S# validateLogin() function
     * Validate latitude and longitude object exists
     * @param array $attribute Validation attribute
     * @param array $password The password
     * @param array $parameters Parameters
     */
    public function validateLogin($attribute, $password, $parameters) {

        //Set credentials
        $credentials = array('email' => $this->data['email'], 'password' => $password);

        //Parameters
        $parameters = array();

        //Set parameters
        $parameters['lazyLoad'] = array('logins', 'app55');

        //User controller
        $userController = new UserController();

        //Get user by email
        $userModel = $userController->getModelByField('email', $credentials['email'], $parameters);

        if ($userModel) {//User with this email exist
            //Previous logins deleted
            $deleted = 0;

            //Get lockout
            $lockOut = \Config::get($userController->package . '::account.lockOut');

            //Now 
            $now = Carbon::now();

            foreach ($userModel->logins as $singleLogin) {//Loop through this user login models
                //Get login time
                $attemptTime = Carbon::createFromFormat('Y-m-d G:i:s', $singleLogin->date_time);

                //Get time difference in minutes
                $minDifference = $now->diffInMinutes($attemptTime);

                if (($minDifference > $lockOut) && ($singleLogin->ip_address == $this->data['ipAddress'])) {//Expired logins
                    //Delete this login model
                    $singleLogin->delete();
                    //Increment counter
                    $deleted++;
                }//E# if statement
            }//E# foreach statement

            if ((count($userModel->logins) - $deleted) >= \Config::get($userController->package . '::account.loginAttempts')) {//User has exceeded the login attempts
                //Set message
                $this->message = \Lang::get($userController->package . '::' . $userController->controller . '.userRegistrationPage.userRegistrationView.form.login.statusCode.3', array('lockOut' => $lockOut));
            } else {

                if (\Auth::attempt($credentials)) {//User is logged in
                    //Generate user token
                    $userController->updateLoginSpecificFields($userController, $userModel);

                    return true;
                } else {//Incorrect credentials
                    //Set message
                    $this->message = \Lang::get($userController->package . '::' . $userController->controller . '.userRegistrationPage.userRegistrationView.form.login.statusCode.1');

                    //Increase login attempts
                    //Define Login row
                    $loginRow = array(
                        'user_id' => $userModel->id,
                        'ip_address' => $this->data['ipAddress'],
                        'date_time' => $now,
                        'status' => 1,
                        'created_by' => 1, //USER_ID
                        'updated_by' => 1//USER_ID
                    );

                    //Create an issue
                    $userController->callController(\Util::buildNamespace('accounts', 'login', 1), 'createIfValid', array($loginRow, true));
                }//E# if else statement
            }//E# if else statement
        } else {//User with this email does not exist
            //Set message
            $this->message = \Lang::get($userController->package . '::' . $userController->controller . '.userRegistrationPage.userRegistrationView.form.login.statusCode.2');
        }//E# if else statement   

        return false;
    }

//E# validateLogin() function
    /**
     * S# replaceLogin() function
     * Replace status parameter in login validaion string
     * @param $string $message The message
     * @param $string $attribute The attribute
     * @param $string $rule The rule
     * @param array $parameters The parameters
     */
    protected function replaceLogin($message, $attribute, $rule, $parameters) {
        return $this->message;
    }

//E# replaceLogin() function

    /**
     * S# validateFacebookLogin() function
     * Validate facebook login token
     * @param array $attribute Validation attribute
     * @param array $token The token
     * @param array $parameters Parameters
     */
    public function validateFacebookLogin($attribute, $token, $parameters) {
        //User controller
        $userController = new UserController();

        //Get FB configs
        $fbConfig = array(
            'appId' => \Config::get($userController->package . '::thirdParty.facebook.appId'),
            'secret' => \Config::get($userController->package . '::thirdParty.facebook.appSecret'),
            'scope' => \Config::get($userController->package . '::thirdParty.facebook.scope'),
            'allowSignedRequest' => false,
        );
        try {
            //Call Facebook
            $fb = new \Facebook($fbConfig);

            $fb->setAccessToken($token);

            //Try getting user
            $fbUserId = $fb->getUser();

            if ($fbUserId) {//User exists
                //Get user profile from facebook
                $fbUserProfile = $fb->api('/me', 'GET');

                // dd($fb->api('/permissions','GET'));
                /*
                  array(11) {
                  ["id"]=>
                  string(15) "100008234582074"
                  ["first_name"]=>
                  string(4) "Open"
                  ["gender"]=>
                  string(4) "male"
                  ["last_name"]=>
                  string(4) "User"
                  ["link"]=>
                  string(55) "https://www.facebook.com/profile.php?id=100008234582074"
                  ["locale"]=>
                  string(5) "en_US"
                  ["middle_name"]=>
                  string(10) "Graph Test"
                  ["name"]=>
                  string(20) "Open Graph Test User"
                  ["timezone"]=>
                  int(0)
                  ["updated_time"]=>
                  string(24) "2014-04-17T12:17:27+0000"
                  ["verified"]=>
                  bool(false)
                  }
                 */
                //  dd($fbUserProfile);
                $parameters['lazyLoad'] = array('logins', 'app55');
                //Get user by facebook id
                $userModel = $userController->getModelByField('fb_uid', $fbUserId, $parameters);

                if ($userModel) {//User has already signed in facebook
                    if (!$userModel->app55) {//User does not an app55 account
                        $userController->createApp55User($userModel->id, $userModel->email, $userModel->first_name, $userModel->last_name, $userModel->phone);
                    }//E# if statement
                    //Update user fields
                    $userController->updateLoginSpecificFields($userController, $userModel);
                } else {//Register
                    $newUser = array(
                        'fb_uid' => $fbUserId,
                        'first_name' => $fbUserProfile['first_name'],
                        'last_name' => $fbUserProfile['last_name'],
                        'gender' => $fbUserProfile['gender'] ? $fbUserProfile['gender'] : '',
                        'status' => (int) $fbUserProfile['verified'],
                        'created_by' => 1,
                        'updated_by' => 1,
                        'email' => 'edwinmugendi@gmail.com'//TODO remove this
                    );

                    //Create user
                    $userModel = $userController->createIfValid($newUser, true);

                    $userController->afterCreating($userModel);
                    $userController->updateLoginSpecificFields($userController, $userModel);
                }//E# if else statement
            } else {
                //Set validation message
                $this->message = \Lang::get($userController->package . '::' . $userController->controller . '.validation.facebook.noUser');
            }//E# if else statement
        } catch (FacebookApiException $e) {
            dd($e->getMessage());
            throw new \Api500Exception($e->getMessage());
        }//E# try catch exception
        return false;
    }

//E# validateFacebookLogin() function

    /**
     * S# replaceFacebookLogin() function
     * Replace status parameter in login validaion string
     * @param $string $message The message
     * @param $string $attribute The attribute
     * @param $string $rule The rule
     * @param array $parameters The parameters
     */
    protected function replaceFacebookLogin($message, $attribute, $rule, $parameters) {
        return $this->message;
    }

//E# replaceFacebookLogin() function

    /**
     * S# validateCheckRegistry() function
     * Validate facebook login token
     * @param array $attribute Validation attribute
     * @param boolean $checkRegistry Check registry value
     * @param array $parameters Parameters
     */
    public function validateCheckRegistry($attribute, $checkRegistry, $parameters) {
        if (!$this->data['force']) {//Check Registry
            $this->message = \Lang::get('accounts::vehicle.validation.checkRegistry');

            return $this->validateUnique($attribute, $this->data['vrm'], array('acc_vehicles', 'vrm', 'NULL', 'id'));
        }//E# if statement

        return true;
    }

//E# validateCheckRegistry() function

    /**
     * S# replaceCheckRegistry() function
     * Replace status parameter in login validaion string
     * @param $string $message The message
     * @param $string $attribute The attribute
     * @param $string $rule The rule
     * @param array $parameters The parameters
     */
    protected function replaceCheckRegistry($message, $attribute, $rule, $parameters) {
        return $this->message;
    }

//E# replaceCheckRegistry() function

    /**
     * S# validateApi() function
     * Validate Api filter
     * @param array $attribute Validation attribute
     * @param boolean $token The token
     * @param array $parameters Parameters
     */
    public function validateApi($attribute, $token, $parameters) {
        //Create user controller
        $userController = new UserController();

        //Get user by token
        $userModel = $userController->getModelByField('token', $token);

        if ($userModel) {//User exists
            if (\Auth::check() == false) {//User not logged in
                //Login user
                \Auth::login(\Auth::loginUsingId($userModel->id));

                //Session user
                $userController->sessionUser($userModel);
            }//E# if statement

            return true;
        }//E# if statement
        //Set validation message
        $this->message = \Lang::get($userController->package . '::' . $userController->controller . '.validation.api');

        return false;
    }

//E# validateApi() function

    /**
     * S# replaceApi() function
     * Replace status parameter in login validaion string
     * @param $string $message The message
     * @param $string $attribute The attribute
     * @param $string $rule The rule
     * @param array $parameters The parameters
     */
    protected function replaceApi($message, $attribute, $rule, $parameters) {
        return $this->message;
    }

//E# replaceApi() function

    /**
     * S# validateVrmDelete() function
     * Validate Vrm Delete
     * @param array $attribute Validation attribute
     * @param boolean $vrm The vrm
     * @param array $parameters Parameters
     */
    public function validateVrmDelete($attribute, $vrm, $parameters) {
        //Create vehicle controller
        $vehicleController = new VehicleController();

        //Get vehicle by vrm
        $vehicleModel = $vehicleController->callController(\Util::buildNamespace('accounts', 'vehicle', 1), 'getModelByField', array('vrm', $vrm));

        if ($vehicleModel) {//Vehicle does not exist
            if ($vehicleModel->user_owns) {
                //Delete this vehicle in the pivot table
                $vehicleController->updatePivotTable($vehicleModel, 'users', $vehicleModel->id, array('is_default' => 0, 'dropped_at' => Carbon::now()));

                //Get success message
                $message = \Lang::get($vehicleController->package . '::' . $vehicleController->controller . '.api.delete', array('field' => 'vrm', 'value' => $vrm));

                throw new \Api200Exception(array('id' => $vehicleModel->id, 'vrm' => $vrm), $message);
            } else {
                //Set validation message
                $this->message = \Lang::get($userController->package . '::' . $userController->controller . '.validation.api');
                return false;
            }
        }//E# if statement
        //Set notification
        $vehicleController->notification = array(
            'field' => 'vrm',
            'type' => 'Vehicle',
            'value' => $vrm,
        );

        //Throw VRM not found error
        throw new \Api404Exception($vehicleController->notification);

        return false;
    }

//E# validateVrmDelete() function

    /**
     * S# replaceVrmDelete() function
     * Replace status parameter in login validaion string
     * @param $string $message The message
     * @param $string $attribute The attribute
     * @param $string $rule The rule
     * @param array $parameters The parameters
     */
    protected function replaceVrmDelete($message, $attribute, $rule, $parameters) {
        return $this->message;
    }

//E# replaceVrmDelete() function

    /**
     * S# validateUserOwnsVrm() function
     * Validate user owns this vrm
     *
     * @author Edwin Mugendi <edwinmugendi@gmail.com>
     * @param  string  $attribute
     * @param  mixed   $vrm
     * @param  mixed   $parameters
     * @return bool
     */
    protected function validateUserOwnsVrm($attribute, $vrm, $parameters) {
        //Intialize a vehicle controller object
        $vehicleController = new VehicleController();

        $vehicleModel = $vehicleController->getModelByField('vrm', $vrm);

        if ($vehicleModel) {//Vehicle exists
            if ($vehicleModel->user_owns) {//Logged in user owns this vehicle
                return $vehicleModel;
            } else {//Don't own
                //Set message
                $this->message = \Lang::get($vehicleController->package . '::' . $vehicleController->controller . '.validation.userOwns', array('vrm' => $vrm));
            }//E# if else statement
        } else {
            //Set notification
            $vehicleController->notification = array(
                'field' => 'vrm',
                'type' => 'Vehicle',
                'value' => $vrm,
            );

            //Throw VRM not found error
            throw new \Api404Exception($vehicleController->notification);
        }//E# if else statement
        return false;
    }

//E# validateUserOwnsVrm() function

    /**
     * S# replaceUserOwnsVrm() function
     * Replace all place-holders for the  user owns vrm rule.
     *
     * @author Edwin Mugendi <edwinmugendi@gmail.com>
     * @param  string  $message
     * @param  string  $attribute
     * @param  string  $rule
     * @param  array   $parameters
     * @return string
     */
    protected function replaceUserOwnsVrm($message, $attribute, $rule, $parameters) {
        return $message;
    }

//E# replaceUserOwnsVrm() function
}
