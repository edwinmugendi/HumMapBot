<?php

namespace Lava\Accounts;

use Carbon\Carbon;

class UserController extends AccountsBaseController {

    //Controller
    public $controller = 'user';

    /**
     * S# getIsEmailAvailable() function
     * @author Edwin Mugendi
     * Check if Email is available
     * @return json the success or failure notification
     * @throws \Api200Exception if call is from API
     */
    public function getIsEmailAvailable() {
        //Get POSTed data
        $input = \Input::get();

        //Get the validation rules
        $this->validationRules = array(
            'email' => 'required|email'
        );

        //Validate row to be inserted
        $validation = $this->isInputValid($input);

        if ($validation->fails()) {
            //Set notification
            $this->notification = array(
                'email', false
            );
            //Return the notification a as JSON
            return \Response::json($this->notification);
        } else {

            if ($this->subdomain == 'api') {//From API
                $userModel = $this->getModelByField('email', $input['email']);
                throw $userModel ? new \Api200Exception(0, '') : new \Api200Exception(1, '');
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
        //Notifications
        $this->input['notify_sms'] = $this->input['notify_email'] = $this->input['notify_push'] = 1;

        //Prepare other fields
        $this->input['password'] = \Hash::make($this->input['password']);
        $this->input['verification_code'] = \Str::lower(\Str::random(10));
        if (array_key_exists('location', $this->input)) {
            $this->input['lat'] = $this->input['location']['lat'];
            $this->input['lng'] = $this->input['location']['lng'];
        }//E# if statement
        //User the users role
        $this->input['role_id'] = 1;
        $this->input['status'] = 0;
        $this->input['created_by'] = $this->input['updated_by'] = 1;
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
    public function afterCreating(&$controllerModel) {
        //Create app55 user
        $this->createApp55User($controllerModel);

        // //URL query string array
        $queryStrArray = array(
            'verification_code' => $controllerModel->verification_code,
            'email' => $controllerModel->email
        );

        //Build url
        $url = \UtilLibrary::buildUrl('userVerify', $queryStrArray);

        if (!$controllerModel->status) {
            //Message parameters
            $parameters = array(
                'name' => $controllerModel->first_name . ' ' . $controllerModel->last_name,
                'email' => $controllerModel->email,
                'productName' => \Config::get('product.name'),
                'url' => $url
            );

            //Send welcome email
            $sent = $this->callController(\Util::buildNamespace('messages', 'message', 1), 'converse', array('email', null, null, $controllerModel->id, $controllerModel->email, 'welcome', \Config::get('app.locale'), $parameters));
        }//E# if statement
    }

//E# afterCreating() function

    /**
     * S# createRedirect() function
     * @author Edwin Mugendi
     * Redirect after creating the model
     * 
     * @param Model $controllerModel Controller model
     * 
     * @return \Redirect if source is web redirect to controller list page
     * @return \API200Exception if source is "api" throw Success Exception 
     */
    public function createRedirect($controllerModel) {
        if ($this->subdomain == 'api') {//From API
            //Get success message
            $message = \Lang::get($this->package . '::' . $this->controller . '.api.registerUser', array('productName' => \Config::get('product.name')));

            throw new \Api200Exception(array_only($controllerModel->toArray(), array('id')), $message);
        }//E# if else statement

        return \Redirect::route($this->controller . 'List');
    }

//E# createRedirect() function

    /**
     * S# createApp55User() function
     * Create app55 user
     * 
     * @param Model $controllerModel User Model
     * 
     * @return boolean 1 if app55 created 0 otherwise
     */
    public function createApp55User($controllerModel) {

        //Generate random password that firsts app55 specs
        //The End User’s password as clear-text. This must be alphanumeric, between 8-15 characters in length, and contain at least one letter and one number.
        $password = \Str::random(12);
        $password .= rand(100, 999);

        $app55User = array(
            'email' => $controllerModel->email,
            'password' => $password,
            'first_name' => $controllerModel->first_name,
            'last_name' => $controllerModel->last_name,
        );

        if ($controllerModel->phone) {//Phone
            $app55User['phone'] = $controllerModel->phone;
        }//E# if statement
        //Create App55 user
        $app55Response = $this->callController(\Util::buildNamespace('payments', 'app55', 1), 'createUser', array($app55User));

        if ($app55Response['status']) {//App55 created
            //Set app55 id
            $controllerModel->app55_id = $app55Response['response']->user->id;

            //Save model
            $controllerModel->save();
        }//E# if statement

        return $app55Response['status'];
    }

//E# createApp55User() function

    /**
     * S# updateLoginSpecificFields() function
     * Generate user token to access the API and set it to the model
     * 
     * @param Model $controllerModel User model
     */
    public function updateLoginSpecificFields(&$controller, &$controllerModel) {
        $controllerModel->token = $this->generateUniqueField('token', 32);

        //Update user login details
        $controllerModel->last_login = Carbon::now();

        $controllerModel->ip_address = \Request::getClientIp();

        //Delete login attempts
        $controllerModel->logins()->delete();

        //Save this user
        $controllerModel->save();

        //Get user model
        $userModel = $this->getModelByField('token', $controllerModel->token);

        //Session this user
        $controller->sessionUser($userModel);

        $controller->apiLoginSuccess($controllerModel);
    }

//E# updateLoginSpecificFields() function

    
    /**
     * S# apiLoginSuccess() function
     * API login success
     * @param Model $controllerModel User model
     * @throws \Api200Exception
     * */
    public function apiLoginSuccess($controllerModel) {
        if ($this->subdomain == 'api') {//From API
            $this->notification = array(
                'token' => $controllerModel->token
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

        if (isset($this->input['old_password']) && isset($this->inout['new_password'])) {
            $this->input['password'] = \Hash::make($this->input['new_password']);
        }//E# if statement

        $this->input['created_by'] = $this->user['id'] ? $this->user['id'] : 1;
        $this->input['updated_by'] = $this->user['id'] ? $this->user['id'] : 1;
        return;
    }

//E# beforeUpdating() function
    /**
     * S# postUpdateUser() function
     * @author Edwin Mugendi
     * Update users details
     */
    public function postUpdateUser() {

        $this->input['id'] = $this->user['id'];

        //$this->validationRules
        //Validate row to be inserted
        $userModel = $this->updateIfValid($this->input['id'], $this->input, false);

        if ($userModel) {
            //Session updated user
            $this->sessionUser($userModel);

            if ($this->subdomain == 'api') {//From API
                //Session updated user
                $this->sessionUser($userModel);

                //Get success message
                $message = \Lang::get($this->package . '::' . $this->controller . '.api.updateUser');

                throw new \Api200Exception($userModel->toArray(), $message);
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
        $userModel = $this->updateIfValid($this->user['id'], $input, true);

        if ($userModel) {//User updated
            //Set parameters
            $parameters['lazyLoad'] = array('logins');

            //Get user by id
            $userModel = $this->getModelByField('id', $this->user['id'], $parameters);

            //Session updated user
            $this->sessionUser($userModel);

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
        \Session::forget('user');

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
        $viewData = $this->prepareViewData('registration');

        //Add registration type to view data
        $viewData['registrationType'] = $registrationType;

        if (array_key_exists('reset_code', $this->input)) {//Reset password
            //Get user by email
            $userModel = $this->getModelByField('reset_code', $this->input['reset_code']);

            if (!$userModel) {//No user with this code
                return \Redirect::to('/');
            }//E# if statement       
        }
        //Set layout's title
        $this->layout->title = \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.titleAction.' . $viewData['registrationType']);

        //Get and set layout's inline javascript
        $this->layout->inlineJs = $this->injectInlineJs($viewData['page']);

        //Register css and js assets for this page
        $this->layout->assets = $this->registerAssets($viewData['page']);

        //Set layout's top bar partial
        $this->layout->topBarPartial = '';

        //Set layout's side bar partial
        $this->layout->sideBarPartial = '';

        //Set layout's content view
        $this->layout->contentView = \View::make($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['view'])
                ->with('viewData', $viewData);

        //Render page
        return $this->layout;
    }

//E# getRegistration() function

    /**
     * S# sessionUser() function
     * @author Edwin Mugendi
     * Save user details in session
     * @param model $userModel The logged in user model
     */
    public function sessionUser($userModel) {
        //Unset logins
        unset($userModel->logins);

        //Forget this sessioned user
        \Session::forget('user');

        //Get user
        $user = $userModel->toArray();

        //Define user to session
        $userToSession = array();

        //Set fields of user to session
        $userToSession['name'] = $user['first_name'] . ' ' . $user['last_name'];
        $userToSession['id'] = $user['id'];
        $userToSession['first_name'] = $user['first_name'];
        $userToSession['last_name'] = $user['last_name'];
        $userToSession['email'] = $user['email'];
        $userToSession['phone'] = isset($user['phone']) ? $user['phone'] : '';
        $userToSession['token'] = $user['token'];
        $userToSession['vrm'] = isset($user['vrm']) ? $user['vrm'] : '';
        $userToSession['app55_id'] = $user['app55_id'];

        // $userToSession['api_secret'] = $user['api_secret'];
        //Put the user in session
        \Session::put('user', $userToSession);
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
            'password' => 'required|min:6|login'
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
     * S# postFacebookLogin() function
     * Login with facebook
     */
    public function postFacebookLogin() {

        //Get the validation rules
        $this->validationRules = array(
            'facebook_token' => 'required|facebookLogin'
        );

        //Validate row to be inserted
        $validation = $this->isInputValid();
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
            'email' => 'required',
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
            //Set parameters
            $parameters['lazyLoad'] = array('logins');

            //Get user by email
            $userModel = $this->getModelByField('email', $this->input['email'], $parameters);

            foreach ($userModel->logins as $singleLogin) {//Loop and delete the login attempts
                $singleLogin->delete();
            }//E# foreach statement
            //Reset password
            $userModel->password = \Hash::make($this->input['password']);

            //Clear reset code and time
            $userModel->reset_code = '';
            $userModel->reset_time = '';

            //Save this user model
            $userModel->save();

            if ($this->subdomain == 'api') {//From API
                //Get success message
                $message = \Lang::get($this->package . '::' . $this->controller . '.api.resetPassword');

                throw new \Api200Exception(array($userModel->id), $message);
            }//E# if statement
            //Flash login error code to session
            \Session::flash('loginErrorCode', 4);
            //Redirect to login page
            return \Redirect::route('userRegistration', array('login'));
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
            'email' => 'required|exists:acc_users',
        );

        //Manually set to web to ensure the user is shown the HTML files
        $this->subdomain = 'web';

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
            //Fields to select
            $fields = array('*');

            //Build where clause
            $whereClause = array(
                array(
                    'where' => 'where',
                    'column' => 'email',
                    'operator' => '=',
                    'operand' => $this->input['email']
                ),
                array(
                    'where' => 'where',
                    'column' => 'verification_code',
                    'operator' => '=',
                    'operand' => $this->input['verification_code']
                )
            );

            //Get user by email and verification code
            $userModel = $this->select($fields, $whereClause, 1);

            //Reset password
            $userModel->verification_code = '';

            //Clear reset code
            $userModel->status = 1;

            //Save this user model
            $userModel->save();

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
            'email' => 'required|email'
        );

        //Validate inputs
        $validation = $this->isInputValid();

        if ($validation->passes()) {//Validation passed
            //Get user by email
            $userModel = $this->getModelByField('email', $this->input['email']);

            if ($userModel) {//User with that email exists
                //Generate and save reset code
                $resetCode = \Str::lower(\Str::random(10));
                $userModel->reset_code = $resetCode;
                $userModel->reset_time = Carbon::now();

                $userModel->save();

                $queryStrArray = array(
                    'reset_code' => $resetCode,
                    'email' => $userModel->email
                );
                //Build url
                $url = \Util::buildUrl('userRegistration', $queryStrArray, array('reset'));

                //Message parameters
                $parameters = array(
                    'name' => $userModel->first_name . ' ' . $userModel->last_name,
                    'resetCode' => $resetCode,
                    'email' => $userModel->email,
                    'passwordMinCharacters' => \Config::get($this->package . '::product.passwordMinCharacters'),
                    'productName' => \Config::get($this->package . '::product.name'),
                    'url' => $url
                );

                //Converse
                $isSent = $this->callController(\Util::buildNamespace('messages', 'message', 1), 'converse', array('email', null, null, $userModel->id, $userModel->email, 'resetPassword', \Config::get('app.locale'), $parameters));

                if ($this->subdomain == 'api') {//From API
                    //Get success message
                    $message = \Lang::get($this->package . '::' . $this->controller . '.api.forgotPassword');

                    throw new \Api200Exception(array(), $message);
                }//E# if statement
                //Flash forgot status code to session
                \Session::flash('forgotStatusCode', 1);
            } else {//User with that email does not exist
                if ($this->subdomain == 'api') {//From API
                    //Set notification
                    $this->notification = array(
                        'field' => 'email',
                        'type' => 'User',
                        'value' => $this->input['email'],
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
        if ($this->subdomain == 'api') {//From API            
            //Get user by token
            $userModel = $this->getModelByField('token', $this->input['token']);
            //Update last login
            $userModel->last_login = Carbon::now();

            //Save user
            $userModel->save();

            //Return user
            throw new \Api200Exception($userModel->toArray(), '');
        }//E# if statement
        //Prepare view data
        $viewData = $this->prepareViewData('profile');

        //Set layout's title
        $this->layout->title = \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.title');

        //Get and set layout's inline javascript
        $this->layout->inlineJs = $this->injectInlineJs($viewData['page'], $viewData);

        //Register css and js assets for this page
        $this->layout->assets = $this->registerAssets($viewData['page']);

        //Set layout's top bar partial
        $this->layout->topBarPartial = $this->getTopBarPartialView($viewData);

        //Set layout's side bar partial
        $this->layout->sideBarPartial = '';

        //Set layout's content view
        $this->layout->contentView = \View::make($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['view'])
                ->with('viewData', $viewData);

        //Render page
        return $this->layout;
    }

//E# getProfile() function
}
