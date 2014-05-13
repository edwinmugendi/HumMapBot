<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | User Language Lines
      |--------------------------------------------------------------------------
     */
    'api' => array(
        'registerUser' => 'Your account has been created on :productName',
        'updateUser' => 'Your details have been updated',
        'forgotPassword'=>'We\'ve sent you reset email.',
        'resetPassword'=>'Your password has been reset',
        'login' => 'Logged in',
    ),
    'validation' => array(
        'api' => 'Invalid login token',
        'facebook' => array(
            'noUser' => 'No user found on Facebook with such token'
        ),
    ),
    'view' => array(
        'name' => 'Name',
        'email' => 'Email',
        'phone' => 'Phone',
        'lastLogin' => 'Last login',
        'verified' => 'Verified',
        'no' => 'No',
        'yes' => 'Yes',
        'country' => 'Country',
        'organization' => 'Organization',
        'memberSince' => 'Member since',
    ),
    'action' => array(
        'validating' => 'Validating post inputs',
    ),
    'logout' => 'Logout',
    'login' => array(
        'incorrectCredentials' => array(
            'type' => 'error',
            'message' => 'The email or password you entered is incorrect.',
            'code' => 1
        ),
        'loginAttemptsExceeded' => array(
            'type' => 'error',
            'message' => 'You have exceeded the login attempts',
            'code' => 2
        ),
        'noSuchUser' => array(
            'type' => 'error',
            'message' => 'This email is not registered, kindly ',
            'code' => 3
        )
    ),
    'userProfilePage' => array(
        'title' => 'My Profile',
        'menu' => 'Profile',
        'userProfileView' => array(
            'tab' => array(
                'profile' => array(
                    'heading' => 'Profile',
                ),
                'changePassword' => array(
                    'heading' => 'Change password',
                ),
                'apiKeys' => array(
                    'heading' => 'API Keys',
                ),
                'webhooks' => array(
                    'heading' => 'Webhooks',
                )
            ),
            'form' => array(
                'personal' => array(
                    'heading' => 'Personal information',
                    'submit' => 'Save details',
                    'success' => 'Saved',
                    'field' => array(
                        'firstName' => array(
                            'name' => 'First name',
                            'placeholder' => 'Enter first name'
                        ),
                        'lastName' => array(
                            'name' => 'Last name',
                            'placeholder' => 'Enter last name'
                        ),
                        'phoneNumber' => array(
                            'name' => 'Phone number',
                            'placeholder' => 'Enter phone number'
                        ),
                        'email' => array(
                            'name' => 'Email',
                        ),
                    )
                ),
                'password' => array(
                    'heading' => 'Change password',
                    'submit' => 'Save password',
                    'success' => 'Saved',
                    'field' => array(
                        'password' => array(
                            'name' => 'Password',
                            'placeholder' => 'Enter password'
                        ),
                        'confirmPassword' => array(
                            'name' => 'Confirm password',
                            'placeholder' => 'Confirm password'
                        )
                    )
                ),
                'webhook' => array(
                    'heading' => 'Webhook',
                    'submit' => 'Save webhooks',
                    'success' => 'Saved',
                    'field' => array(
                        'callback' => array(
                            'name' => 'Callback URL',
                            'placeholder' => 'Enter callback URL, must start with http:// or https://'
                        ),
                        'pushback' => array(
                            'name' => 'pushback',
                            'placeholder' => 'Push back url , must start with http:// or https://'
                        )
                    )
                ),
            )
        )
    ),
    'userAlertsPage' => array(
        'title' => 'My Alerts',
        'menu' => 'Alerts'
    ),
    'userListPage' => array(
        'title' => 'Users',
        'menu' => 'Users',
        'userListView' => array(
            'heading' => 'All users',
        )
    ),
    'userRegistrationPage' => array(
        'titleAction' => array(
            'login' => 'Login',
            'register' => 'Register',
            'forgot' => 'Forgot password',
            'reset' => 'Reset password',
            'activate' => 'Account activation',
        ),
        'userRegistrationView' => array(
            'why' => array(
                'header' => 'Why :productName?',
                'heading' => 'Personalize you home search',
                'benefits' => array(
                    1 => array(
                        'heading' => 'Post your property for FREE',
                        'icon' => 'building',
                        'body' => 'Post your property for sale or rent for FREE and reach thousands of potential clients'
                    ),
                    2 => array(
                        'heading' => 'Like your favourite properties',
                        'icon' => 'heart',
                        'body' => 'Save your favorite homes, keep private notes, track sales, and share with your family and friends.'
                    ),
                    3 => array(
                        'heading' => 'Get real-time updates',
                        'icon' => 'clock',
                        'body' => 'We\'ll email you new homes as soon as we get them.'
                    ),
                    4 => array(
                        'heading' => 'Get advice and guidance',
                        'icon' => 'man',
                        'body' => 'Connect with local experts to help you realise your dream of owning a home.'
                    )
                )
            ),
            'form' => array(
                'register' => array(
                    'heading' => 'Register for FREE',
                    'suggest' => 'Have an account?',
                    'submit' => 'Register',
                    'processing' => 'Processing',
                    'field' => array(
                        'firstName' => 'First name',
                        'lastName' => 'Last name',
                        'email' => 'Email',
                        'password' => 'Password',
                        'confirm_password' => 'Confirm password'
                    )
                ),
                'login' => array(
                    'heading' => 'Login',
                    'suggest' => 'Don\'t have a FREE account?',
                    'submit' => 'Login',
                    'processing' => 'Processing',
                    'field' => array(
                        'email' => 'Email',
                        'password' => 'Password',
                        'forgotPassword' => 'Forgot Password?'
                    ),
                    'statusCode' => array(
                        1 => 'The email or password you entered is incorrect.',
                        2 => 'The email you specified is not registered. Kindly confirm the email is correct or create an account',
                        3 => 'You have exceeded the login attempts. Kindly wait for :lockOut minutes before trying again.',
                        4 => 'Your password was reset successfully.'
                    )
                ),
                'forgot' => array(
                    'heading' => 'Reset Password',
                    'suggest' => 'Back to :login or :register',
                    'submit' => 'Forgot password',
                    'processing' => 'Processing',
                    'field' => array(
                        'email' => 'Email'
                    ),
                    'statusCode' => array(
                        1 => 'We have sent an email to the address specified. Please check your email.',
                        2 => 'The email you specified is not registered. Kindly confirm the email is correct or :register'
                    )
                ),
                'activate' => array(
                    'heading' => 'Account Activation',
                    'suggest' => 'Back to :login or :register',
                    'submit' => 'Forgot password',
                    'processing' => 'Processing',
                    'statusCode' => array(
                        1 => 'Your account has been activated',
                        2 => 'The email or activation code is invalid'
                    )
                ),
                'reset' => array(
                    'heading' => 'Recover your password',
                    'submit' => 'Reset password',
                    'processing' => 'Processing',
                    'help' => 'Create a new password with at least :passwordMinCharacters characters.',
                    'field' => array(
                        'enterPassword' => 'Enter new password',
                        'confirmPassword' => 'Confirm password'
                    )
                ),
            )
        )
    )
);
