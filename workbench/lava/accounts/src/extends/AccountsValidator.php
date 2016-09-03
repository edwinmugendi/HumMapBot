<?php

namespace Lava\Accounts;

use Symfony\Component\Translation\TranslatorInterface;
use Lava\Payments\CardController;
use Carbon\Carbon;

class AccountsValidator extends \Illuminate\Validation\Validator {

    //Message object
    private $message;
    //Data object
    private $custom_data = array();

    //TODO Set message fro the 2 validators and more accurate

    /**
     * S# validateCheckDate() function
     * Validate check date
     * @param array $attribute Validation attribute
     * @param string $date $date
     * @param array $parameters Parameters
     */
    public function validateCheckDate($attribute, $date, $parameters) {
        $user_model = new UserController();

        $this->custom_data['date_format'] = $date_format = $user_model->getDateFormat();

        $db_format = $user_model->convertDateFormat($date_format);

        $parsed = date_parse_from_format($db_format, $date);

        return $parsed['error_count'] === 0 && $parsed['warning_count'] === 0;
    }

//E# validateCheckDate() function

    /**
     * S# replaceCheckDate() function
     * Replace all place-holders for the check_date rule.
     *
     * @author Edwin Mugendi <edwinmugendi@gmail.com>
     * @param  string  $message
     * @param  string  $attribute
     * @param  string  $rule
     * @param  array   $parameters
     * @return string
     */
    protected function replaceCheckDate($message, $attribute, $rule, $parameters) {
        return str_replace(':format', $this->custom_data['date_format'], $message);
    }

//E# replaceCheckDate() function

    /**
     * S# validateNewVehicleId() function
     * Validate vehicle id belongs to the user
     * @param array $attribute Validation attribute
     * @param string $vehicle_id Vehicle Id
     * @param array $parameters Parameters
     */
    public function validateVehicleId($attribute, $vehicle_id, $parameters) {

        //Instantiate a new user controller
        $vehicle_controller = new VehicleController();

        //Fields to select
        $fields = array('*');

        //Build where clause
        $where_clause = array(
            array(
                'where' => 'where',
                'column' => 'user_id',
                'operator' => '=',
                'operand' => $vehicle_controller->user['id']
            ),
            array(
                'where' => 'where',
                'column' => 'id',
                'operator' => '=',
                'operand' => $this->data['vehicle_id']
            ),
            array(
                'where' => 'where',
                'column' => 'status',
                'operator' => '=',
                'operand' => 1
            )
        );

        //Get vehicle
        $vehicle_model = $vehicle_controller->select($fields, $where_clause, 1);

        if (!$vehicle_model) {
            //Set notification
            $vehicle_controller->notification = array(
                'field' => 'id',
                'type' => 'Vehicle',
                'value' => $this->data['vehicle_id'],
            );

            //Throw not found error
            throw new \Api404Exception($vehicle_controller->notification);
        }//E# if statement
        return true;
    }

//E# validateVehicleId() function

    /**
     * S# validateCardId() function
     * Validate card id belongs to the user
     * @param array $attribute Validation attribute
     * @param string $card_id Card Id
     * @param array $parameters Parameters
     */
    public function validateCardId($attribute, $card_id, $parameters) {

        //Instantiate a new user controller
        $card_controller = new CardController();

        //Fields to select
        $fields = array('*');

        //Build where clause
        $where_clause = array(
            array(
                'where' => 'where',
                'column' => 'user_id',
                'operator' => '=',
                'operand' => $card_controller->user['id']
            ),
            array(
                'where' => 'where',
                'column' => 'id',
                'operator' => '=',
                'operand' => $this->data['card_id']
            ),
            array(
                'where' => 'where',
                'column' => 'status',
                'operator' => '=',
                'operand' => 1
            )
        );

        //Get card
        $card_model = $card_controller->select($fields, $where_clause, 1);

        if (!$card_model) {
            //Set notification
            $card_controller->notification = array(
                'field' => 'id',
                'type' => 'Card',
                'value' => $this->data['card_id'],
            );

            //Throw not found error
            throw new \Api404Exception($card_controller->notification);
        }//E# if statement
        return true;
    }

//E# validateCardId() function

    /**
     * S# replaceVehicleId() function
     * Replace all place-holders for the new_password rule.
     *
     * @author Edwin Mugendi <edwinmugendi@gmail.com>
     * @param  string  $message
     * @param  string  $attribute
     * @param  string  $rule
     * @param  array   $parameters
     * @return string
     */
    protected function replaceVehicleId($message, $attribute, $rule, $parameters) {
        return $this->message;
    }

//E# replaceVehicleId() function

    /**
     * S# validateNewPassword() function
     * Validate update password
     * @param array $attribute Validation attribute
     * @param string $newPassword New Password
     * @param array $parameters Parameters
     */
    public function validatePassword($attribute, $newPassword, $parameters) {

        //Instantiate a new user controller
        $user_controller = new UserController();

        if (isset($this->data['new_password'])) {

            if ($this->validateMin($attribute, $this->data['new_password'], array(6))) {
                if (isset($this->data['old_password'])) {

                    //Get user model by token
                    $user_model = $user_controller->getModelByField('token', $this->data['token']);

                    if (\Hash::check($this->data['old_password'], $user_model->password)) {
                        $this->data['password'] = $this->input['password'] = \Hash::make($newPassword);
                        return true;
                    } else {
                        //Set message
                        $this->message = \Lang::get($user_controller->package . '::' . $user_controller->controller . '.validation.password.oldPasswordWrong');

                        return false;
                    }//E# if else statement
                } else {
                    //Set message
                    $this->message = \Lang::get($user_controller->package . '::' . $user_controller->controller . '.validation.password.oldPasswordRequired');

                    return false;
                }//E# if statement
            } else {
                //Set message
                $this->message = \Lang::get($user_controller->package . '::' . $user_controller->controller . '.validation.password.newPasswordMin', array('min' => 6));

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

        /* Checks if send to is email, else reverts to phone
          if (filter_var($this->data['send_to'], FILTER_VALIDATE_EMAIL)) {
          $field = 'email';
          } else {
          $field = 'phone';
          }//E# if else statement
         */

        $user_controller = new UserController();

        //Fields to select
        $fields = array('*');

        //Build where clause
        $where_clause = array(
            array(
                'where' => 'where',
                'column' => $this->data['id_field'],
                'operator' => '=',
                'operand' => $this->data['phone_or_email']
            ),
            array(
                'where' => 'where',
                'column' => 'reset_code',
                'operator' => '=',
                'operand' => $this->data['reset_code']
            )
        );

        //Get user by email and reset code
        $user_model = $user_controller->select($fields, $where_clause, 1);

        if ($user_model) {//user exists
            //Create reset time and now
            $resetTime = new Carbon($user_model->reset_time);
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
        $credentials = array($this->data['id_field'] => $this->data['phone_or_email'], 'password' => $password);

        //Parameters
        $parameters = array();

        //Set parameters
        $parameters['lazyLoad'] = array('logins', 'merchants');

        //User controller
        $user_controller = new UserController();

        //Get user by email
        $user_model = $user_controller->getModelByField($this->data['id_field'], $credentials[$this->data['id_field']], $parameters);

        if ($user_model) {//User with this email exist
            //Previous logins deleted
            $deleted = 0;

            //Get lockout
            $lockOut = \Config::get($user_controller->package . '::account.lockOut');

            //Now 
            $now = Carbon::now();

            foreach ($user_model->logins as $singleLogin) {//Loop through this user login models
                //Get login time
                $attemptTime = Carbon::createFromFormat('Y-m-d G:i:s', $singleLogin->date_time);

                //Get time difference in minutes
                $minDifference = $now->diffInMinutes($attemptTime);

                if (($minDifference > $lockOut) && ($singleLogin->ip == $this->data['ip'])) {//Expired logins
                    //Delete this login model
                    $singleLogin->delete();
                    //Increment counter
                    $deleted++;
                }//E# if statement
            }//E# foreach statement

            if ((count($user_model->logins) - $deleted) >= \Config::get($user_controller->package . '::account.loginAttempts')) {//User has exceeded the login attempts
                //Set message
                $this->message = \Lang::get($user_controller->package . '::' . $user_controller->controller . '.userRegistrationPage.userRegistrationView.form.login.statusCode.3', array('lockOut' => $lockOut));
            } else {

                if (\Auth::attempt($credentials)) {//User is logged in
                    //Generate user token
                    $user_controller->updateLoginSpecificFields($user_controller, $user_model);

                    if (array_key_exists('format', $this->data) && ($this->data['format'] == 'json')) {//API
                        //Push token
                        if (array_key_exists('device_token', $this->data)) {
                            $user_model->device_token = $this->data['device_token'];
                        }//E# if else statement
                        //App version
                        if (array_key_exists('app_version', $this->data)) {
                            $user_model->app_version = $this->data['app_version'];
                        }//E# if else statement
                        //Os
                        if (array_key_exists('os', $this->data)) {
                            $user_model->os = $this->data['os'];
                        }//E# if else statement
                        //Save user
                        $user_model->save();

                        //Get success message
                        $message = \Lang::get($user_controller->package . '::' . $user_controller->controller . '.notification.login');

                        throw new \Api200Exception($user_model->toArray(), $message);
                    }//E# if statement

                    return true;
                } else {//Incorrect credentials
                    //Set message
                    $this->message = \Lang::get($user_controller->package . '::' . $user_controller->controller . '.userRegistrationPage.userRegistrationView.form.login.statusCode.1');

                    //Increase login attempts
                    //Define Login row
                    $login_row = array(
                        'user_id' => $user_model->id,
                        'date_time' => $now,
                        'agent' => $this->data['agent'],
                        'ip' => $this->data['ip'],
                        'status' => 1,
                        'created_by' => 1, //USER_ID
                        'updated_by' => 1//USER_ID
                    );

                    //Create an issue
                    $user_controller->callController(\Util::buildNamespace('accounts', 'login', 1), 'createIfValid', array($login_row, true));
                }//E# if else statement
            }//E# if else statement
        } else {//User with this email does not exist
            //Set message
            $this->message = \Lang::get($user_controller->package . '::' . $user_controller->controller . '.userRegistrationPage.userRegistrationView.form.login.statusCode.2');
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
     * S# validateCheckRegistry() function
     * Validate facebook login token
     * @param array $attribute Validation attribute
     * @param boolean $checkRegistry Check registry value
     * @param array $parameters Parameters
     */
    public function validateCheckRegistry($attribute, $checkRegistry, $parameters) {
        if (!$this->data['force']) {//Check Registry
            $this->message = \Lang::get('accounts::vehicle.notification.check_registry');

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
        $user_controller = new UserController();

        //Parameters
        $parameters = array();

        //Set parameters
        $parameters['lazyLoad'] = array('merchants');

        //Get user by token
        $user_model = $user_controller->getModelByField('token', $token, $parameters);

        if ($user_model) {//User exists
            //Login user
            \Auth::login(\Auth::loginUsingId($user_model->id));

            //Session user
            $user_controller->sessionUser($user_model);

            return true;
        }//E# if statement
        //Set validation message
        $this->message = \Lang::get($user_controller->package . '::' . $user_controller->controller . '.validation.api');

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
        $vehicle_controller = new VehicleController();

        $parameters['scope'] = array('statusOne');
        //Get vehicle by id
        $vehicle_model = $vehicle_controller->getModelByField('id', $id, $parameters);

        if ($vehicle_model) {//Vehicle does not exist
            if ($vehicle_model->user_id = \Auth::user()->id) {

                $vehicle_model->status = 2;

                $vehicle_model->save();
                //Get success message
                $message = \Lang::get($vehicle_controller->package . '::' . $vehicle_controller->controller . '.notification.deleted');

                throw new \Api200Exception(array('id' => $vehicle_model->id, 'id' => $id), $message);
            }//E# if statement
        }//E# if statement
        //Set notification
        $vehicle_controller->notification = array(
            'field' => 'id',
            'type' => 'Vehicle',
            'value' => $id,
        );

        //Throw VRM not found error
        throw new \Api404Exception($vehicle_controller->notification);

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
     * S# validateUserOwnsVehicle() function
     * Validate user owns this vehicle_id
     *
     * @author Edwin Mugendi <edwinmugendi@gmail.com>
     * @param  string  $attribute
     * @param  mixed   $vehicle_id
     * @param  mixed   $parameters
     * @return bool
     */
    protected function validateUserOwnsVehicle($attribute, $vehicle_id, $parameters) {
        //Intialize a vehicle controller object
        $vehicle_controller = new VehicleController();

        $vehicle_model = $vehicle_controller->getModelByField('id', $vehicle_id);

        if ($vehicle_model) {//Vehicle exists
            if ($vehicle_model->user_id == \Auth::user()->id) {//Logged in user owns this vehicle
                return $vehicle_model;
            } else {//Don't own
                //Set message
                $this->message = \Lang::get($vehicle_controller->package . '::' . $vehicle_controller->controller . '.notification.user_owns', array('vehicle_id' => $vehicle_id));
            }//E# if else statement
        } else {//Vehicle does exists
            //Set notification
            $vehicle_controller->notification = array(
                'field' => 'vehicle_id',
                'type' => 'Vehicle',
                'value' => $vehicle_id,
            );

            //Throw VRM not found error
            throw new \Api404Exception($vehicle_controller->notification);
        }//E# if else statement
        return false;
    }

//E# validateUserOwnsVehicle() function

    /**
     * S# replaceUserOwnsVehicle() function
     * Replace all place-holders for the  user owns vehicle_id rule.
     *
     * @author Edwin Mugendi <edwinmugendi@gmail.com>
     * @param  string  $message
     * @param  string  $attribute
     * @param  string  $rule
     * @param  array   $parameters
     * @return string
     */
    protected function replaceUserOwnsVehicle($message, $attribute, $rule, $parameters) {
        return $message;
    }

//E# replaceUserOwnsVehicle() function
}
