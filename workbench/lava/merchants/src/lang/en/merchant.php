<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | Merchant Language Lines
      |--------------------------------------------------------------------------
     */
    'data' => array(
        'workflow' => array(
            '' => 'Select',
            1 => 'Active',
            2 => 'Inactive',
            3 => 'Suspended',
        ),
        'date_format' => array(
            '' => 'Select',
            'dd/mm/yyyy' => 'dd/mm/yyyy',
            'mm/dd/yyyy' => 'mm/dd/yyyy',
            'yyyy/mm/dd' => 'yyyy/mm/dd'
        ),
    ),
    'notification' => array(
        'created' => 'Merchant created',
        'updated' => 'Merchant updated',
        'deleted' => 'Merchant deleted',
    ),
    'view' => array(
        'menu' => 'Merchants',
        'field' => array(
            'id' => '#',
            'name' => 'Name',
            'workflow' => 'Status',
            'reg_no' => 'Reg #',
            'tax_id' => 'Tax id',
            'vision' => 'Vision',
            'mission' => 'Mission',
            'about' => 'About',
            'phone' => 'Phone',
            'email' => 'Email',
            'country_id' => 'Country',
            'province' => 'Province',
            'city' => 'City',
            'street' => 'Street',
            'postal_code' => 'Postal code',
            'timezone_id' => 'Timezone',
            'currency_id' => 'Currency',
            'date_format' => 'Date format',
            'website' => 'Website',
            'facebook' => 'Facebook',
            'twitter' => 'Twitter',
            'bank_name' => 'Bank name',
            'bank_sort_code' => 'Bank sort code',
            'bank_account_name' => 'Bank account name',
            'bank_account_number' => 'Bank account number',
            'bank_postal_code' => 'Bank postal code',
        ),
        'actions' => array(
            'delete' => array(
                'confirm' => 'Delete merchant?',
                'deleteMany' => 'Deleted :count merchants',
                'confirmMany' => 'Delete :count merchants?',
                'delete' => 'Delete',
                'cancel' => 'Cancel',
            ),
            'undelete' => array(
                'undoDelete' => 'Undo delete',
                'undeleting' => 'Un deleting...',
                'undeleted' => 'Un deleted :count merchants',
            ),
        ),
        'link' => array(
            'list' => 'Merchants list',
            'add' => 'Add merchant',
            'found' => '{0} :count merchants | {1} :count merchant | [2,Inf] :count merchants',
        )
    ),
    'merchantDetailedPage' => array(
        'title' => 'Merchant: :title #:id'
    ),
    'merchantListPage' => array(
        'title' => 'List of merchants'
    ),
    'merchantPostPage' => array(
        'actionTitle' => array(
            1 => 'Create merchants',
            2 => 'Update merchants'
        ),
        'merchantPostView' => array(
            'form' => array(
                'media' => array(
                    'count' => 10,
                    'describe' => 0,
                    'type' => 'image',
                    'accept' => 'image/*',
                    'icons' => array(
                        array(
                            'name' => 'Photo',
                            'icon' => 'hand-down'
                        )
                    ),
                    'heading' => 'How to upload ',
                    'list' => array(
                        'Click the <strong>CAMERA</strong> <i class="icon-data-camera common-color"></i> icon below to choose your photos,',
                    )
                ),
                'merchantPost' => array(
                    'attributes' => array(
                        'method' => 'POST',
                        'route' => array(
                            1 => 'merchantsCreateMerchant',
                            2 => 'merchantsUpdateMerchant'
                        ),
                        'id' => 'merchantPost',
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
                            'title' => 'Merchant\'s details',
                            'heading' => 'Please fill in the details of the merchant.',
                            'help' => 'Please fill in all the mandatory details of this merchant.',
                            'stared' => 1,
                            'rows' => array(
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Status',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'workflow',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select status',
                                            'help' => '<strong>Description: </strong>The status of this merchant.<br/><strong>Do: </strong>Select the status of this merchant.<br/><strong>Star: </strong> %s ',
                                            'validator' => array(
                                                'required' => 1
                                            )
                                        ),
                                        array(
                                            'name' => 'Name',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'name',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the name eg \'XYZ Car Wash\'',
                                            'help' => '<strong>Description: </strong>The name of this merchant.<br/><strong>Do: </strong>Type the name of this merchant.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'XYZ Car Wash\'.',
                                            'validator' => array(
                                                'required' => 1
                                            )
                                        ),
                                        array(
                                            'name' => 'Reg #',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'reg_no',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the registration number eg \'CW123\'',
                                            'help' => '<strong>Description: </strong>The registration number of this merchant.<br/><strong>Do: </strong>Type the registration number of this merchant.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'CW123\'.',
                                            'validator' => array(
                                            )
                                        ),
                                        array(
                                            'name' => 'Tax id',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'tax_id',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the tax id eg \'TAX123\'',
                                            'help' => '<strong>Description: </strong>The tax id of this merchant.<br/><strong>Do: </strong>Type the tax id of this merchant.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'TAX123\'.',
                                            'validator' => array(
                                            )
                                        ),
                                    )
                                ),
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Vision',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'vision',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the vision eg \'Be the best\'',
                                            'help' => '<strong>Description: </strong>The vision of this merchant.<br/><strong>Do: </strong>Type the vision of this merchant.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'Be the best\'.',
                                            'validator' => array(
                                            )
                                        ),
                                        array(
                                            'name' => 'Mission',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'mission',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the mission eg \'Be the best\'',
                                            'help' => '<strong>Description: </strong>The mission of this merchant.<br/><strong>Do: </strong>Type the mission of this merchant.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'Be the best\'.',
                                            'validator' => array(
                                            )
                                        ),
                                    )
                                ),
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'About',
                                            'type' => 'textarea',
                                            'prepend' => 'user',
                                            'htmlName' => 'about',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the about eg \'Car Wash XYZ is\'',
                                            'help' => '<strong>Description: </strong>The about of this merchant.<br/><strong>Do: </strong>Type the about of this merchant.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'Car Wash XYZ is\'.',
                                            'validator' => array(
                                            )
                                        ),
                                    )
                                ),
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Phone (comma separated for multiple)',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'phone',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the phone, comma separated for multiple eg \'4477447744,4477447743\'',
                                            'help' => '<strong>Description: </strong>The phone of this merchant.<br/><strong>Do: </strong>Type the phone of this merchant.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'4477447744,4477447743\'.',
                                            'validator' => array(
                                            )
                                        ),
                                        array(
                                            'name' => 'Email (comma separated for multiple)',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'email',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the email, comma separated for multiple eg \'john.doe@email.com,john.doe1@email.com\'',
                                            'help' => '<strong>Description: </strong>The email of this merchant.<br/><strong>Do: </strong>Type the email of this merchant.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'john.doe@email.com,john.doe1@email.com\'.',
                                            'validator' => array(
                                            )
                                        ),
                                    )
                                ),
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Website (with http or https)',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'website',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the website eg \'www.carwash.com\'',
                                            'help' => '<strong>Description: </strong>The website of this merchant.<br/><strong>Do: </strong>Type the website of this merchant.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'www.carwash.com\'.',
                                            'validator' => array(
                                                'url' => 1,
                                            )
                                        ),
                                        array(
                                            'name' => 'Facebook page link (with http or https)',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'facebook',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the facebook page link eg \'www.carwash.com\'',
                                            'help' => '<strong>Description: </strong>The facebook page link of this merchant.<br/><strong>Do: </strong>Type the facebook page link of this merchant.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'www.carwash.com\'.',
                                            'validator' => array(
                                                'url' => 1,
                                            )
                                        ),
                                        array(
                                            'name' => 'Twitter link (with http or https)',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'twitter',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the twitter link  eg \'www.carwash.com\'',
                                            'help' => '<strong>Description: </strong>The twitter of this merchant.<br/><strong>Do: </strong>Type the twitter of this merchant.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'www.carwash.com\'.',
                                            'validator' => array(
                                                'url' => 1,
                                            )
                                        ),
                                    )
                                ),
                            )
                        ),
                        array(
                            'id' => 'bank',
                            'title' => 'Bank information',
                            'heading' => 'Please fill in the bank information of the merchant.',
                            'help' => 'Please fill in all the mandatory bank information of this merchant.',
                            'stared' => 1,
                            'rows' => array(
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Bank name',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'bank_name',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the bank name eg \'Barclays\'',
                                            'help' => '<strong>Description: </strong>The bank name of this merchant.<br/><strong>Do: </strong>Type the bank name of this merchant.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'Barclays\'.',
                                            'validator' => array(
                                            )
                                        ),
                                        array(
                                            'name' => 'Bank sort code',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'bank_sort_code',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the bank sort code eg \'BLYS\'',
                                            'help' => '<strong>Description: </strong>The bank sort code of this merchant.<br/><strong>Do: </strong>Type the bank sort code of this merchant.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'BLYS\'.',
                                            'validator' => array(
                                            )
                                        ),
                                        array(
                                            'name' => 'Bank postal code',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'bank_postal_code',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the bank postal code eg \'LON01\'',
                                            'help' => '<strong>Description: </strong>The bank postal code of this merchant.<br/><strong>Do: </strong>Type the bank postal code of this merchant.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'LON01\'.',
                                            'validator' => array(
                                            )
                                        ),
                                    )
                                ),
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Account name',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'bank_account_name',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the account name eg \'Car Wash XYY\'',
                                            'help' => '<strong>Description: </strong>The account name of this merchant.<br/><strong>Do: </strong>Type the account name of this merchant.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'Car Wash XYY\'.',
                                            'validator' => array(
                                            )
                                        ),
                                        array(
                                            'name' => 'Account number',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'bank_account_number',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the account number eg \'01010143231\'',
                                            'help' => '<strong>Description: </strong>The account number of this merchant.<br/><strong>Do: </strong>Type the account number of this merchant.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'01010143231\'.',
                                            'validator' => array(
                                            )
                                        ),
                                    )
                                ),
                            )
                        ),
                        array(
                            'id' => 'settings',
                            'title' => 'Currency and time',
                            'heading' => 'Please set the currency and time settings of this merchant.',
                            'help' => 'Please set the currency and time settings of this merchant.',
                            'stared' => 0,
                            'rows' => array(
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Time zone',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'timezone_id',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select time zone',
                                            'help' => '<strong>Description: </strong>The time zone of this merchant<br/><strong>Do: </strong>Select the time zone of this merchant.<br/></strong>Star:</strong> %s',
                                            'validator' => array(
                                                'required' => 1,
                                            )
                                        ),
                                        array(
                                            'name' => 'Currency',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'currency_id',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select currency',
                                            'help' => '<strong>Description: </strong>The currency of this merchant<br/><strong>Do: </strong>Select the currency of this merchant.<br/></strong>Star:</strong> %s',
                                            'validator' => array(
                                                'required' => 1,
                                            )
                                        ),
                                        array(
                                            'name' => 'Date format',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'date_format',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select date format',
                                            'help' => '<strong>Description: </strong>The date format of this merchant<br/><strong>Do: </strong>Select the date format of this merchant.<br/></strong>Star:</strong> %s',
                                            'validator' => array(
                                                'required' => 1,
                                            )
                                        ),
                                    )
                                ),
                            )
                        ),
                        array(
                            'id' => 'address',
                            'title' => 'Address information',
                            'heading' => 'Please fill in the address of the merchant.',
                            'help' => 'Please fill in all the mandatory address of this merchant.',
                            'stared' => 1,
                            'rows' => array(
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Street',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'street',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the street eg \'Standard Street\'',
                                            'help' => '<strong>Description: </strong>The street of this merchant.<br/><strong>Do: </strong>Type the street of this merchant.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'Standard Street\'.',
                                            'validator' => array(
                                            )
                                        ),
                                        array(
                                            'name' => 'City',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'city',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the city eg \'New York\'',
                                            'help' => '<strong>Description: </strong>The city of this merchant.<br/><strong>Do: </strong>Type the city of this merchant.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'New York\'.',
                                            'validator' => array(
                                            )
                                        ),
                                        array(
                                            'name' => 'Province / State',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'province',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the province eg \'Washington DC\'',
                                            'help' => '<strong>Description: </strong>The province of this merchant.<br/><strong>Do: </strong>Type the province of this merchant.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'Washington DC\'.',
                                            'validator' => array(
                                            )
                                        ),
                                    )
                                ),
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Postal code',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'postal_code',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the postal code eg \'200200\'',
                                            'help' => '<strong>Description: </strong>The postal code of this merchant.<br/><strong>Do: </strong>Type the postal code of this merchant.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'200200\'.',
                                            'validator' => array(
                                            )
                                        ),
                                        array(
                                            'name' => 'Country',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'country_id',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select country',
                                            'help' => '<strong>Description: </strong>The country of this merchant.<br/><strong>Do: </strong>Select the country of this merchant.<br/><strong>Star: </strong> %s',
                                            'validator' => array(
                                            )
                                        ),
                                    ),
                                ),
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Id',
                                            'type' => 'hidden',
                                            'htmlName' => 'id',
                                        )
                                    )
                                ),
                            )
                        ),
                        array(
                            'id' => 'logo',
                            'title' => 'Scanned Image',
                            'heading' => 'Please upload the scanned image of the merchant.',
                            'help' => 'Please upload the scanned image of the merchant.',
                            'stared' => 0,
                            'rows' => array(
                                array(
                                    'fields' => array(
                                        array(
                                            'dataSource' => 'mediaView'
                                        )
                                    )
                                )
                            )
                        ),
                    )
                )
            )
        )
    )
);
