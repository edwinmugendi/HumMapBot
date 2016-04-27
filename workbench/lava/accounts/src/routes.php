<?php

//DVLA Search
\Route::get('dvlasearch/{licence}', array('as' => 'dvlasearch', 'uses' => 'Lava\Accounts\DvlasearchController@getVehicleDetails'));

//Load Login or Sign up page
\Route::get('user/{type}/{resetCode?}', array('as' => 'userRegistration', 'uses' => 'Lava\Accounts\UserController@getRegistration'))
        ->where('type', 'register|login|forgot|reset|activate|verify');

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
                             * Vehicle routes
                             */
                            //Detailed vehicle
                            \Route::get('accounts/detailed/vehicle/{id}', array('as' => 'accountsDetailedVehicle', 'uses' => 'Lava\Accounts\VehicleController@getDetailed'));

                            //List vehicle
                            \Route::get('accounts/list/vehicle', array('as' => 'accountsListVehicle', 'uses' => 'Lava\Accounts\VehicleController@getList'));

                            //Post vehicle
                            \Route::get('accounts/post/vehicle/{id?}', array('as' => 'accountsPostVehicle', 'uses' => 'Lava\Accounts\VehicleController@getPost'));

                            //Create a vehicle
                            \Route::post('accounts/create/vehicle', array('as' => 'accountsCreateVehicle', 'before' => 'csrf', 'uses' => 'Lava\Accounts\VehicleController@postCreate'));

                            //Update a vehicle
                            \Route::post('accounts/update/vehicle', array('as' => 'accountsUpdateVehicle', 'before' => 'csrf', 'uses' => 'Lava\Accounts\VehicleController@postUpdate'));

                            //Delete vehicle
                            \Route::post('accounts/delete/vehicle', array('as' => 'accountsDeleteVehicle', 'uses' => 'Lava\Accounts\VehicleController@postDelete'));

                            //Un-Delete vehicle
                            \Route::post('accounts/undelete/vehicle', array('as' => 'accountsUndeleteVehicle', 'uses' => 'Lava\Accounts\VehicleController@postUndelete'));

                            /**
                             * Lead routes
                             */
                            //Detailed lead
                            \Route::get('accounts/detailed/lead/{id}', array('as' => 'accountsDetailedLead', 'uses' => 'Lava\Accounts\LeadController@getDetailed'));

                            //List lead
                            \Route::get('accounts/list/lead', array('as' => 'accountsListLead', 'uses' => 'Lava\Accounts\LeadController@getList'));

                            //Post lead
                            \Route::get('accounts/post/lead/{id?}', array('as' => 'accountsPostLead', 'uses' => 'Lava\Accounts\LeadController@getPost'));

                            //Create a lead
                            \Route::post('accounts/create/lead', array('as' => 'accountsCreateLead', 'before' => 'csrf', 'uses' => 'Lava\Accounts\LeadController@postCreate'));

                            //Update a lead
                            \Route::post('accounts/update/lead', array('as' => 'accountsUpdateLead', 'before' => 'csrf', 'uses' => 'Lava\Accounts\LeadController@postUpdate'));

                            //Delete lead
                            \Route::post('accounts/delete/lead', array('as' => 'accountsDeleteLead', 'uses' => 'Lava\Accounts\LeadController@postDelete'));

                            //Un-Delete lead
                            \Route::post('accounts/undelete/lead', array('as' => 'accountsUndeleteLead', 'uses' => 'Lava\Accounts\LeadController@postUndelete'));
                        });
                        