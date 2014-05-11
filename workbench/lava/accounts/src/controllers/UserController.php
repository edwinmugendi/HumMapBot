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
     * @throws \ApiSuccessException if call is from API
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
                throw $userModel ? new \ApiSuccessException(0, '') : new \ApiSuccessException(1, '');
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
        $this->input['created_by'] = $this->user['id'] ? $this->user['id'] : 1;
        $this->input['updated_by'] = $this->user['id'] ? $this->user['id'] : 1;
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
        $this->createApp55User($controllerModel->id, $controllerModel->email, $controllerModel->first_name, $controllerModel->last_name, $controllerModel->phone);

        // //URL query string array
        $queryStrArray = array(
            'verification_code' => $controllerModel->verification_code,
            'email' => $controllerModel->email
        );

        //Build url
        $url = \UtilLibrary::buildUrl('userVerify', $queryStrArray);

        //Message parameters
        $parameters = array(
            'name' => $controllerModel->first_name . ' ' . $controllerModel->last_name,
            'email' => $controllerModel->email,
            'productName' => \Config::get('product.name'),
            'url' => $url
        );

        //Send welcome email
        $sent = $this->callController(\Util::buildNamespace('messages', 'message', 1), 'converse', array('email', \Config::get('product.email'), $controllerModel->email, 'welcome', \Config::get('app.locale'), $parameters));
    }

//E# afterCreating() function

    /**
     * S# listRedirect() function
     * @author Edwin Mugendi
     * Redirect to list
     * @param array $controller The controller
     * @param string $crudAction The Crud action
     * @return \Redirect redirect to list page
     */
    public function listRedirect($controllerModel, $crudAction) {
        if ($this->subdomain == 'api') {//From API
            //Get success message
            $message = \Lang::get($this->package . '::' . $this->controller . '.api.registerUser', array('productName' => \Config::get('product.name')));

            throw new \ApiSuccessException(array_only($controllerModel->toArray(), array('id')), $message);
        }//E# if else statement

        return \Redirect::route($this->controller . 'List');
    }

//E# listRedirect() function

    /**
     * S# createApp55User() function
     * Create app55 user
     * 
     * @param integer $userId User id
     * @param string $email Email
     * @param string $firstName First name  
     * @param string $lastName Last name  
     * @param string $password Password (This is auto generated) 
     * @param string $phone phone Optional
     * @return boolean 1 if app55 created 0 otherwise
     */
    private function createApp55User($userId, $email, $firstName, $lastName, $phone = null) {

        //Generate random password that firsts app55 specs
        //The End User’s password as clear-text. This must be alphanumeric, between 8-15 characters in length, and contain at least one letter and one number.
        $password = \Str::random(12);
        $password .= rand(100, 999);

        $app55User = array(
            'email' => $email,
            'password' => $password,
            'first_name' => $firstName,
            'last_name' => $lastName,
        );

        if ($phone) {//Phone
            $app55User['phone'] = $phone;
        }//E# if statement
        //Create App55 user
        $app55Response = $this->callController(\Util::buildNamespace('payments', 'app55', 1), 'createUser', array($app55User));

        if ($app55Response['status']) {//App55 created
            //Created app55 user
            $app55User = array(
                'id' => $app55Response['response']->user->id,
                'user_id' => $userId,
                'sig' => $app55Response['response']->sig,
                'ts' => $app55Response['response']->ts
            );

            //Create app55 user
            $app55Model = $this->callController(\Util::buildNamespace('payments', 'app55', 1), 'createIfValid', array($app55User, true));
        }//E# if statement

        return $app55Response['status'];
    }

//E# createApp55User() function

    /**
     * S# generateToken() function
     * Generate user token to access the API and set it to the model
     * 
     * @param Model $controllerModel User model
     */
    public function generateToken(&$controllerModel) {
        if (!$controllerModel->token) {//Generate token
            $controllerModel->token = \Str::lower(\Str::random(32));
        }//E# if statement
    }

//E# generateToken() function

    /**
     * S# apiLoginSuccess() function
     * API login success
     * @param Model $controllerModel User model
     * @throws \ApiSuccessException
     * */
    public function apiLoginSuccess($controllerModel) {
        if ($this->subdomain == 'api') {//From API
            $this->notification = array(
                'token' => $controllerModel->token
            );

            //Get success message
            $message = \Lang::get($this->package . '::' . $this->controller . '.api.login');

            throw new \ApiSuccessException($this->notification, $message);
        }//E# if statement
    }

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

                throw new \ApiSuccessException($userModel->toArray(), $message);
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
            $parameters['lazyLoad'] = array('logins', 'roles');

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

        //Define user to session and roles
        $userToSession = $roles = array();

        if (array_key_exists('roles', $user)) {
            foreach ($user['roles'] as $singleRole) {//Loop through the roles
                array_push($roles, $singleRole['id']);
            }//E# foreach statement
        }//E# if statement
        //Set fields of user to session
        $userToSession['roles'] = $roles;
        $userToSession['name'] = $user['first_name'] . ' ' . $user['last_name'];
        $userToSession['id'] = $user['id'];
        $userToSession['first_name'] = $user['first_name'];
        $userToSession['last_name'] = $user['last_name'];
        $userToSession['email'] = $user['email'];
        $userToSession['phone'] = $user['phone'];
        $userToSession['token'] = $user['token'];
        $userToSession['default_vrm'] = $user['default_vrm'];
        $userToSession['card'] = $user['card'];

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
        //Cache ip
        $this->input['ipAddress'] = \Request::getClientIp();

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
     * S# authenticateApi() function
     * @author Edwin Mugendi
     * Authenticate API
     */
    public function authenticateApi() {
        //Cache ip
        $this->input['ipAddress'] = \Request::getClientIp();

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

                throw new \ApiSuccessException(array($userModel->id), $message);
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

        //Get input
        $fluent = new \Laravel\Fluent(Input::json(true));

        if ($validate->fails()) {//Validation failed
            return Event::first("app.validationerror", array(400, $validate->errors->messages));
        }//E# if statement

        $fbConfig = array(
            'appId' => \Config::get($this->package . '::account.app_id'),
            'secret' => \Config::get($this->package . '::account.app_secret'),
            'allowSignedRequest' => false
        );

        $fb = new Facebook($fbConfig);

        $fbConfig->setAccessToken($this->input['token']);

        $fbUserId = $fb->getUser();

        if ($fbUserId) {

            // We have a user ID, so probably a logged in user.
            // If not, we'll get an exception, which we handle below.
            try {
                $userProfile = $facebook->api('/me', 'GET');

                $user = User::where_fb_uid($fbUserId)->first();

                if ($user) {//User has already signed in facebook
                    //Bootstrap Oauth
                    $this->bootstrap_oauth();

                    $token = bin2hex(openssl_random_pseudo_bytes(32));

                    $expires = strtotime("+2 weeks");

                    $this->storage->setAccessToken($token, $fluent->get('client_id'), $user->id, $expires);

                    $response = array(
                        'access_token' => $token,
                        'expres_in' => $expires,
                        'token_type' => 'bearer',
                        'scope' => null
                    );
                    return Response::json($response);
                } else {//Register
                }//E# if else statement
            } catch (FacebookApiException $e) {
                // If the user is logged out, you can have a 
                // user ID even though the access token is invalid.
                // In this case, we'll get an exception, so we'll
                // just ask the user to login again here.
                $login_url = $facebook->getLoginUrl();
                echo 'Please <a href="' . $login_url . '">login.</a>';
                error_log($e->getType());
                error_log($e->getMessage());
            }
        } else {

            // No user, print a link for the user to login
            $login_url = $facebook->getLoginUrl();
            echo 'Please <a href="' . $login_url . '">login.</a>';
        }
    }

//E# postFacebookLogin() function

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
                $isSent = $this->callController(\Util::buildNamespace('messages', 'message', 1), 'converse', array('email', 'info@intrapayment.com', $userModel->email, 'reset_password', \Config::get('app.locale'), $parameters));

                if ($this->subdomain == 'api') {//From API
                    $this->notification = array(
                        'reset_code' => $resetCode
                    );

                    //Get success message
                    $message = \Lang::get($this->package . '::' . $this->controller . '.api.forgotPassword');

                    throw new \ApiSuccessException($this->notification, $message);
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
            //Return user
            throw new \ApiSuccessException($userModel->toArray(), '');
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
