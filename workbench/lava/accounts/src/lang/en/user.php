<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | User Language Lines
      |--------------------------------------------------------------------------
     */
    'data' => array(
        'role_id' => array(
            '' => 'Select',
            1 => 'Admin',
            2 => 'Merchant',
            3 => 'App user'
        )
    ),
    'notification' => array(
        'created' => 'User created',
        'updated' => 'User updated',
        'login' => 'Logged in!',
        'list' => 'User profile',
        'forgot_password' => 'We\'ve sent you reset email.',
        'reset_password' => 'Your password has been reset',
        'sending_email_failed' => 'Sending email failed. Kindly try again later',
        'sending_sms_failed' => 'Sending sms failed. Kindly try again later',
    ),
    'validation' => array(
        'api' => 'Invalid login token',
        'facebook' => array(
            'noUser' => 'No user found on Facebook with such token'
        ),
        'password' => array(
            'oldPasswordRequired' => 'Old password is required',
            'oldPasswordWrong' => 'Wrong old password',
            'newPasswordMin' => 'New password should be greater than :min'
        )
    ),
    'view' => array(
        'field' => array(
            'merchant_id' => 'Merchant',
            'id' => '#',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'phone' => 'Phone',
            'role_id' => 'Role',
            'dob' => 'Date of birth',
            'gender' => 'Gender',
            'email' => 'Email',
            'address' => 'Address',
            'postal code' => 'Postal code',
            'notify_sms' => 'Notify sms',
            'notify_email' => 'Notify email',
            'notify_push' => 'Notify push',
            'os' => 'Os',
            'device_token' => 'Device token',
            'app_version' => 'App version',
            'vehicle_id' => 'Default vehicle',
            'card_id' => 'Default card',
            'fb_uid' => 'Facebook id',
            'stripe_id' => 'Stripe id',
            'lat' => 'Latitude',
            'lng' => 'Longitude',
        ),
        'actions' => array(
            'delete' => array(
                'confirm' => 'Delete user?',
                'deleteMany' => 'Deleted :count users',
                'confirmMany' => 'Delete :count users?',
                'delete' => 'Delete',
                'cancel' => 'Cancel',
            ),
            'undelete' => array(
                'undoDelete' => 'Undo delete',
                'undeleting' => 'Un deleting...',
                'undeleted' => 'Un deleted :count users',
            ),
        ),
        'link' => array(
            'list' => 'Locations list',
            'add' => 'Add user',
            'found' => '{0} :count users | {1} :count user | [2,Inf] :count users',
        )
    ),
    'userDetailedPage' => array(
        'title' => 'User: :title #:id'
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
            'message' => 'This email is not registered',
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
    ),
    'userPostPage' => array(
        'actionTitle' => array(
            1 => 'Create user',
            2 => 'Update user'
        ),
        'userPostView' => array(
            'form' => array(
                'userPost' => array(
                    'attributes' => array(
                        'method' => 'POST',
                        'route' => array(
                            1 => 'accountsCreateUser',
                            2 => 'accountsUpdateUser'
                        ),
                        'id' => 'userPost',
                        'class' => 'commonContainer'
                    ),
                    'stars' => array(
                        'required' => array(
                            'text' => 'Required',
                            'fieldText' => 'This field is required',
                            'description' => 'Required fields are marked with a red star'
                        ),
                        'optional' => array(
                            'text' => 'Optional',
                            'fieldText' => 'This field is optional but important',
                            'description' => 'Optional fields marked with blue star'
                        )
                    ),
                    'components' => array(
                        'characterReminder' => array(
                            'text' => 'Characters remaining'
                        )
                    ),
                    'submitText' => array(
                        'processing' => 'Processing',
                        1 => 'Save',
                        2 => 'Update',
                        3 => 'Edit'
                    ),
                    'validator' => array(
                        'required' => 'This field is required.',
                        'maxlength' => 'Maximium :length characters allowed',
                        'minlength' => 'Minimum :length characters allowed'
                    ),
                    'hide' => array(
                        1 => array(
                            'htmlNames' => array('')
                        ),
                        2 => array(
                            'htmlNames' => array()
                        )
                    ),
                    'portlets' => array(
                        array(
                            'id' => 'details',
                            'title' => 'User\'s details',
                            'heading' => 'Please fill in the details of this work user.',
                            'help' => 'Please fill in all the mandatory details of this work user.',
                            'stared' => 1,
                            'rows' => array(
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Merchant',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'merchant_id',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select merchant',
                                            'help' => '<strong>Description: </strong>The merchant of this user<br/><strong>Do: </strong>Select the merchant of this user.<br/></strong>Star:</strong> %s',
                                            'validator' => array(
                                                'required' => 1,
                                            )
                                        ),
                                        array(
                                            'name' => 'Role',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'role_id',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select role',
                                            'help' => '<strong>Description: </strong>The role of this user<br/><strong>Do: </strong>Select the role of this user.<br/></strong>Star:</strong> %s',
                                            'validator' => array(
                                                'required' => 1,
                                            )
                                        ),
                                        array(
                                            'name' => 'First name',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'first_name',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the first name eg \'John\'',
                                            'help' => '<strong>Description: </strong>The first name of this user.<br/><strong>Do: </strong>Type the first name of this user.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'John\'.',
                                            'validator' => array(
                                                'required' => 1
                                            )
                                        ),
                                        array(
                                            'name' => 'Last name',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'last_name',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the last name eg \'Doe\'',
                                            'help' => '<strong>Description: </strong>The last name of this user.<br/><strong>Do: </strong>Type the last name of this user.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'Doe\'.',
                                            'validator' => array(
                                                'required' => 1
                                            )
                                        ),
                                    )
                                ),
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Email',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'email',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the email eg \'john.doe@gmail.com\'',
                                            'help' => '<strong>Description: </strong>The email of this user.<br/><strong>Do: </strong>Type the email of this user.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'john.doe@gmail.com\'.',
                                            'validator' => array(
                                                'required' => 1,
                                                'email' => 1
                                            )
                                        ),
                                    )
                                ),
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Id',
                                            'type' => 'hidden',
                                            'htmlName' => 'id',
                                        )
                                    )
                                )
                            )
                        )
                    )
                )
            )
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
                'verify' => array(
                    'statusCode' => array(
                        1 => 'Your account has been activated',
                        2 => 'The email or activation code is invalid'
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
                    ),
                    'statusCode' => array(
                        1 => 'User not found.',
                    )
                ),
            )
        )
    )
);
