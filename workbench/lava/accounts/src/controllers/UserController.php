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
            if ($this->user['role_id'] == 2) {//Organization
                //Transaction fields
                $transaction_fields = array('user_id');

                //Transaction where clause
                $transaction_where_clause = array(
                    array(
                        'where' => 'where',
                        'column' => 'organization_id',
                        'operator' => '=',
                        'operand' => $this->user['organization_id']
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
                'full_name' => 'required',
                'organization_id' => 'required|integer|exists:mct_organizations,id',
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

        //Get this organization organization id
        $this->view_data['dataSource']['organization_id'] = $this->appGetCustomOrganizationHtmlSelect();

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
            //Generate referral code
            //$this->input['referral_code'] = $this->generateReferralCode($this->input['first_name'], $this->input['last_name']);

            $this->input['verification_code'] = $this->generateUniqueCode('verification_code', 10000, 99999);

            $this->input['organization_id'] = 3;
            $this->input['role_id'] = 3; //Customer

            $this->input['status'] = 0;
            $this->input['created_by'] = $this->input['updated_by'] = 1;
        } else {
            $this->input['role_id'] = 2; //Officer

            $this->input['status'] = 1;
            $this->input['created_by'] = $this->input['updated_by'] = $this->user['id'];
        }//E# if else statement
    }

//E# beforeCreating() function
    /**
     * S# generateReferralCode() function
     * 
     * Generate Referral code
     * 
     * @param str $full_name Full name
     * 
     * @return str Referral code
     *
     */
    public function generateReferralCode($first_name, $last_name) {

        $number_of_letters = 0;
        $found = true;
        while ($found) {
            //Generate append
            $append = substr($last_name, 0, $number_of_letters);

            //Generate random number
            $random_number = mt_rand(10, 9999);

            $referal_code = \Str::lower($first_name . $append . $random_number);

            //Check if user exists
            $user_model = $this->getModelByField('referral_code', $referal_code);

            if ($user_model) {
                $number_of_letters++;
            } else {
                $found = false;
            }//E# if else statement
        }//E# while statement

        return $referal_code;
    }

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

            /*
              //URL query string array
              $queryStrArray = array(
              'verification_code' => $controller_model->verification_code,
              );

              //Build url
              $url = \UtilLibrary::buildUrl('userVerify', $queryStrArray);

              //Message parameters
              $parameters = array(
              'name' => $controller_model->full_name,
              'email' => $controller_model->email,
              'productName' => \Config::get('product.name'),
              'url' => $url,
              'status' => $controller_model->status
              );

              $recipient['to'] = $controller_model->email;
              //Send welcome email
              $sent = $this->callController(\Util::buildNamespace('messages', 'message', 1), 'converse', array('email', null, null, $controller_model->id, $recipient, 'welcome', \Config::get('app.locale'), $parameters));
             */
        } else {
            
        }//E# if else statement
    }

//E# afterCreating() function

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
        $parameters['lazyLoad'] = array('organizations');

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
        if (array_key_exists('format', $this->input) && ($this->input['format'] == 'json')) {//From API
            $this->notification = array(
                'token' => $controller_model->token
            );

            //Get success message
            $message = \Lang::get($this->package . '::' . $this->controller . '.api.login');

            throw new \Api200Exception($this->notification, $message);
        }//E# if statement
    }

//E# apiLoginSuccess() function

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
    public function getRegistration() {

        $this->layout = 'layouts.auth';

        $this->setupLayout();

        //dd($this->layout);
        if ($this->user) {//User is logged, hence redirect to profile page
            $this->getSignOut();
        }//E# if else statement
        //Prepare view data
        $this->view_data = $this->prepareViewData('registration');

        if (!array_key_exists('sub_view', $this->input) || (array_key_exists('sub_view', $this->input) && in_array('subview', array('register', 'login', 'forgot', 'reset', 'activate', 'verify')))) {
            $this->view_data['input']['sub_view'] = 'login';
        }

        if (array_key_exists('reset_code', $this->input)) {//Reset password
            //Get user by email
            $user_model = $this->getModelByField('reset_code', $this->input['reset_code']);

            if (!$user_model) {//No user with this code
                $link = \URL::route('userRegistration');
                $link .='#toforgot';

                //Redirect to login page
                return \Redirect::to($link);
            }//E# if statement       
        }//E# if statement
        //Get and set country options for this country
        $this->view_data['data_source']['country_id'] = $this->callController(\Util::buildNamespace('locations', 'country', 1), 'getSelectOptions', array('en', 'alphaList'));

        //Set layout's title
        $this->layout->title = \Lang::get($this->view_data['package'] . '::' . $this->view_data['controller'] . '.' . $this->view_data['page'] . '.titleAction.' . $this->view_data['input']['sub_view']);

        //Get and set layout's inline javascript
        $this->layout->inlineJs = $this->injectInlineJs($this->view_data);

        //Register css and js assets for this page
        $this->layout->assets = $this->registerAssets($this->view_data);

        //Set layout's top bar partial
        $this->layout->topBarPartial = $this->getTopBarPartialView();

        //Set layout's side bar partial
        $this->layout->sideBarPartial = $this->getSideBarPartialView();

        //Load content view
        $this->view_data['contentView'] = \View::make($this->view_data['package'] . '::' . $this->view_data['controller'] . '.' . $this->view_data['view'])
                ->with('view_data', $this->view_data);

        //Set container view
        $this->layout->containerView = $this->view_data['contentView'];

        //Render page
        return $this->layout;
    }

//E# getRegistration() function

    /**
     * S# getRegistration() function
     * @author Edwin Mugendi
     * Load the following pages
     * 1. Register page
     * 2. Login page
     * 3. Reset password page
     * 4. Forgot password page
     */
    public function getRegistration1($registrationType) {

        $this->layout = 'layouts.auth';

        $this->setupLayout();

        //dd($this->layout);
        if ($this->user) {//User is logged, hence redirect to profile page
            $this->getSignOut();
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
        //Get and set country options for this country
        $this->view_data['data_source']['country_id'] = $this->callController(\Util::buildNamespace('locations', 'country', 1), 'getSelectOptions', array('en', 'alphaList'));

        //Set layout's title
        $this->layout->title = \Lang::get($this->view_data['package'] . '::' . $this->view_data['controller'] . '.' . $this->view_data['page'] . '.titleAction.' . $this->view_data['registrationType']);

        //Get and set layout's inline javascript
        $this->layout->inlineJs = $this->injectInlineJs($this->view_data);

        //Register css and js assets for this page
        $this->layout->assets = $this->registerAssets($this->view_data);

        //Set layout's top bar partial
        $this->layout->topBarPartial = $this->getTopBarPartialView();

        //Set layout's side bar partial
        $this->layout->sideBarPartial = $this->getSideBarPartialView();

        //Load content view
        $this->view_data['contentView'] = \View::make($this->view_data['package'] . '::' . $this->view_data['controller'] . '.' . $this->view_data['view'])
                ->with('view_data', $this->view_data);

        if ($this->view_data['registrationType'] == 'verify') {
            return $this->view_data['contentView'];
        }//E# if statement
        //Set container view
        $this->layout->containerView = $this->view_data['contentView'];

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

        //if ($user_model->role_id != 3) {
        //Session org
        $this->callController(\Util::buildNamespace('organizations', 'organization', 1), 'sessionOrg', array($user));
        //}//E# if statement
        //Unset organization
        unset($user['organization']);

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
            'phone_or_email' => 'required',
            'id_field' => 'required|in:email,phone',
            'os' => 'in:ios,android',
            'password' => 'required|min:4|login',
        );

        //Validate inputs
        $validation = $this->isInputValid();

        if ($validation->passes()) {//Validation passed
            return \Redirect::intended('dashboard');
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
     * S# authenticateApi() function
     * @author Edwin Mugendi
     * 
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
     * S# postApiSendCode() function
     * @author Edwin Mugendi
     * Send the user email to reset his/her password
     * @return page user registration page
     */
    public function postApiSendCode() {

        //Get the validation rules
        $this->validationRules = array(
            'phone' => 'required',
            'type' => 'required|in:verify,pin',
        );

        //Validate inputs
        $this->validator = $this->isInputValid();

        if ($this->validator->passes()) {//Validation passed
            //Get user model by phone
            $user_model = $this->getModelByField('phone', $this->input['phone']);

            if ($this->input['type'] == 'reset') {//Reset
                $code = $this->generateUniqueCode('reset_code', 10000, 99999);
                $user_model->reset_code = $code;
                $user_model->reset_time = Carbon::now();
            } else {//PIN
                $code = mt_rand(1000, 9999);
                $user_model->password = \Hash::make($code);
            }//E# if else statement
            //Save user model
            $user_model->save();

            //Message parameters
            $parameters = array(
                'code' => $code,
            );

            $recipient = $user_model->phone;

            try {
                //Converse
                $sent = $this->callController(\Util::buildNamespace('messages', 'message', 1), 'converse', array('sms', null, \Config::get('product.alphanumericSender'), $user_model->id, $recipient, $this->input['type'], \Config::get('app.locale'), $parameters));
            } catch (\Exception $e) {
                throw new \Api500Exception(\Lang::get($this->package . '::' . $this->controller . '.notification.sending_email_failed'));
            }//E# try catch block
        }//E# if statement
        //Get success message
        $message = \Lang::get($this->package . '::' . $this->controller . '.notification.code.' . $this->input['type']);

        throw new \Api200Exception(array($user_model->id), $message);
    }

//E# postApiSendCode() function

    /**
     * S# postApiUpdate() function
     * @author Edwin Mugendi
     * Update a user
     */
    public function postApiUpdate() {

        //Validation rules
        $this->validationRules = array(
            'full_name' => '',
            'password' => '',
            'dob' => '',
            'gender' => '',
            'email' => 'email',
            'app_version' => '',
            'device_token' => '',
        );

        //Validate row to be inserted
        $this->validator = $this->isInputValid();

        if ($this->validator->passes()) {//Validation passes
            if (array_key_exists('password', $this->input)) {
                $this->input['password'] = \Hash::make($this->input['password']);
            }//E# if statement
            //Update user
            $user_model = $this->updateIfValid('token', $this->input['token'], $this->input, true);

            //Get success message
            $message = \Lang::get($this->package . '::' . $this->controller . '.notification.updated');

            throw new \Api200Exception(array($user_model->id), $message);
        }//E# if else statement
    }

//E# postApiUpdate() function

    /**
     * S# postApiRegister() function
     * @author Edwin Mugendi
     * Register a user
     */
    public function postApiRegister() {
        //Get and set the model's create validation rules
        $this->validationRules = array(
            'phone' => 'required|unique:acc_users'
        );

        //Validate row to be inserted
        $this->validator = $this->isInputValid();

        if ($this->validator->passes()) {//Validation passes
            $this->input['organization_id'] = 1; //Kenya
            $this->input['role_id'] = 3; //Customer
            $this->input['created_by'] = $this->input['updated_by'] = 1; //Admin
            //Create user
            $user_model = $this->createIfValid($this->input, true);

            //Get success message
            $message = \Lang::get($this->package . '::' . $this->controller . '.notification.registered');

            throw new \Api200Exception(array($user_model->id), $message);
        }//E# if else statement
    }

//E# postApiRegister() function

    /**
     * S# postResetPassword() function
     * @author Edwin Mugendi
     * Reset users password
     */
    public function postResetPassword() {
        //Get the validation rules
        $this->validationRules = array(
            'reset_code' => 'required',
            'reset_password' => 'required|min:4|resetCode',
        );

        if ($this->input['phone_or_email'] == 'phone') {
            $this->validationRules['phone_or_email'] = 'required|exists:acc_users,phone';
        } else {
            $this->validationRules['phone_or_email'] = 'required|exists:acc_users,phone';
        }//E# if else statement
        //Validate row to be inserted
        $this->validator = $this->isInputValid();

        if ($this->validator->fails()) {//Validation fails
            //dd($this->validator->messages());
            $query_string_array = array(
                'reset_code' => $this->input['reset_code'],
                'forgot_email' => $this->input['reset_email'],
                'sub_view' => 'reset',
                'user_role' => $this->input['user_role']
            );

            //Build url
            $url = \Util::buildUrl('userRegistration', $query_string_array);

            $url.='#toreset';

            //Redirect to forgot page
            return \Redirect::to($url)
                            ->withInput()
                            ->withErrors($this->validator);
        } else {//Validation passes
            /*
              //Checks if send to is email, else reverts to phone
              if (filter_var($this->input['send_to'], FILTER_VALIDATE_EMAIL)) {
              $field = 'email';
              } else {
              $field = 'phone';
              }//E# if else statement
              //
             */
            //Fields to select
            $fields = array('*');

            //Build where clause
            $where_clause = array(
                array(
                    'where' => 'where',
                    'column' => $this->input['id_field'],
                    'operator' => '=',
                    'operand' => $this->input['phone_or_email']
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

            foreach ($user_model->logins as $singleLogin) {//Loop and delete the login attempts
                $singleLogin->delete();
            }//E# foreach statement
            //Reset password
            $user_model->password = \Hash::make($this->input['reset_password']);

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

            if ($this->input['user_role'] == 'user') {
                //Flash login error code to session
                \Session::flash('reset_status_code', 1);

                $query_string_array = array(
                    'sub_view' => 'reset',
                );

                //Build url
                $url = \Util::buildUrl('userRegistration', $query_string_array);

                $url .= '#toreset';

                //Redirect to reset page
                return \Redirect::to($url);
            } else {
                //Flash login error code to session
                \Session::flash('loginErrorCode', 4);
                //Redirect to login page
                return \Redirect::route('userRegistration');
            }//E# if else statement
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
        $this->validator = $this->isInputValid();

        if ($this->validator->fails()) {//Validation fails
            //Flash login error code to session
            \Session::flash('verify_status_code', 2);
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
            \Session::flash('verify_status_code', 1);
        }//E# if else statement

        $query_string_array = array(
            'sub_view' => 'verify',
        );

        //Build url
        $url = \Util::buildUrl('userRegistration', $query_string_array);

        $url .= '#toverify';

        return \Redirect::to($url);
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
            'phone_or_email' => 'required',
            'id_field' => 'required',
        );

        //Validate inputs
        $this->validator = $this->isInputValid();

        if ($this->validator->passes()) {//Validation passed
            /*
              //Checks if send to is email, else reverts to phone
              if (filter_var($this->input['reset_email'], FILTER_VALIDATE_EMAIL)) {
              $field = 'email';
              } else {
              $field = 'phone';
              }//E# if else statement
             * 
             */
            //Get user by email
            $user_model = $this->getModelByField($this->input['id_field'], $this->input['phone_or_email']);

            if ($user_model) {//User with that email exists
                if ($this->input['id_field'] == 'phone') {//Customer
                    $reset_code = $this->generateUniqueInt('reset_code', 1000, 9999);
                } else {
                    $reset_code = \Str::upper($this->generateUniqueField('reset_code', 48));
                }//E# if else statement

                $user_model->reset_code = $reset_code;

                $user_model->reset_time = Carbon::now();

                $user_model->save();

                if ($this->input['id_field'] == 'phone') {//Customer from phone
                    $parameters = array(
                        'name' => $user_model->full_name,
                        'resetCode' => $reset_code,
                    );
                    try {
                        //Converse
                        $sent = $this->callController(\Util::buildNamespace('messages', 'message', 1), 'converse', array('sms', null, \Config::get('product.alphanumericSender'), $user_model->id, array($user_model->phone), 'forgotPassword', \Config::get('app.locale'), $parameters));
                    } catch (\Exception $e) {
                        throw new \Api500Exception(\Lang::get($this->package . '::' . $this->controller . '.notification.sending_sms_failed'));
                    }//E# try catch block
                } else {

                    $queryStrArray = array(
                        'reset_code' => $reset_code,
                        'phone_or_email' => $user_model->email,
                        'sub_view' => 'reset',
                        'user_role' => $user_model->role_id == 3 ? 'user' : 'organization'
                    );

                    //Build url
                    $url = \Util::buildUrl('userRegistration', $queryStrArray);

                    $url .= '#toreset';

                    //Message parameters
                    $parameters = array(
                        'name' => $user_model->full_name,
                        'reset_code' => $reset_code,
                        'phone_or_email' => $this->input['phone_or_email'],
                        'passwordMinCharacters' => \Config::get($this->package . '::account.passwordMinCharacters'),
                        'productName' => \Config::get($this->package . '::product.name'),
                        'url' => $url,
                        /* 'field' => $field, */
                        'role_id' => $user_model->role_id,
                    );

                    try {
                        $recipient['to'] = $user_model->email;
                        //Converse
                        $isSent = $this->callController(\Util::buildNamespace('messages', 'message', 1), 'converse', array('email', null, null, $user_model->id, $recipient, 'forgotPassword', \Config::get('app.locale'), $parameters));
                    } catch (\Exception $e) {
                        throw new \Api500Exception(\Lang::get($this->package . '::' . $this->controller . '.notification.sending_email_failed'));
                    }//E# try catch block
                }//E# if else statement

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
                        'field' => 'phone_or_email',
                        'type' => 'User',
                        'value' => $this->input['phone_or_email'],
                    );

                    //Throw VRM not found error
                    throw new \Api404Exception($this->notification);
                }//E# if statement
                //Flash forgot status code to session
                \Session::flash('forgotStatusCode', 2);
            }//E# if else statement
        }//E# if statement

        $link = \URL::route('userRegistration');
        $link .='#toforgot';

        //Redirect to forgot page
        return \Redirect::to($link)
                        ->withInput()
                        ->withErrors($this->validator);
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

        //Set layout's side bar partial
        $this->layout->sideBarPartial = $this->getSideBarPartialView();

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
