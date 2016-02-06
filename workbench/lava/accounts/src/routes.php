<?php

//Load Login or Sign up page
\Route::get('user/{type}/{resetCode?}', array('as' => 'userRegistration', 'uses' => 'Lava\Accounts\UserController@getRegistration'))
        ->where('type', 'register|login|forgot|reset|activate');

//Login page
\Route::get('login', array('as' => 'userRegistrationLogin', function() {
        return \Redirect::route('userRegistration', array('login'));
    }));

        //Registration page
        \Route::get('register', array('as' => 'userRegistrationRegister', function() {
                return \Redirect::route('userRegistration', array('register'));
            }));
                /* S# API End points */
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
                //Sign out User
                \Route::get('user/signout', array('as' => 'userSignOut', 'uses' => 'Lava\Accounts\UserController@getSignOut'));

                //Is email available
                \Route::get('user/is_email_available', array('as' => 'userIsEmailAvailable', 'uses' => 'Lava\Accounts\UserController@getIsEmailAvailable'));

                //Activate user
                \Route::get('user/verify', array('as' => 'userVerify', 'uses' => 'Lava\Accounts\UserController@getVerify'));

                //Forgot Password
                \Route::post('user/forgot_password', array('as' => 'userForgotPassword', 'uses' => 'Lava\Accounts\UserController@postForgotPassword'));

                //Reset Password
                \Route::post('user/reset_password', array('as' => 'userResetPassword', 'uses' => 'Lava\Accounts\UserController@postResetPassword'));

                \Route::group(array('before' => 'api'), function() {
                    /* S# API End points */
                    //Get Profile Page
                    \Route::get('api/get_user_profile', array('as' => 'apiGetUserProfile', 'uses' => 'Lava\Accounts\UserController@getProfile'));

                    //Update User
                    \Route::post('api/update_user', array('as' => 'apiUpdateUser', 'uses' => 'Lava\Accounts\UserController@postUpdate'));

                    /* E# API End points */
                    /**
                     * USER API's
                     * 
                     */
                    /**
                     * VEHICLE API's
                     */
                    //Add vehicle
                    \Route::post('user/vehicle/add', array('as' => 'userAddVehicle', 'uses' => 'Lava\Accounts\VehicleController@postCreate'));

                    //Add vehicle
                    \Route::post('user/vehicle/update', array('as' => 'userUpdateVehicle', 'uses' => 'Lava\Accounts\VehicleController@postUpdate'));

                    //Delete vehicle
                    \Route::post('user/vehicle/delete', array('as' => 'userVehicleDrop', 'uses' => 'Lava\Accounts\VehicleController@postDrop'));

                    //Get a single vehicle
                    //\Route::get('user/vehicle/get/{field}/{value}', array('as' => 'userVehicleGetSingle', 'uses' => 'Lava\Accounts\VehicleController@getManyModelBelongingToUser'));
                    //Get users vehicles
                    \Route::get('user/vehicle/get', array('as' => 'userVehicleGetAll', 'uses' => 'Lava\Accounts\VehicleController@getList'));

                    /**
                     * DEVICE API's
                     */
                    //Add device
                    \Route::post('user/device/add', array('as' => 'userDeviceAdd', 'uses' => 'Lava\Accounts\DeviceController@postCreate'));

                    //Update device
                    \Route::post('user/device/update/{field}/{value}', array('as' => 'userDeviceUpdate', 'uses' => 'Lava\Accounts\DeviceController@postUpdate'));

                    //Delete device
                    \Route::post('user/device/delete/{field}/{value}', array('as' => 'userDeleteDevice', 'uses' => 'Lava\Accounts\DeviceController@postDelete'));

                    //Get a single device
                    \Route::get('user/device/get/{field}/{value}', array('as' => 'userDeviceGetSingle', 'uses' => 'Lava\Accounts\DeviceController@getModelBelongingToUser'));

                    //Get a single device
                    \Route::get('user/device/get', array('as' => 'userDeviceGetAll', 'uses' => 'Lava\Accounts\DeviceController@getAllModelBelongingToUser'));
                });
                