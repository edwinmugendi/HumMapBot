<?php

//Register
\Route::get('app/register', array('as' => 'appRegister', 'uses' => 'Lava\Accounts\AppController@getRegister'));


//Load Login or Sign up page
\Route::get('authenticate', array('as' => 'userRegistration', 'uses' => 'Lava\Accounts\UserController@getRegistration'));

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

    /**
     * Referral routes
     */
    //Detailed referral
    \Route::get('accounts/detailed/referral/{id}', array('as' => 'accountsDetailedReferral', 'uses' => 'Lava\Accounts\ReferralController@getDetailed'));

    //List referral
    \Route::get('accounts/list/referral', array('as' => 'accountsListReferral', 'uses' => 'Lava\Accounts\ReferralController@getList'));

    //Post referral
    \Route::get('accounts/post/referral/{id?}', array('as' => 'accountsPostReferral', 'uses' => 'Lava\Accounts\ReferralController@getPost'));

    //Create a referral
    \Route::post('accounts/create/referral', array('as' => 'accountsCreateReferral', 'before' => 'csrf', 'uses' => 'Lava\Accounts\ReferralController@postCreate'));

    //Update a referral
    \Route::post('accounts/update/referral', array('as' => 'accountsUpdateReferral', 'before' => 'csrf', 'uses' => 'Lava\Accounts\ReferralController@postUpdate'));

    //Delete referral
    \Route::post('accounts/delete/referral', array('as' => 'accountsDeleteReferral', 'uses' => 'Lava\Accounts\ReferralController@postDelete'));

    //Un-Delete referral
    \Route::post('accounts/undelete/referral', array('as' => 'accountsUndeleteReferral', 'uses' => 'Lava\Accounts\ReferralController@postUndelete'));

    /**
     * Log routes
     */
    //Detailed log
    \Route::get('accounts/detailed/log/{id}', array('as' => 'accountsDetailedLog', 'uses' => 'Lava\Accounts\LogController@getDetailed'));

    //List log
    \Route::get('accounts/list/log', array('as' => 'accountsListLog', 'uses' => 'Lava\Accounts\LogController@getList'));

    //Post log
    \Route::get('accounts/post/log/{id?}', array('as' => 'accountsPostLog', 'uses' => 'Lava\Accounts\LogController@getPost'));

    //Create a log
    \Route::post('accounts/create/log', array('as' => 'accountsCreateLog', 'before' => 'csrf', 'uses' => 'Lava\Accounts\LogController@postCreate'));

    //Update a log
    \Route::post('accounts/update/log', array('as' => 'accountsUpdateLog', 'before' => 'csrf', 'uses' => 'Lava\Accounts\LogController@postUpdate'));

    //Delete log
    \Route::post('accounts/delete/log', array('as' => 'accountsDeleteLog', 'uses' => 'Lava\Accounts\LogController@postDelete'));

    /**
     * Chat routes
     */
    //Detailed chat
    \Route::get('accounts/detailed/chat/{id}', array('as' => 'accountsDetailedChat', 'uses' => 'Lava\Accounts\ChatController@getDetailed'));

    //List chat
    \Route::get('accounts/list/chat', array('as' => 'accountsListChat', 'uses' => 'Lava\Accounts\ChatController@getList'));

    //Post chat
    \Route::get('accounts/post/chat/{id?}', array('as' => 'accountsPostChat', 'uses' => 'Lava\Accounts\ChatController@getPost'));

    //Create a chat
    \Route::post('accounts/create/chat', array('as' => 'accountsCreateChat', 'before' => 'csrf', 'uses' => 'Lava\Accounts\ChatController@postCreate'));

    //Update a chat
    \Route::post('accounts/update/chat', array('as' => 'accountsUpdateChat', 'before' => 'csrf', 'uses' => 'Lava\Accounts\ChatController@postUpdate'));

    //Delete chat
    \Route::post('accounts/delete/chat', array('as' => 'accountsDeleteChat', 'uses' => 'Lava\Accounts\ChatController@postDelete'));

    /**
     * Mpesa routes
     */
    //Detailed mpesa
    \Route::get('accounts/detailed/mpesa/{id}', array('as' => 'accountsDetailedMpesa', 'uses' => 'Lava\Accounts\MpesaController@getDetailed'));

    //List mpesa
    \Route::get('accounts/list/mpesa', array('as' => 'accountsListMpesa', 'uses' => 'Lava\Accounts\MpesaController@getList'));

    //Post mpesa
    \Route::get('accounts/post/mpesa/{id?}', array('as' => 'accountsPostMpesa', 'uses' => 'Lava\Accounts\MpesaController@getPost'));

    //Create a mpesa
    \Route::post('accounts/create/mpesa', array('as' => 'accountsCreateMpesa', 'before' => 'csrf', 'uses' => 'Lava\Accounts\MpesaController@postCreate'));

    //Update a mpesa
    \Route::post('accounts/update/mpesa', array('as' => 'accountsUpdateMpesa', 'before' => 'csrf', 'uses' => 'Lava\Accounts\MpesaController@postUpdate'));

    //Delete mpesa
    \Route::post('accounts/delete/mpesa', array('as' => 'accountsDeleteMpesa', 'uses' => 'Lava\Accounts\MpesaController@postDelete'));
});
