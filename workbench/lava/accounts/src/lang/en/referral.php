<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | Referrals Language Lines
      |--------------------------------------------------------------------------
     */
    'notification' => array(
        'created' => 'Referral created',
        'updated' => 'Referral updated',
        'deleted' => 'Referral deleted',
        'list' => 'Referral list',
        'is_referral_code_valid' => array(
            'created' => 'Referral created',
            'error' => 'An error occurred. Kindly try again later',
            'exists' => 'This referral is already recorded',
        )
    ),
    'data' => array(
        'workflow' => array(
            '' => 'Select',
            1 => 'Awaiting transaction',
            2 => 'Promotion awarded',
        ),
    ),
    'view' => array(
        'menu' => 'Referrals',
        'field' => array(
            'id' => 'Id',
            'referral_code' => 'Referral code',
            'referee_id' => 'Referee',
            'referrer_id' => 'Referrer',
            'description' => 'Description',
            'workflow' => 'Status',
            'transaction_id' => 'Transaction',
        ),
        'actions' => array(
            'delete' => array(
                'confirm' => 'Delete referral?',
                'deleteMany' => 'Deleted :count referrals',
                'confirmMany' => 'Delete :count referrals?',
                'delete' => 'Delete',
                'cancel' => 'Cancel',
            ),
            'undelete' => array(
                'undoDelete' => 'Undo delete',
                'undeleting' => 'Un deleting...',
                'undeleted' => 'Un deleted :count referrals',
            ),
        ),
        'link' => array(
            'list' => 'Referrals list',
            'add' => 'Add referral',
            'found' => '{0} :count referrals | {1} :count referral | [2,Inf] :count referrals',
        )
    ),
    'referralImportPage' => array(
        'title' => 'Import referrals'
    ),
    'referralDetailedPage' => array(
        'title' => 'Referral: :title #:id'
    ),
    'referralListPage' => array(
        'title' => 'List of referrals'
    ),
    'referralPostPage' => array(
        'actionTitle' => array(
            1 => 'Create referrals',
            2 => 'Update referrals'
        ),
        'referralPostView' => array(
            'form' => array(
                'referralPost' => array(
                    'attributes' => array(
                        'method' => 'POST',
                        'route' => array(
                            1 => 'accountsCreateReferral',
                            2 => 'accountsUpdateReferral'
                        ),
                        'id' => 'referralPost',
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
                            'title' => 'Referral\'s details',
                            'heading' => 'Please fill in the details of the referral.',
                            'help' => 'Please fill in all the mandatory details of this referral.',
                            'stared' => 1,
                            'rows' => array(
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Organization',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'organization_id',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select merchant',
                                            'help' => '<strong>Description: </strong>The merchant of this referral<br/><strong>Do: </strong>Select the merchant of this referral.<br/></strong>Star:</strong> %s',
                                            'validator' => array(
                                                'required' => 1,
                                            )
                                        ),
                                        array(
                                            'name' => 'Code',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'code',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the code eg \'PROMO\'',
                                            'help' => '<strong>Description: </strong>The code of this referral.<br/><strong>Do: </strong>Type the code of this referral.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'PROMO\'.',
                                            'validator' => array(
                                                'required' => 1
                                            )
                                        ),
                                        array(
                                            'name' => 'Location (Referral will apply only to this location)',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'location_id',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select location',
                                            'help' => '<strong>Description: </strong>The location of this referral<br/><strong>Do: </strong>Select the location of this referral.<br/></strong>Star:</strong> %s',
                                            'validator' => array(
                                            )
                                        ),
                                    )
                                ),
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Description',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'description',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the description eg \'Full body wash is\'',
                                            'help' => '<strong>Description: </strong>The description of this referral.<br/><strong>Do: </strong>Type the description of this referral.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'Full body wash is\'.',
                                            'validator' => array(
                                                'required' => 1,
                                            )
                                        ),
                                    )
                                ),
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Type',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'type',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select type',
                                            'help' => '<strong>Description: </strong>The type of this referral<br/><strong>Do: </strong>Select the type of this referral.<br/></strong>Star:</strong> %s',
                                            'validator' => array(
                                                'required' => 1,
                                            )
                                        ),
                                        array(
                                            'name' => 'Value',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'value',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the value eg \'10\'',
                                            'help' => '<strong>Description: </strong>The value of this referral.<br/><strong>Do: </strong>Type the value of this referral.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'10\'.',
                                            'validator' => array(
                                                'number' => 1,
                                                'required' => 1,
                                            )
                                        ),
                                        array(
                                            'name' => 'Expiry date',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'expiry_date',
                                            'class' => 'datePicker',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select expiry date',
                                            'help' => '<strong>Description: </strong>The expiry date of this referral.<br/><strong>Do: </strong>Click to select the expiry date of this referral.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'1970-06-12\'.',
                                            'validator' => array(
                                                'required' => 1,
                                            )
                                        ),
                                        array(
                                            'name' => 'Applicable only to customers who have not transacted yet or simply new customers?',
                                            'type' => 'checkbox',
                                            'prepend' => 'user',
                                            'htmlName' => 'new_customer',
                                            'checked' => 0,
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Applicable only to customers who have not transacted yet or simply new customers?',
                                            'help' => '<strong>Description: </strong>Is this referral only applicable to customers who have not transacted?<br/><strong>Do: </strong>Check if this referral is only applicable to customer who have not transacted.<br/></strong>Star:</strong> %s',
                                            'validator' => array(
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
                                ),
                            )
                        ),
                    )
                )
            )
        )
    )
);
