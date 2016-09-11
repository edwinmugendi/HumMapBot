<?php

return array(
    'data' => array(
         'currency' => array(
            'KES' => 'KES',
        ),
        'type' => array(
            '' => 'Select',
            'dr' => 'Debit',
            'cr' => 'Credit',
        ),
        'class' => array(
            '' => 'Select',
            1 => 'Money in',
            2 => 'Money out',
            3 => 'Bill payment',
            4 => 'Top up',
            5 => 'M-shwari',
        ),
    ),
    'notification' => array(
        'created' => 'Mpesa created',
        'updated' => 'Mpesa updated',
        'deleted' => 'Mpesa deleted',
    ),
    'view' => array(
        'menu' => 'Mpesa',
        'field' => array(
            'id' => '#',
            'user_id' => 'Customer',
            'tran_id' => 'Tran id',
            'currency' => 'Currency',
            'amount' => 'Amount',
            'balance' => 'Balance',
            'account' => 'Account',
            'account_number' => 'Account number',
            'tran_date' => 'Tran date',
            'tran_datetime' => 'Tran datetime',
            'type' => 'Type',
            'class' => 'Class',
        ),
        'actions' => array(
            'delete' => array(
                'confirm' => 'Delete mpesa?',
                'deleteMany' => 'Deleted :count mpesa',
                'confirmMany' => 'Delete :count mpesa?',
                'delete' => 'Delete',
                'cancel' => 'Cancel',
            ),
            'undelete' => array(
                'undoDelete' => 'Undo delete',
                'undeleting' => 'Un deleting...',
                'undeleted' => 'Un deleted :count mpesa',
            ),
        ),
        'link' => array(
            'list' => 'Mpesa list',
            'add' => 'Add mpesa',
            'found' => '{0} :count mpesa | {1} :count mpesa | [2,Inf] :count mpesa',
        )
    ),
    'mpesaImportPage' => array(
        'title' => 'Import mpesa'
    ),
    'mpesaDetailedPage' => array(
        'title' => 'Mpesa: :title #:id'
    ),
    'mpesaListPage' => array(
        'title' => 'List of mpesa'
    ),
    'mpesaPostPage' => array(
        'actionTitle' => array(
            1 => 'Create mpesa',
            2 => 'Update mpesa'
        ),
        'mpesaPostView' => array(
            'form' => array(
                'mpesaPost' => array(
                    'attributes' => array(
                        'method' => 'POST',
                        'route' => array(
                            1 => 'loansCreateMpesa',
                            2 => 'loansUpdateMpesa'
                        ),
                        'id' => 'mpesaPost',
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
                            'title' => 'Mpesa\'s details',
                            'heading' => 'Please fill in the details of the mpesa.',
                            'help' => 'Please fill in all the mandatory details of this mpesa.',
                            'stared' => 1,
                            'rows' => array(
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Amount from',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'amount_from',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the amount from eg \'1000\'',
                                            'help' => '<strong>Description: </strong>The amount from of this mpesa.<br/><strong>Do: </strong>Type the amount from of this mpesa.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'1000\'.',
                                            'validator' => array(
                                                'required' => 1,
                                                'integer' => 1,
                                            )
                                        ),
                                        array(
                                            'name' => 'Amount to',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'amount_to',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the amount to eg \'5000\'',
                                            'help' => '<strong>Description: </strong>The amount to of this mpesa.<br/><strong>Do: </strong>Type the amount to of this mpesa.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'5000\'.',
                                            'validator' => array(
                                                'required' => 1,
                                                'integer' => 1,
                                            )
                                        ),
                                        array(
                                            'name' => 'Repayment period',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'period',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the repayment period eg \'21\'',
                                            'help' => '<strong>Description: </strong>The repayment period of this mpesa.<br/><strong>Do: </strong>Type the repayment period of this mpesa.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'21\'.',
                                            'validator' => array(
                                                'required' => 1,
                                                'integer' => 1
                                            )
                                        ),
                                        array(
                                            'name' => 'Repayment period cycle',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'period_cycle',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select period_cycle',
                                            'help' => '<strong>Description: </strong>The repayment period cycle of this mpesa<br/><strong>Do: </strong>Select the repayment period cycle of this mpesa.<br/></strong>Star:</strong> %s',
                                            'validator' => array(
                                                'required' => 1,
                                            )
                                        ),
                                    )
                                ),
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Interest rate',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'interest_rate',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the interest rate eg \'11\'',
                                            'help' => '<strong>Description: </strong>The interest rate of this mpesa.<br/><strong>Do: </strong>Type the interest rate of this mpesa.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'11\'.',
                                            'validator' => array(
                                                'required' => 1,
                                                'number' => 1
                                            )
                                        ),
                                        array(
                                            'name' => 'Pay every',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'pay_every',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the pay every eg \'7\'',
                                            'help' => '<strong>Description: </strong>The pay every of this mpesa.<br/><strong>Do: </strong>Type the pay every of this mpesa.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'7\'.',
                                            'validator' => array(
                                                'required' => 1,
                                                'integer' => 1
                                            )
                                        ),
                                        array(
                                            'name' => 'Pay every cycle',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'cycle',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select cycle',
                                            'help' => '<strong>Description: </strong>The cycle of this mpesa<br/><strong>Do: </strong>Select the cycle of this mpesa.<br/></strong>Star:</strong> %s',
                                            'validator' => array(
                                                'required' => 1,
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
