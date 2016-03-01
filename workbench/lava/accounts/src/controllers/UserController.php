<?php

namespace Lava\Accounts;

use Carbon\Carbon;

class UserController extends AccountsBaseController {

    //Controller
    public $controller = 'user';

    /**
     * S# controllerSpecificWhereClause() function
     * @author Edwin Mugendi
     * 
     * Set controller specific where clause
     * @param array $fields Fields
     * @param array $where_clause Where clause
     * @param array $parameters Parameters
     */
    public function controllerSpecificWhereClause(&$fields, &$where_clause, &$parameters) {

        if (array_key_exists('format', $this->input) && ($this->input['format'] == 'json')) {//From API
        } else {
            if ($this->user['role_id'] == 2) {//Merchant
                //Transaction fields
                $transaction_fields = array('user_id');

                //Transaction where clause
                $transaction_where_clause = array(
                    array(
                        'where' => 'where',
                        'column' => 'merchant_id',
                        'operator' => '=',
                        'operand' => $this->user['merchant_id']
                    )
                );

                //Get transactions
                $transaction_model = $this->callController(\Util::buildNamespace('payments', 'transaction', 1), 'select', array($transaction_fields, $transaction_where_clause, 2));

                if ($transaction_model) {
                    $user_ids = array_unique($transaction_model->lists('user_id'));
                } else {
                    $user_ids = array(0);
                }//E# if else statement
                
                $where_clause[] = array(
                    'where' => 'whereIn',
                    'column' => 'id',
                    'operand' => $user_ids
                );
            }//E# if statement
        }//E# if else statement
    }

//E# controllerSpecificWhereClause() function

    /**
     * S# appendCustomValidationRules() function
     * 
     * Append custom validation rules.
     * 
     * This mainly happens when we need to access the id of object. Eg when updating an object with unique validation rule in it
     * 
     * Make sure you have if else for create and update
     * if($this->crudId == 2){}
     */
    public function appendCustomValidationRules() {
        if (!array_key_exists('format', $this->input)) {
            $this->validationRules = array(
                'first_name' => 'required',
                'last_name' => 'required',
                'merchant_id' => 'required|integer|exists:mct_merchants,id',
                'email' => 'required|unique:acc_users',
                'role_id' => 'required'
            );

            if ($this->crudId == 2) {
                $this->validationRules['email'] = 'required|unique:acc_users,email,' . $this->input['id'] . ',id';
            }//E# if statement
        }
        return;
    }

//E# appendCustomValidationRules() function

    /**
     * S# injectDataSources() function
     * @author Edwin Mugendi
     * Inject data source. This are mainly select
     * 
     * @param array $dataSource Data source
     */
    public function injectDataSources() {

        //Get this organization merchant id
        $this->view_data['dataSource']['merchant_id'] = $this->appGetCustomMerchantHtmlSelect();


        //Get and set yes no options to data source
        $this->view_data['dataSource']['notify_sms'] = $this->view_data['dataSource']['notify_email'] = $this->view_data['dataSource']['notify_push'] = \Lang::get($this->package . '::' . $this->controller . '.data.yes_no');

        //Get and set role options to data source
        $this->view_data['dataSource']['role_id'] = \Lang::get($this->package . '::' . $this->controller . '.data.role_id');

        if ($this->user['role_id'] == 1) {
            unset($this->view_data['dataSource']['role_id'][3]);
        } else {
            unset($this->view_data['dataSource']['role_id'][1]);
            unset($this->view_data['dataSource']['role_id'][3]);
        }//E# if statement
    }

//E# injectDataSources() function

    /**
     * S# getIsEmailAvailable() function
     * @author Edwin Mugendi
     * Check if Email is available
     * @return json the success or failure notification
     * @throws \Api200Exception if call is from API
     */
    public function getIsEmailAvailable() {

        //Get the validation rules
        $this->validationRules = array(
            'email' => 'required|email'
        );

        //Validate row to be inserted
        $validation = $this->isInputValid();

        if ($validation->fails()) {
            //Set notification
            $this->notification = array(
                'email', false
            );
            //Return the notification a as JSON
            return \Response::json($this->notification);
        } else {

            if (array_key_exists('format', $this->input) && ($this->input['format'] == 'json')) {
                $user_model = $this->getModelByField('email', $this->input['email']);
                throw $user_model ? new \Api200Exception(0, '') : new \Api200Exception(1, '');
            }//E# if statement
            //Set notification
            $this->notification = array(
                'email', true
            );
            //Return the notification a as JSON
            return \Response::json($this->notification);
        }//E# if statement
    }

//E# getIsEmailAvailable() function

    /**
     * S# beforeCreating() function
     * @author Edwin Mugendi
     * Call this just before creating the model
     * Can be used to prepare the inputs
     * @param array $input The input
     * @return 
     */
    public function beforeCreating() {
        if (array_key_exists('format', $this->input) && ($this->input['format'] == 'json')) {
            //Notifications
            $this->input['notify_sms'] = $this->input['notify_email'] = $this->input['notify_push'] = 1;

            //Prepare other fields
            $this->input['password'] = \Hash::make($this->input['password']);
            $this->input['verification_code'] = $this->generateUniqueField('verification_code', 42);
            if (array_key_exists('location', $this->input)) {
                $this->input['lat'] = $this->input['location']['lat'];
                $this->input['lng'] = $this->input['location']['lng'];
            }//E# if statement
            //User the users role
            $this->input['role_id'] = 3; //Customer

            $this->input['status'] = 0;
            $this->input['created_by'] = $this->input['updated_by'] = 1;
        } else {
            if ($this->user['role_id'] == 2) {
                $this->input['role_id'] = 1;
            }//E# if statement

            $this->input['status'] = 1;
            $this->input['created_by'] = $this->input['updated_by'] = $this->user['id'];
        }
    }

//E# beforeCreating() function

    /**
     * S# afterCreating() function
     * @author Edwin Mugendi
     * Call this just after creating the model
     * Can be used to prepare the inputs
     * @param array $input The input
     * @param object $contollerModel The model created
     * @return 
     */
    public function afterCreating(&$controller_model) {

        if (array_key_exists('format', $this->input) && ($this->input['format'] == 'json')) {
            //Create stripe user
            $this->createStripeUser($controller_model);

            //URL query string array
            $queryStrArray = array(
                'verification_code' => $controller_model->verification_code,
            );

            //Build url
            $url = \UtilLibrary::buildUrl('userVerify', $queryStrArray);

            //Message parameters
            $parameters = array(
                'name' => $controller_model->first_name . ' ' . $controller_model->last_name,
                'email' => $controller_model->email,
                'productName' => \Config::get('product.name'),
                'url' => $url,
                'status' => $controller_model->status
            );

            $recipient['to'] = $controller_model->email;
            //Send welcome email
            $sent = $this->callController(\Util::buildNamespace('messages', 'message', 1), 'converse', array('email', null, null, $controller_model->id, $recipient, 'welcome', \Config::get('app.locale'), $parameters));
        } else {
            
        }//E# if else statement
    }

//E# afterCreating() function

    /**
     * S# createStripeUser() function
     * Create stripe user
     * 
     * @param Model $controller_model User Model
     * 
     * @return boolean 1 if stripe created 0 otherwise
     */
    public function createStripeUser($controller_model) {

        //Generate random password that firsts stripe specs
        //The End User’s password as clear-text. This must be alphanumeric, between 8-15 characters in length, and contain at least one letter and one number.


        $stripe_user = array(
            'id' => $controller_model->id,
            'email' => $controller_model->email,
            'first_name' => $controller_model->first_name,
            'last_name' => $controller_model->last_name,
        );

        if ($controller_model->phone) {//Phone
            $stripe_user['phone'] = $controller_model->phone;
        }//E# if statement

        $stripe_user['description'] = json_encode($stripe_user);

        //Create Stripe user
        $stripe_response = $this->callController(\Util::buildNamespace('payments', 'stripe', 1), 'createUser', array($stripe_user));

        if ($stripe_response['status']) {//Stripe created
            //Set stripe id
            $controller_model->stripe_id = $stripe_response['response']->id;

            //Save model
            $controller_model->save();
        }//E# if statement

        return $stripe_response['status'];
    }

//E# createStripeUser() function

    /**
     * S# updateLoginSpecificFields() function
     * Generate user token to access the API and set it to the model
     * 
     * @param Model $controller_model User model
     */
    public function updateLoginSpecificFields(&$controller, &$controller_model) {

        $controller_model->token = $this->generateUniqueField('token', 48);

        //Update user login details
        $controller_model->last_login = Carbon::now();

        $controller_model->ip = $this->input['ip'];

        //Delete login attempts
        $controller_model->logins()->delete();

        //Save this user
        $controller_model->save();

        //Set parameters
        $parameters['lazyLoad'] = array('merchants');

        //Get user model
        $user_model = $this->getModelByField('token', $controller_model->token, $parameters);

        //Session this user
        $controller->sessionUser($user_model);

        $controller->apiLoginSuccess($controller_model);
    }

//E# updateLoginSpecificFields() function

    /**
     * S# apiLoginSuccess() function
     * API login success
     * @param Model $controller_model User model
     * @throws \Api200Exception
     * */
    public function apiLoginSuccess($controller_model) {
        if ($this->subdomain == 'api') {//From API
            $this->notification = array(
                'token' => $controller_model->token
            );

            //Get success message
            $message = \Lang::get($this->package . '::' . $this->controller . '.api.login');

            throw new \Api200Exception($this->notification, $message);
        }//E# if statement
    }

    /**
     * S# beforeUpdating() function
     * @author Edwin Mugendi
     * Call this just before updating the model
     * Can be used to prepare the inputs
     * @return 
     */
    public function beforeUpdating() {

        if (array_key_exists('format', $this->input) && ($this->input['format'] == 'json')) {//API
            if (isset($this->input['old_password']) && isset($this->inout['new_password'])) {
                $this->input['password'] = \Hash::make($this->input['new_password']);
            }//E# if statement

            $this->input['created_by'] = $this->user['id'] ? $this->user['id'] : 1;
            $this->input['updated_by'] = $this->user['id'] ? $this->user['id'] : 1;
        } else {

            if ($this->user['role_id'] == 2) {
                $this->input['role_id'] = 1;
            }//E# if statement
        }//E# if else statement
        return;
    }

//E# beforeUpdating() function
    /**
     * S# postUpdateUser() function
     * @author Edwin Mugendi
     * Update users details
     */
    public function postUpdateUser() {

        //$this->validationRules
        //Validate row to be inserted
        $user_model = $this->updateIfValid($this->input['id'], $this->input, false);

        if ($user_model) {
            //Session updated user
            $this->sessionUser($user_model);

            if ($this->subdomain == 'api') {//From API
                //Session updated user
                $this->sessionUser($user_model);

                //Get success message
                $message = \Lang::get($this->package . '::' . $this->controller . '.api.updateUser');

                throw new \Api200Exception($user_model->toArray(), $message);
            }//E# if statement
        } else {
            
        }
        if ($input['form'] == 'personal' || $input['form'] == 'webhook') {//Personal form
            unset($input['form']);
        } else if ($input['form'] == 'password') {//Password form
            unset($input['confirm_password']);
            unset($input['form']);
            //Hash password
            $input['password'] = \Hash::make($input['password']);
        }//E# if else statement
        //Update user model
        $user_model = $this->updateIfValid($this->user['id'], $input, true);

        if ($user_model) {//User updated
            //Set parameters
            $parameters['lazyLoad'] = array('logins');

            //Get user by id
            $user_model = $this->getModelByField('id', $this->user['id'], $parameters);

            //Session updated user
            $this->sessionUser($user_model);

            //Set notification
            $this->notification = array(
                'type' => 'success'
            );
        } else {//User not updated
            //Set notification
            $this->notification = array(
                'type' => 'error'
            );
        }
        //Return the notification a as JSON
        return \Response::json($this->notification);
    }

//E# postUpdateUser() function

    /**
     * S# getSignOut() function
     * @author Edwin Mugendi
     * Logout this user
     * @return page redirect to the index page
     */
    public function getSignOut() {
        //Logout this user
        \Auth::logout();

        //Forget this sessioned user
        \Session::flush();

        //Redirect to  home page
        return \Redirect::to('/');
    }

//E# getSignOut() function

    /**
     * S# getRegistration() function
     * @author Edwin Mugendi
     * Load the following pages
     * 1. Register page
     * 2. Login page
     * 3. Reset password page
     * 4. Forgot password page
     */
    public function getRegistration($registrationType) {

        if ($this->user) {//User is logged, hence redirect to profile page
            return \Redirect::route('userProfile');
        }//E# if else statement

        if (array_key_exists('back_url', $this->input)) {//Set back to url in session
            \Session::put('backUrl', $this->input['back_url']);
        }//E# if statement
        //Prepare view data
        $this->view_data = $this->prepareViewData('registration');

        //Add registration type to view data
        $this->view_data['registrationType'] = $registrationType;


        if (array_key_exists('reset_code', $this->input)) {//Reset password
            //Get user by email
            $user_model = $this->getModelByField('reset_code', $this->input['reset_code']);

            if (!$user_model) {//No user with this code
                return \Redirect::to('/');
            }//E# if statement       
        }//E# if statement
        //Set layout's title
        $this->layout->title = \Lang::get($this->view_data['package'] . '::' . $this->view_data['controller'] . '.' . $this->view_data['page'] . '.title');

        //Get and set layout's inline javascript
        $this->layout->inlineJs = $this->injectInlineJs($this->view_data);

        //Register css and js assets for this page
        $this->layout->assets = $this->registerAssets($this->view_data);

        //Set layout's top bar partial
        $this->layout->topBarPartial = $this->getTopBarPartialView();

        //Load content view
        $this->view_data['sideBar'] = '';

        //Load content view
        $this->view_data['contentView'] = \View::make($this->view_data['package'] . '::' . $this->view_data['controller'] . '.' . $this->view_data['view'])
                ->with('view_data', $this->view_data);

        //Set container view
        $this->layout->containerView = $this->getContainerViewPartialView();

        //Render page
        return $this->layout;
    }

//E# getRegistration() function

    /**
     * S# sessionUser() function
     * @author Edwin Mugendi
     * Save user details in session
     * @param model $user_model The logged in user model
     */
    public function sessionUser($user_model) {
        //Unset logins
        unset($user_model->logins);

        //Forget this sessioned user
        \Session::forget('user');

        //Get user
        $user = $user_model->toArray();

        if ($user_model->role_id != 3) {
            //Session org
            $this->callController(\Util::buildNamespace('merchants', 'merchant', 1), 'sessionMerchant', array($user));
        }//E# if statement
        //Unset organization
        unset($user['merchant']);

        //Put the user in session
        \Session::put('user', $user);
    }

//E# sessionUser() function

    /**
     * S# postLogin() function
     * @author Edwin Mugendi
     * Login a user
     * @return page redirect to the Dashboard page or page the user was before clicking this link
     */
    public function postLogin() {

        //Get the validation rules
        $this->validationRules = array(
            'email' => 'required|email',
            'os' => 'in:ios,android',
            'password' => 'required|min:6|login',
        );

        //Validate inputs
        $validation = $this->isInputValid();

        if ($validation->passes()) {//Validation passed
            return \Redirect::intended('profile');
        }//E# if else statement
        //Build parameters to redirect to
        $parameters = array('login');
        //Redirect to this route with old inputs and errors
        return \Redirect::route('userRegistration', $parameters)
                        ->withInput()
                        ->withErrors($validation);
    }

//E# postLogin() function

    /**
     * S# postFacebookLogin() function
     * Login with facebook
     */
    public function postFacebookLogin() {

        //Get the validation rules
        $this->validationRules = array(
            'location' => 'latLng',
            'os' => 'in:ios,android',
            'device_token' => '',
            'app_version' => '',
            'facebook_token' => 'required',
        );

        //Validate row to be inserted
        $validation = $this->isInputValid();

        //Get FB configs
        $fbConfig = array(
            'appId' => \Config::get('thirdParty.facebook.appId'),
            'secret' => \Config::get('thirdParty.facebook.appSecret'),
            'scope' => \Config::get('thirdParty.facebook.scope'),
            'allowSignedRequest' => false,
        );
        try {
            //Call Facebook
            $fb = new \Facebook($fbConfig);

            $fb->setAccessToken($this->input['facebook_token']);

            //Try getting user
            $fb_user_id = trim($fb->getUser());

            if ($fb_user_id) {//User exists
                //Get user profile from facebook
                $fb_user_profile = $fb->api('/me', 'GET');


                //Fields to select
                $fields = array('*');

                //Build where clause
                $where_clause = array(
                    array(
                        'where' => 'orWhere',
                        'column' => 'email',
                        'operator' => '=',
                        'operand' => trim($fb_user_profile['email'])
                    ),
                    array(
                        'where' => 'orWhere',
                        'column' => 'fb_uid',
                        'operator' => '=',
                        'operand' => $fb_user_id
                    )
                );

                //Get user by facebook id
                $user_model = $this->select($fields, $where_clause, 1);

                if ($user_model) {//User has already signed in facebook
                    //TODO: Should I use Stripe 
                    if (!$user_model->stripe_id) {//User does not an stripe account
                        $this->createStripeUser($user_model);
                    }//E# if statement
                    //Update users email and fb uid
                    $user_model->email = $fb_user_profile['email'];
                    $user_model->fb_uid = $fb_user_id;

                    //Push token
                    if (array_key_exists('device_token', $this->input)) {
                        $user_model->device_token = $this->input['device_token'];
                    }//E# if else statement
                    //App version
                    if (array_key_exists('app_version', $this->input)) {
                        $user_model->app_version = $this->input['app_version'];
                    }//E# if else statement
                    //Os
                    if (array_key_exists('os', $this->input)) {
                        $user_model->os = $this->input['os'];
                    }//E# if else statement
                    //Location
                    if (array_key_exists('location', $this->input)) {
                        $user_model->lat = $this->input['location']['lat'];
                        $user_model->lng = $this->input['location']['lng'];
                    }//E# if else statement
                    //Update user login specific fields
                    $this->updateLoginSpecificFields($this, $user_model);
                } else {//Register
                    $newUser = array(
                        'fb_uid' => $fb_user_id,
                        'first_name' => $fb_user_profile['first_name'],
                        'last_name' => $fb_user_profile['last_name'],
                        'gender' => $fb_user_profile['gender'] ? $fb_user_profile['gender'] : '',
                        'status' => (int) $fb_user_profile['verified'],
                        'dob' => Carbon::createFromFormat('m/d/Y', $fb_user_profile['birthday']),
                        'created_by' => 1,
                        'updated_by' => 1,
                        'role_id' => 1,
                        'notify_sms' => 1,
                        'notify_push' => 1,
                        'notify_email' => 1,
                        'email' => $fb_user_profile['email'],
                        'agent' => $this->input['agent'],
                        'ip' => $this->input['ip']//TODO remove this
                    );

                    //Push token
                    if (array_key_exists('device_token', $this->input)) {
                        $newUser['device_token'] = $this->input['device_token'];
                    }//E# if else statement
                    //App version
                    if (array_key_exists('app_version', $this->input)) {
                        $newUser['app_version'] = $this->input['app_version'];
                    }//E# if else statement
                    //Os
                    if (array_key_exists('os', $this->input)) {
                        $newUser['os'] = $this->input['os'];
                    }//E# if else statement
                    //Location
                    if (array_key_exists('location', $this->input)) {
                        $newUser['lat'] = $this->input['location']['lat'];
                        $newUser['lng'] = $this->input['location']['lng'];
                    }//E# if else statement
                    //Create user
                    $user_model = $this->createIfValid($newUser, true);

                    //Post create callback
                    $this->afterCreating($user_model);

                    //Update login specific fields
                    $this->updateLoginSpecificFields($this, $user_model);
                }//E# if else statement
                //Get success message
                $message = \Lang::get($this->package . '::' . $this->controller . '.notification.login');

                throw new \Api200Exception($user_model->toArray(), $message);
            } else {

                //Set notification
                $this->notification = array(
                    'field' => 'facebook_token',
                    'type' => 'User',
                    'value' => '', //Left blank because facebook token is very long
                );

                //Throw VRM not found error
                throw new \Api404Exception($this->notification);
            }//E# if else statement
        } catch (FacebookApiException $e) {
            throw new \Api500Exception($e->getMessage());
        }//E# try catch exception
    }

//E# postFacebookLogin() function

    /**
     * S# authenticateApi() function
     * @author Edwin Mugendi
     * Authenticate API
     */
    public function authenticateApi() {
        //Get the validation rules
        $this->validationRules = array(
            'token' => 'required|api'
        );

        //Validate inputs
        $validation = $this->isInputValid();
    }

//E# authenticateApi() function

    /**
     * S# postResetPassword() function
     * @author Edwin Mugendi
     * Reset users password
     */
    public function postResetPassword() {
        //Get the validation rules
        $this->validationRules = array(
            'send_to' => 'required',
            'reset_code' => 'required|resetCode',
            'password' => 'required|min:6'
        );

        //Validate row to be inserted
        $validation = $this->isInputValid();

        if ($validation->fails()) {//Validation fails
            //Build parameters to redirect to
            $parameters = array('reset', $this->input['reset_code']);
            //Redirect to this route with old inputs and errors
            return \Redirect::route('userRegistration', $parameters)
                            ->withInput()
                            ->withErrors($validation);
        } else {//Validation passes
            //Checks if send to is email, else reverts to phone
            if (filter_var($this->input['send_to'], FILTER_VALIDATE_EMAIL)) {
                $field = 'email';
            } else {
                $field = 'phone';
            }//E# if else statement
            //

            //Fields to select
            $fields = array('*');

            //Build where clause
            $where_clause = array(
                array(
                    'where' => 'where',
                    'column' => $field,
                    'operator' => '=',
                    'operand' => $this->input['send_to']
                ),
                array(
                    'where' => 'where',
                    'column' => 'reset_code',
                    'operator' => '=',
                    'operand' => $this->input['reset_code']
                )
            );

            //Set parameters
            $parameters['lazyLoad'] = array('logins');

            //Get user by email and verification code
            $user_model = $this->select($fields, $where_clause, 1);

            if ($user_model) {
                foreach ($user_model->logins as $singleLogin) {//Loop and delete the login attempts
                    $singleLogin->delete();
                }//E# foreach statement
                //Reset password
                $user_model->password = \Hash::make($this->input['password']);

                //Clear reset code and time
                $user_model->reset_code = '';
                $user_model->reset_time = '';

                //Save this user model
                $user_model->save();

                if (array_key_exists('format', $this->input) && ($this->input['format'] == 'json')) {//API
                    //Get success message
                    $message = \Lang::get($this->package . '::' . $this->controller . '.notification.reset_password');

                    throw new \Api200Exception(array($user_model->id), $message);
                }//E# if statement
                //Flash login error code to session
                \Session::flash('loginErrorCode', 4);
                //Redirect to login page
                return \Redirect::route('userRegistration', array('login'));
            } else {
                if (array_key_exists('format', $this->input) && ($this->input['format'] == 'json')) {
                    //Set notification
                    $this->notification = array(
                        'field' => $field,
                        'type' => 'User',
                        'value' => $this->input['send_to'],
                    );

                    //Throw VRM not found error
                    throw new \Api404Exception($this->notification);
                }//E# if statement
                //Flash forgot status code to session
                \Session::flash('resetStatusCode', 1);

                //Redirect to login page
                return \Redirect::route('userRegistration', array('reset'));
            }
        }//E# if else statement
    }

//E# postResetPassword() function

    /**
     * S# getVerify() function
     * @author Edwin Mugendi
     * Verify a user
     */
    public function getVerify() {
        //Get the activation code if it exist else set to "BLANK"
        //  $activationCode = $this->input['activation_code'] ? $this->input['activation_code'] : 'BLANK';
        //Build the email validation rule
        // $emailRule = 'required|exists:acc_users,email,activation_code,' . $activationCode;
        //Get the validation rules
        $this->validationRules = array(
            'verification_code' => 'required|exists:acc_users',
        );

        //Validate row to be inserted
        $validation = $this->isInputValid();

        if ($validation->fails()) {//Validation fails
            //Build parameters to redirect to
            $parameters = array('activate');

            //Flash login error code to session
            \Session::flash('activateCode', 2);

            //Redirect to this route with old inputs and errors
            return \Redirect::route('userRegistration', $parameters)
                            ->withInput()
                            ->withErrors($validation);
        } else {//Validation passes
            //Get user by email and verification code
            $user_model = $this->getModelByField('verification_code', $this->input['verification_code']);

            //Reset password
            $user_model->verification_code = '';

            //Clear reset code
            $user_model->status = 1;

            //Save this user model
            $user_model->save();

            //Flash login error code to session
            \Session::flash('activateCode', 1);

            //Redirect to login page
            return \Redirect::route('userRegistration', array('activate'));
        }//E# if else statement
    }

//E# getVerify() function

    /**
     * S# postForgotPassword() function
     * @author Edwin Mugendi
     * Send the user email to reset his/her password
     * @return page user registration page
     */
    public function postForgotPassword() {
        //Get the validation rules
        $this->validationRules = array(
            'send_to' => 'required',
        );

        //Validate inputs
        $validation = $this->isInputValid();

        if ($validation->passes()) {//Validation passed
            //Checks if send to is email, else reverts to phone
            if (filter_var($this->input['send_to'], FILTER_VALIDATE_EMAIL)) {
                $field = 'email';
            } else {
                $field = 'phone';
            }//E# if else statement
            //Get user by email
            $user_model = $this->getModelByField($field, $this->input['send_to']);

            if ($user_model) {//User with that email exists
                if (($user_model->role_id == 3)) {//Customer
                    $resetCode = mt_rand(1000, 10000);
                } else {
                    $resetCode = \Str::lower(\Str::random(48));
                }//E# if else statement

                $user_model->reset_code = $resetCode;

                $user_model->reset_time = Carbon::now();

                $user_model->save();

                if (($user_model->role_id == 3) && ($field == 'phone')) {//Customer from phone
                    $parameters = array(
                        'name' => $user_model->first_name . ' ' . $user_model->last_name,
                        'resetCode' => $resetCode,
                    );
                    try {
                        //Converse
                        $sent = $this->callController(\Util::buildNamespace('messages', 'message', 1), 'converse', array('sms', null, null, $user_model->id, array($user_model->phone), 'forgotPassword', \Config::get('app.locale'), $parameters));
                    } catch (\Exception $e) {
                        throw new \Api500Exception(\Lang::get($this->package . '::' . $this->controller . '.notification.sending_sms_failed'));
                    }//E# try catch block
                } else {
                    $queryStrArray = array(
                        'reset_code' => $resetCode,
                        'email' => $user_model->email,
                    );
                    //Build url
                    $url = \Util::buildUrl('userRegistration', $queryStrArray, array('reset'));

                    //Message parameters
                    $parameters = array(
                        'name' => $user_model->first_name . ' ' . $user_model->last_name,
                        'resetCode' => $resetCode,
                        'send_to' => $this->input['send_to'],
                        'passwordMinCharacters' => \Config::get($this->package . '::product.passwordMinCharacters'),
                        'productName' => \Config::get($this->package . '::product.name'),
                        'url' => $url,
                        'field' => $field,
                        'role_id' => $user_model->role_id,
                    );

                    try {
                        $recipient['to'] = $user_model->email;
                        //Converse
                        $isSent = $this->callController(\Util::buildNamespace('messages', 'message', 1), 'converse', array('email', null, null, $user_model->id, $recipient, 'forgotPassword', \Config::get('app.locale'), $parameters));
                    } catch (\Exception $e) {
                        throw new \Api500Exception(\Lang::get($this->package . '::' . $this->controller . '.notification.sending_email_failed'));
                    }//E# try catch block
                }

                if (array_key_exists('format', $this->input) && ($this->input['format'] == 'json')) {
                    //Get success message
                    $message = \Lang::get($this->package . '::' . $this->controller . '.notification.forgot_password');

                    throw new \Api200Exception(array(), $message);
                }//E# if statement
                //Flash forgot status code to session
                \Session::flash('forgotStatusCode', 1);
            } else {//User with that email does not exist
                if (array_key_exists('format', $this->input) && ($this->input['format'] == 'json')) {
                    //Set notification
                    $this->notification = array(
                        'field' => 'send_to',
                        'type' => 'User',
                        'value' => $this->input['send_to'],
                    );

                    //Throw VRM not found error
                    throw new \Api404Exception($this->notification);
                }//E# if statement
                //Flash forgot status code to session
                \Session::flash('forgotStatusCode', 2);
            }//E# if else statement
        }

        //Build parameters to redirect to
        $parameters = array('forgot');

        //Redirect to this route with old inputs and errors
        return \Redirect::route('userRegistration', $parameters)
                        ->withInput()
                        ->withErrors($validation);
    }

//E# postForgotPassword() function

    /**
     * S# getProfile() function
     * @author Edwin Mugendi
     * Render Profile Page
     * @return page Profile Page
     */
    public function getProfile() {
        if (array_key_exists('format', $this->input) && ($this->input['format'] == 'json')) {

            //Get user by token
            $user_model = $this->getModelByField('token', $this->input['token']);

            if ($user_model) {
                //Update last login
                $user_model->last_login = Carbon::now();

                //Save user
                $user_model->save();

                $message = \Lang::get($this->package . '::' . $this->controller . '.notification.list');

                //Return user
                throw new \Api200Exception($user_model->toArray(), $message);
            } else {
                //Set notification
                $this->notification = array(
                    'field' => 'token',
                    'type' => 'User',
                    'value' => '', //Left blank because of security reasons
                );

                //Throw VRM not found error
                throw new \Api404Exception($this->notification);
            }
        }//E# if statement
        //Prepare view data
        $this->view_data = $this->prepareViewData('profile');

        //Set layout's title
        $this->layout->title = \Lang::get($this->view_data['package'] . '::' . $this->view_data['controller'] . '.' . $this->view_data['page'] . '.title');

        //Get and set layout's inline javascript
        $this->layout->inlineJs = $this->injectInlineJs($this->view_data);

        //Register css and js assets for this page
        $this->layout->assets = $this->registerAssets($this->view_data);

        //Set layout's top bar partial
        $this->layout->topBarPartial = $this->getTopBarPartialView();

        //Load content view
        $this->view_data['sideBar'] = '';

        //Load content view
        $this->view_data['contentView'] = \View::make($this->view_data['package'] . '::' . $this->view_data['controller'] . '.' . $this->view_data['view'])
                ->with('view_data', $this->view_data);

        //Set container view
        $this->layout->containerView = $this->getContainerViewPartialView();

        //Render page
        return $this->layout;
    }

//E# getProfile() function
}
