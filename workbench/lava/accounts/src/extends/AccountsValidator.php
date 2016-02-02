<?php

namespace Lava\Accounts;

use Symfony\Component\Translation\TranslatorInterface;
use Carbon\Carbon;

class AccountsValidator extends \Illuminate\Validation\Validator {

    //Message object
    private $message;

    //TODO Set message fro the 2 validators and more accurate

    /**
     * S# validateNewPassword() function
     * Validate update password
     * @param array $attribute Validation attribute
     * @param string $newPassword New Password
     * @param array $parameters Parameters
     */
    public function validatePassword($attribute, $newPassword, $parameters) {

        //Instantiate a new user controller
        $userController = new UserController();

        if (isset($this->data['new_password'])) {

            if ($this->validateMin($attribute, $this->data['new_password'], array(6))) {
                if (isset($this->data['old_password'])) {

                    //Get user model by token
                    $userModel = $userController->getModelByField('token', $this->data['token']);

                    if (\Hash::check($this->data['old_password'], $userModel->password)) {
                        $this->data['password'] = $this->input['password'] = \Hash::make($newPassword);
                        return true;
                    } else {
                        //Set message
                        $this->message = \Lang::get($userController->package . '::' . $userController->controller . '.validation.password.oldPasswordWrong');

                        return false;
                    }//E# if else statement
                } else {
                    //Set message
                    $this->message = \Lang::get($userController->package . '::' . $userController->controller . '.validation.password.oldPasswordRequired');

                    return false;
                }//E# if statement
            } else {
                //Set message
                $this->message = \Lang::get($userController->package . '::' . $userController->controller . '.validation.password.newPasswordMin', array('min' => 6));

                return false;
            }//E# if else statement
        }//E# if statement
        return true;
    }

//E# validateNewPassword() function

    /**
     * S# replaceNewPassword() function
     * Replace all place-holders for the new_password rule.
     *
     * @author Edwin Mugendi <edwinmugendi@gmail.com>
     * @param  string  $message
     * @param  string  $attribute
     * @param  string  $rule
     * @param  array   $parameters
     * @return string
     */
    protected function replacePassword($message, $attribute, $rule, $parameters) {
        return $this->message;
    }

//E# replaceNewPassword() function

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

        //Checks if send to is email, else reverts to phone
        if (filter_var($this->data['send_to'], FILTER_VALIDATE_EMAIL)) {
            $field = 'email';
        } else {
            $field = 'phone';
        }//E# if else statement


        $userController = new UserController();

        //Fields to select
        $fields = array('*');

        //Build where clause
        $whereClause = array(
            array(
                'where' => 'where',
                'column' => $field,
                'operator' => '=',
                'operand' => $this->data['send_to']
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
        $parameters['lazyLoad'] = array('logins');

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
            $fbUserId = trim($fb->getUser());

            if ($fbUserId) {//User exists
                //Get user profile from facebook
                $fbUserProfile = $fb->api('/me', 'GET');

                //Fields to select
                $fields = array('*');

                //Build where clause
                $whereClause = array(
                    array(
                        'where' => 'orWhere',
                        'column' => 'email',
                        'operator' => '=',
                        'operand' => trim($fbUserProfile['email'])
                    ),
                    array(
                        'where' => 'orWhere',
                        'column' => 'fb_uid',
                        'operator' => '=',
                        'operand' => $fbUserId
                    )
                );

                //Get user by facebook id
                $userModel = $userController->select($fields, $whereClause, 1);

                if ($userModel) {//User has already signed in facebook
                    if (!$userModel->app55_id) {//User does not an app55 account
                        $userController->createApp55User($userModel);
                    }//E# if statement
                    //Update users email and fb uid
                    $userModel->email = $fbUserProfile['email'];
                    $userModel->fb_uid = $fbUserId;

                    //Update user login specific fields
                    $userController->updateLoginSpecificFields($userController, $userModel);
                } else {//Register
                    $newUser = array(
                        'fb_uid' => $fbUserId,
                        'first_name' => $fbUserProfile['first_name'],
                        'last_name' => $fbUserProfile['last_name'],
                        'gender' => $fbUserProfile['gender'] ? $fbUserProfile['gender'] : '',
                        'status' => (int) $fbUserProfile['verified'],
                        'dob' => Carbon::createFromFormat('m/d/Y', $fbUserProfile['birthday']),
                        'created_by' => 1,
                        'updated_by' => 1,
                        'role_id' => 1,
                        'notify_sms' => 1,
                        'notify_push' => 1,
                        'notify_email' => 1,
                        'email' => $fbUserProfile['email']//TODO remove this
                    );

                    //Create user
                    $userModel = $userController->createIfValid($newUser, true);

                    //Post create callback
                    $userController->afterCreating($userModel);

                    //Update login specific fields
                    $userController->updateLoginSpecificFields($userController, $userModel);
                }//E# if else statement
            } else {
                //Set validation message
                $this->message = \Lang::get($userController->package . '::' . $userController->controller . '.validation.facebook.noUser');
            }//E# if else statement
        } catch (FacebookApiException $e) {
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
            //Login user
            \Auth::login(\Auth::loginUsingId($userModel->id));

            //Session user
            $userController->sessionUser($userModel);

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
     * S# validateDeleteVehicle() function
     * Validate Id Delete
     * @param array $attribute Validation attribute
     * @param boolean $id The id
     * @param array $parameters Parameters
     */
    public function validateDeleteVehicle($attribute, $id, $parameters) {
        //Create vehicle controller
        $vehicleController = new VehicleController();

        //Get vehicle by id
        $vehicleModel = $vehicleController->getModelByField('id', $id);

        if ($vehicleModel) {//Vehicle does not exist
            if ($vehicleModel->user_owns) {
                //Instantiate a new user controller
                $userController = new UserController();

                //Get user model by token
                $userModel = $userController->getModelByField('token', $this->data['token']);

                //Delete this vehicle in the pivot table
                $vehicleController->updatePivotTable($userModel, 'vehicles', $vehicleModel->id, array('dropped_at' => Carbon::now()));

                if ($userModel && \Str::lower($userModel->vrm) == \Str::lower($vehicleModel->vrm)) {//User exists
                    //Clear users default
                    $userModel->vrm = '';

                    //TODO update default
                    //Save user
                    $userModel->save();
                }//E# if statement
                //Get success message
                $message = \Lang::get($vehicleController->package . '::' . $vehicleController->controller . '.notification.deleted');

                throw new \Api200Exception(array('id' => $vehicleModel->id, 'id' => $id), $message);
            }//E# if statement
        }//E# if statement
        //Set notification
        $vehicleController->notification = array(
            'field' => 'id',
            'type' => 'Vehicle',
            'value' => $id,
        );

        //Throw VRM not found error
        throw new \Api404Exception($vehicleController->notification);

        return false;
    }

//E# validateDeleteVehicle() function

    /**
     * S# replaceDeleteVehicle() function
     * Replace status parameter in login validaion string
     * @param $string $message The message
     * @param $string $attribute The attribute
     * @param $string $rule The rule
     * @param array $parameters The parameters
     */
    protected function replaceDeleteVehicle($message, $attribute, $rule, $parameters) {
        return $this->message;
    }

//E# replaceDeleteVehicle() function

    /**
     * S# validateDeleteCard() function
     * Validate Id Delete
     * @param array $attribute Validation attribute
     * @param boolean $id The id
     * @param array $parameters Parameters
     */
    public function validateDeleteCard($attribute, $id, $parameters) {
        //Create card controller
        $cardController = new \Lava\Payments\CardController();
        
        //Set scope
        $parameters['scope'] = array('statusOne');

        //Get card by id
        $cardModel = $cardController->getModelByField('id', $id, $parameters);
        
        if ($cardModel) {//Card does not exist
            //Instantiate a new user controller
            $userController = new UserController();

            //Get user model by token
            $userModel = $userController->getModelByField('token', $this->data['token']);

            if ($cardModel->created_by == $userModel->id) {


                //Delete card on stripe
                $stripe_controller = new \Lava\Payments\StripeController();
                $stripe_response = $stripe_controller->deleteCard($userModel->stripe_id, $cardModel->token);
                $cardModel->deleted_on_stripe = $stripe_response['status'] ? 1 : 0;

                $cardModel->status = 2;
                $cardModel->save();

                if ($cardModel->token == $userModel->card) {
                    $userModel->card = '';

                    $userModel->save();
                }//E# if statement
                //Get success message
                $message = \Lang::get($cardController->package . '::' . $cardController->controller . '.notification.deleted');

                throw new \Api200Exception(array('id' => $cardModel->id, 'id' => $id), $message);
            }
        }//E# if statement
        //Set notification
        $cardController->notification = array(
            'field' => 'id',
            'type' => 'Card',
            'value' => $id,
        );

        //Throw VRM not found error
        throw new \Api404Exception($cardController->notification);

        return false;
    }

//E# validateDeleteCard() function

    /**
     * S# replaceDeleteCard() function
     * Replace status parameter in login validaion string
     * @param $string $message The message
     * @param $string $attribute The attribute
     * @param $string $rule The rule
     * @param array $parameters The parameters
     */
    protected function replaceDeleteCard($message, $attribute, $rule, $parameters) {
        return $this->message;
    }

//E# replaceDeleteCard() function

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
        } else {//Vehicle does exists
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
