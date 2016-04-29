<?php

return array(
    'data' => array(
        'currency' => array(
            'KES' => 'KES',
        ),
        'period_cycle' => array(
            '' => 'Select',
            'days' => 'Days',
            'weeks' => 'Weeks',
            'months' => 'Months',
        ),
        'on_schedule' => array(
            '' => 'Select',
            'yes' => 'Yes',
            'no' => 'No',
        ),
        'cycle' => array(
            '' => 'Select',
            'days' => 'Days',
            'weeks' => 'Weeks',
            'months' => 'Months',
        ),
        'workflow' => array(
            '' => 'Select',
            'PNDAPPR' => 'Pending approval',
            'DISBURSED' => 'Disbursed',
            'ONSCHEDULE' => 'On schedule',
            'PAID' => 'Paid',
            'OVERPAID' => 'Over paid'
        ),
    ),
    'notification' => array(
        'created' => 'Loan created',
        'updated' => 'Loan updated',
        'deleted' => 'Loan deleted',
    ),
    'view' => array(
        'menu' => 'Loans',
        'field' => array(
            'id' => '#',
            'user_id' => 'Customer',
            'plan_id' => 'Plan',
            'currency' => 'Currency',
            'principal' => 'Principal',
            'interest' => 'Interest',
            'workflow' => 'Status',
            'balance' => 'Balance',
            'on_schedule' => 'On schedule',
            'disbursement_date' => 'Disbursement date',
            'due_date' => 'Due date',
            'instalment' => 'Instalment',
            'instalments' => '# of instalments',
            'interest_rate' => 'Interest rate',
            'period' => 'Repayment period',
            'period_cycle' => 'Repayment period cycle',
            'pay_every' => 'Pay every',
            'cycle' => 'Pay every cycle',
            'officer_id' => 'Loan officer',
        ),
        'actions' => array(
            'delete' => array(
                'confirm' => 'Delete loan?',
                'deleteMany' => 'Deleted :count loans',
                'confirmMany' => 'Delete :count loans?',
                'delete' => 'Delete',
                'cancel' => 'Cancel',
            ),
            'undelete' => array(
                'undoDelete' => 'Undo delete',
                'undeleting' => 'Un deleting...',
                'undeleted' => 'Un deleted :count loans',
            ),
        ),
        'link' => array(
            'list' => 'Loans list',
            'add' => 'Add loan',
            'found' => '{0} :count loans | {1} :count loan | [2,Inf] :count loans',
        )
    ),
    'loanDetailedPage' => array(
        'title' => 'Loan: :title #:id'
    ),
    'loanListPage' => array(
        'title' => 'List of loans'
    ),
    'loanPostPage' => array(
        'actionTitle' => array(
            1 => 'Create loans',
            2 => 'Update loans'
        ),
        'loanPostView' => array(
            'form' => array(
                'loanPost' => array(
                    'attributes' => array(
                        'method' => 'POST',
                        'route' => array(
                            1 => 'loansCreateLoan',
                            2 => 'loansUpdateLoan'
                        ),
                        'id' => 'loanPost',
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
                            'title' => 'Loan\'s details',
                            'heading' => 'Please fill in the details of the loan.',
                            'help' => 'Please fill in all the mandatory details of this loan.',
                            'stared' => 1,
                            'rows' => array(
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Customer',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'user_id',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select customer',
                                            'help' => '<strong>Description: </strong>The customer of this loan<br/><strong>Do: </strong>Select the customer of this loan.<br/></strong>Star:</strong> %s',
                                            'validator' => array(
                                                'required' => 1,
                                            )
                                        ),
                                        array(
                                            'name' => 'Loan officer',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'officer_id',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select loan officer',
                                            'help' => '<strong>Description: </strong>The loan officer of this loan<br/><strong>Do: </strong>Select the loan officer of this loan.<br/></strong>Star:</strong> %s',
                                            'validator' => array(
                                                'required' => 1,
                                            )
                                        ),
                                        array(
                                            'name' => 'Plan',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'plan_id',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select plan',
                                            'help' => '<strong>Description: </strong>The plan of this loan<br/><strong>Do: </strong>Select the plan of this loan.<br/></strong>Star:</strong> %s',
                                            'validator' => array(
                                                'required' => 1,
                                            )
                                        ),
                                        array(
                                            'name' => 'Currency',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'currency',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select currency',
                                            'help' => '<strong>Description: </strong>The currency of this loan<br/><strong>Do: </strong>Select the currency of this loan.<br/></strong>Star:</strong> %s',
                                            'validator' => array(
                                                'required' => 1,
                                            )
                                        ),
                                    )
                                ),
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Principal',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'principal',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the principal eg \'1000\'',
                                            'help' => '<strong>Description: </strong>The principal of this loan.<br/><strong>Do: </strong>Type the principal of this loan.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'1000\'.',
                                            'validator' => array(
                                                'required' => 1,
                                                'number' => 1
                                            )
                                        ),
                                        array(
                                            'name' => 'Interest',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'interest',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the interest eg \'100\'',
                                            'help' => '<strong>Description: </strong>The interest of this loan.<br/><strong>Do: </strong>Type the interest of this loan.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'100\'.',
                                            'validator' => array(
                                                'required' => 1,
                                                'number' => 1
                                            )
                                        ),
                                        array(
                                            'name' => 'Status',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'workflow',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select workflow',
                                            'help' => '<strong>Description: </strong>The workflow of this loan<br/><strong>Do: </strong>Select the workflow of this loan.<br/></strong>Star:</strong> %s',
                                            'validator' => array(
                                                'required' => 1,
                                            )
                                        ),
                                        array(
                                            'name' => 'Balance',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'balance',
                                            'displayed' => 1,
                                            'disabled' => 1,
                                            'placeholder' => 'Type the balance eg \'700\'',
                                            'help' => '<strong>Description: </strong>The balance of this loan.<br/><strong>Do: </strong>Type the balance of this loan.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'700\'.',
                                            'validator' => array(
                                                'number' => 1
                                            )
                                        ),
                                    )
                                ),
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'On schedule',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'on_schedule',
                                            'displayed' => 1,
                                            'disabled' => 1,
                                            'placeholder' => 'Select on schedule',
                                            'help' => '<strong>Description: </strong>The on schedule of this loan<br/><strong>Do: </strong>Select the on schedule of this loan.<br/></strong>Star:</strong> %s',
                                            'validator' => array(
                                            )
                                        ),
                                        array(
                                            'name' => 'Disbursement date',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'disbursement_date',
                                            'class' => 'datePicker',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select disbursement date',
                                            'help' => '<strong>Description: </strong>The disbursement date of this loan.<br/><strong>Do: </strong>Click to select the disbursement date of this loan.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'' . date('Y') . '-06-12\'.',
                                            'validator' => array(
                                                'required' => 1,
                                            )
                                        ),
                                        array(
                                            'name' => 'Due date',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'due_date',
                                            'class' => 'datePicker',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select due date',
                                            'help' => '<strong>Description: </strong>The due date of this loan.<br/><strong>Do: </strong>Click to select the due date of this loan.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'' . date('Y') . '-06-12\'.',
                                            'validator' => array(
                                                'required' => 1,
                                            )
                                        ),
                                        array(
                                            'name' => 'Instalment',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'instalment',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the instalment eg \'300\'',
                                            'help' => '<strong>Description: </strong>The instalment of this loan.<br/><strong>Do: </strong>Type the instalment of this loan.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'300\'.',
                                            'validator' => array(
                                                'required' => 1,
                                                'number' => 1
                                            )
                                        ),
                                        array(
                                            'name' => '# of instalments',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'instalments',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the instalments eg \'3\'',
                                            'help' => '<strong>Description: </strong>The instalments of this loan.<br/><strong>Do: </strong>Type the instalments of this loan.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'3\'.',
                                            'validator' => array(
                                                'required' => 1,
                                                'number' => 1
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
                                        'help' => '<strong>Description: </strong>The interest rate of this loan.<br/><strong>Do: </strong>Type the interest rate of this loan.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'11\'.',
                                        'validator' => array(
                                            'required' => 1,
                                            'number' => 1
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
                                        'help' => '<strong>Description: </strong>The repayment period of this loan.<br/><strong>Do: </strong>Type the repayment period of this loan.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'21\'.',
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
                                        'help' => '<strong>Description: </strong>The repayment period cycle of this loan<br/><strong>Do: </strong>Select the repayment period cycle of this loan.<br/></strong>Star:</strong> %s',
                                        'validator' => array(
                                            'required' => 1,
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
                                            'help' => '<strong>Description: </strong>The pay every of this loan.<br/><strong>Do: </strong>Type the pay every of this loan.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'7\'.',
                                            'validator' => array(
                                                'required' => 1,
                                                'integer' => 1
                                            )
                                        ),
                                        array(
                                            'name' => 'Cycle',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'cycle',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select cycle',
                                            'help' => '<strong>Description: </strong>The cycle of this loan<br/><strong>Do: </strong>Select the cycle of this loan.<br/></strong>Star:</strong> %s',
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
