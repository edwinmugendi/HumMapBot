<?php

//Register
\Route::get('app/register', array('as' => 'appRegister', 'uses' => 'Lava\Accounts\AppController@getRegister'));

//Load Login or Sign up page
\Route::get('login', array('as' => 'userRegistration', 'uses' => 'Lava\Accounts\UserController@getRegistration'));

//Login page
\Route::get('/', array('as' => 'userLogin', function() {
        return \Redirect::route('userRegistration');
    }));


/* S# API End points */
//USER API'S
//Register User
\Route::post('api/register', array('as' => 'apiRegisterUser', 'uses' => 'Lava\Accounts\UserController@postApiRegister'));

//Login User
\Route::post('api/login', array('as' => 'apiLoginUser', 'uses' => 'Lava\Accounts\UserController@postLogin'));

//Forgot Password
\Route::post('api/send_code', array('as' => 'apiSendCode', 'uses' => 'Lava\Accounts\UserController@postApiSendCode'));

//Get Profile Page
\Route::get('api/get_user_profile', array('as' => 'apiGetUserProfile', 'uses' => 'Lava\Accounts\UserController@getProfile'));

//Reset Password
\Route::post('api/reset_password', array('as' => 'apiResetPassword', 'uses' => 'Lava\Accounts\UserController@postResetPassword'));

//Is email available
\Route::get('api/is_email_available', array('as' => 'apiIsEmailAvailable', 'uses' => 'Lava\Accounts\UserController@getIsEmailAvailable'));

//Forgot Password
\Route::post('api/forgot_password', array('as' => 'userForgotPassword', 'uses' => 'Lava\Accounts\UserController@postForgotPassword'));

//Reset Password
\Route::post('api/reset_password', array('as' => 'userResetPassword', 'uses' => 'Lava\Accounts\UserController@postResetPassword'));

/* E# API End points */

//Login User
\Route::post('login', array('as' => 'userLogin', 'uses' => 'Lava\Accounts\UserController@postLogin'));

\Route::post('register', array('as' => 'userRegister', 'before' => 'csrf', 'uses' => 'Lava\Accounts\UserController@postRegister'));

//Sign out User
\Route::get('signout', array('as' => 'userSignOut', 'uses' => 'Lava\Accounts\UserController@getSignOut'));

//Is email available
\Route::get('is_email_available', array('as' => 'userIsEmailAvailable', 'uses' => 'Lava\Accounts\UserController@getIsEmailAvailable'));

//Activate user
\Route::get('verify', array('as' => 'userVerify', 'uses' => 'Lava\Accounts\UserController@getVerify'));

//Forgot Password
\Route::post('forgot_password', array('as' => 'userForgotPassword', 'uses' => 'Lava\Accounts\UserController@postForgotPassword'));

//Reset Password
\Route::post('reset_password', array('as' => 'userResetPassword', 'uses' => 'Lava\Accounts\UserController@postResetPassword'));

\Route::group(array('before' => 'api'), function() {
    /* S# API End points */
    //User API's
    //Get Profile Page
    \Route::get('api/get_user_profile', array('as' => 'apiGetUserProfile', 'uses' => 'Lava\Accounts\UserController@getProfile'));

    //Update User
    \Route::post('api/update_user', array('as' => 'apiUpdateUser', 'uses' => 'Lava\Accounts\UserController@postApiUpdate'));

    //Create a log
    \Route::post('api/create_log', array('as' => 'apiCreateLog', 'uses' => 'Lava\Accounts\LogController@postCreate'));

    //Create a mpesa
    \Route::post('api/create_mpesa', array('as' => 'apiCreateMpesa', 'uses' => 'Lava\Accounts\MpesaController@postCreate'));
});

\Route::group(array('before' => 'auth'), function() {
    //Dashboard
    \Route::get('dashboard', array('as' => 'dashboard', 'uses' => 'Lava\Accounts\DashboardController@getDashboard'));

    //Get Graph data
    \Route::get('dashboard/get_graph', array('as' => 'dashboardGetGraph', 'uses' => 'Lava\Accounts\DashboardController@getGraph'));

    //Get Profile Page
    \Route::get('profile', array('as' => 'userProfile', 'uses' => 'Lava\Accounts\UserController@getProfile'));

    //Update User
    \Route::post('user/update_user', array('as' => 'userUpdateUser', 'uses' => 'Lava\Accounts\UserController@postUpdate'));

    /**
     * User routes
     */
    //Detailed user
    \Route::get('accounts/detailed/user/{id}', array('as' => 'accountsDetailedUser', 'uses' => 'Lava\Accounts\UserController@getDetailed'));

    //List user
    \Route::get('accounts/list/user', array('as' => 'accountsListUser', 'uses' => 'Lava\Accounts\UserController@getList'));

    //Post user
    \Route::get('accounts/post/user/{id?}', array('as' => 'accountsPostUser', 'uses' => 'Lava\Accounts\UserController@getPost'));

    //Create a user
    \Route::post('accounts/create/user', array('as' => 'accountsCreateUser', 'before' => 'csrf', 'uses' => 'Lava\Accounts\UserController@postCreate'));

    //Update a user
    \Route::post('accounts/update/user', array('as' => 'accountsUpdateUser', 'before' => 'csrf', 'uses' => 'Lava\Accounts\UserController@postUpdate'));

    //Delete user
    \Route::post('accounts/delete/user', array('as' => 'accountsDeleteUser', 'uses' => 'Lava\Accounts\UserController@postDelete'));

    //Un-Delete user
    \Route::post('accounts/undelete/user', array('as' => 'accountsUndeleteUser', 'uses' => 'Lava\Accounts\UserController@postUndelete'));
});
