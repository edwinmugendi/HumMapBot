<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | Promotions Language Lines
      |--------------------------------------------------------------------------
     */
    'notification' => array(
        'is_promotion_code_valid' => array(
            'claimed' => 'Promotion code :code claimed',
            'expired' => 'This promotion code :code has expired',
            'new_customers' => 'This promotion code :code is only available for new customers',
            'redeemed' => 'You have already redeemed this promotion code :code',
            'already_claimed' => 'You have already claimed this promotion code :code but not used it yet'
        ),
        'created' => 'Promotion created',
        'updated' => 'Promotion updated',
        'deleted' => 'Promotion deleted',
        'list' => 'Promotion list',
    ),
    'data' => array(
        'type' => array(
            '' => 'Select',
            1 => 'Fixed value',
            2 => 'Percentage of price',
        ),
        'new_customer' => array(
            '' => 'Select',
            1 => 'Yes',
            0 => 'No',
        ),
    ),
    'view' => array(
        'menu' => 'Promotions',
        'field' => array(
            'id' => 'Id',
            'code' => 'Code',
            'merchant_id' => 'Merchant id',
            'location_id' => 'Location id',
            'description' => 'Description',
            'new_customer' => 'New customer',
            'expiry_date' => 'Expiry date',
            'type' => 'Type',
            'value' => 'Value',
        ),
        'actions' => array(
            'delete' => array(
                'confirm' => 'Delete promotion?',
                'deleteMany' => 'Deleted :count promotions',
                'confirmMany' => 'Delete :count promotions?',
                'delete' => 'Delete',
                'cancel' => 'Cancel',
            ),
            'undelete' => array(
                'undoDelete' => 'Undo delete',
                'undeleting' => 'Un deleting...',
                'undeleted' => 'Un deleted :count promotions',
            ),
        ),
        'link' => array(
            'list' => 'Promotions list',
            'add' => 'Add promotion',
            'found' => '{0} :count promotions | {1} :count promotion | [2,Inf] :count promotions',
        )
    ),
    'promotionDetailedPage' => array(
        'title' => 'Promotion: :title #:id'
    ),
    'promotionListPage' => array(
        'title' => 'List of promotions'
    ),
    'promotionPostPage' => array(
        'actionTitle' => array(
            1 => 'Create promotions',
            2 => 'Update promotions'
        ),
        'promotionPostView' => array(
            'form' => array(
                'promotionPost' => array(
                    'attributes' => array(
                        'method' => 'POST',
                        'route' => array(
                            1 => 'productsCreatePromotion',
                            2 => 'productsUpdatePromotion'
                        ),
                        'id' => 'promotionPost',
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
                            'title' => 'Promotion\'s details',
                            'heading' => 'Please fill in the details of the promotion.',
                            'help' => 'Please fill in all the mandatory details of this promotion.',
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
                                            'help' => '<strong>Description: </strong>The merchant of this promotion<br/><strong>Do: </strong>Select the merchant of this promotion.<br/></strong>Star:</strong> %s',
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
                                            'help' => '<strong>Description: </strong>The code of this promotion.<br/><strong>Do: </strong>Type the code of this promotion.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'PROMO\'.',
                                            'validator' => array(
                                                'required' => 1
                                            )
                                        ),
                                        array(
                                            'name' => 'Location (Promotion will apply only to this location)',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'location_id',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select location',
                                            'help' => '<strong>Description: </strong>The location of this promotion<br/><strong>Do: </strong>Select the location of this promotion.<br/></strong>Star:</strong> %s',
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
                                            'help' => '<strong>Description: </strong>The description of this promotion.<br/><strong>Do: </strong>Type the description of this promotion.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'Full body wash is\'.',
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
                                            'help' => '<strong>Description: </strong>The type of this promotion<br/><strong>Do: </strong>Select the type of this promotion.<br/></strong>Star:</strong> %s',
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
                                            'help' => '<strong>Description: </strong>The value of this promotion.<br/><strong>Do: </strong>Type the value of this promotion.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'10\'.',
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
                                            'help' => '<strong>Description: </strong>The expiry date of this promotion.<br/><strong>Do: </strong>Click to select the expiry date of this promotion.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'1970-06-12\'.',
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
                                            'help' => '<strong>Description: </strong>Is this promotion only applicable to customers who have not transacted?<br/><strong>Do: </strong>Check if this promotion is only applicable to customer who have not transacted.<br/></strong>Star:</strong> %s',
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
