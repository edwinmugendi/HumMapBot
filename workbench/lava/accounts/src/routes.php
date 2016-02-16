<?php

//Is email available
\Route::get('dvlasearch/{licence}', array('as' => 'apiIsEmailAvailable', 'uses' => 'Lava\Accounts\DvlasearchController@getVehicleDetails'));

//Load Login or Sign up page
\Route::get('user/{type}/{resetCode?}', array('as' => 'userRegistration', 'uses' => 'Lava\Accounts\UserController@getRegistration'))
        ->where('type', 'register|login|forgot|reset|activate');

//Login page
\Route::get('/', array('as' => 'userLogin', function() {
        return \Redirect::route('userRegistration', array('login'));
    }));
    
    //Login page
\Route::get('login', array('as' => 'userLogin', function() {
        return \Redirect::route('userRegistration', array('login'));
    }));

        //Registration page
        \Route::get('register', array('as' => 'userRegistrationRegister', function() {
                return \Redirect::route('userRegistration', array('register'));
            }));
                /* S# API End points */
                //USER API'S
                //Register User
                \Route::post('api/register_user', array('as' => 'apiRegisterUser', 'uses' => 'Lava\Accounts\UserController@postCreate'));

                //Login User
                \Route::post('api/login_user', array('as' => 'apiLoginUser', 'uses' => 'Lava\Accounts\UserController@postLogin'));

                //Login with fabook
                \Route::post('api/login_with_facebook', array('as' => 'userFacebookLogin', 'uses' => 'Lava\Accounts\UserController@postFacebookLogin'));

                //Forgot Password
                \Route::post('api/forgot_password', array('as' => 'apiForgotPassword', 'uses' => 'Lava\Accounts\UserController@postForgotPassword'));

                //Reset Password
                \Route::post('api/reset_password', array('as' => 'apiResetPassword', 'uses' => 'Lava\Accounts\UserController@postResetPassword'));

                //Is email available
                \Route::get('api/is_email_available', array('as' => 'apiIsEmailAvailable', 'uses' => 'Lava\Accounts\UserController@getIsEmailAvailable'));

                /* E# API End points */

                //Login User
                \Route::post('login', array('as' => 'userLogin', 'uses' => 'Lava\Accounts\UserController@postLogin'));

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
                    \Route::post('api/update_user', array('as' => 'apiUpdateUser', 'uses' => 'Lava\Accounts\UserController@postUpdate'));

                    //VEHICLE API'S
                    //Add vehicle
                    \Route::post('api/add/vehicle', array('as' => 'apiAddVehicle', 'uses' => 'Lava\Accounts\VehicleController@postCreate'));

                    //Add vehicle
                    \Route::post('api/update/vehicle', array('as' => 'apiUpdateVehicle', 'uses' => 'Lava\Accounts\VehicleController@postUpdate'));

                    //Delete vehicle
                    \Route::post('api/delete/vehicle', array('as' => 'userVehicleDrop', 'uses' => 'Lava\Accounts\VehicleController@postDrop'));

                    //Get users vehicles
                    \Route::get('api/get/vehicle', array('as' => 'apiGetVehicle', 'uses' => 'Lava\Accounts\VehicleController@getList'));
                });

                \Route::group(array('before' => 'auth'), function() {
                    //Get Profile Page
                    \Route::get('profile', array('as' => 'userProfile', 'uses' => 'Lava\Accounts\UserController@getProfile'));

                    //Update User
                    \Route::post('user/update_user', array('as' => 'userUpdateUser', 'uses' => 'Lava\Accounts\UserController@postUpdate'));
                });
                