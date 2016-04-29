<?php

return array(
    'data' => array(
        'period_cycle' => array(
            '' => 'Select',
            'days' => 'Days',
            'weeks' => 'Weeks',
            'months' => 'Months',
        ),
        'cycle' => array(
            '' => 'Select',
            'days' => 'Days',
            'weeks' => 'Weeks',
            'months' => 'Months',
        ),
    ),
    'notification' => array(
        'created' => 'Plan created',
        'updated' => 'Plan updated',
        'deleted' => 'Plan deleted',
    ),
    'view' => array(
        'menu' => 'Plans',
        'field' => array(
            'id' => '#',
            'period' => 'Repayment period',
            'period_cycle' => 'Repayment period cycle',
            'interest_rate' => 'Interest',
            'pay_every' => 'Pay every',
            'cycle' => 'Pay every cycle',
            'amount_from' => 'Amount from',
            'amount_to' => 'Amount to',
        ),
        'actions' => array(
            'delete' => array(
                'confirm' => 'Delete plan?',
                'deleteMany' => 'Deleted :count plans',
                'confirmMany' => 'Delete :count plans?',
                'delete' => 'Delete',
                'cancel' => 'Cancel',
            ),
            'undelete' => array(
                'undoDelete' => 'Undo delete',
                'undeleting' => 'Un deleting...',
                'undeleted' => 'Un deleted :count plans',
            ),
        ),
        'link' => array(
            'list' => 'Plans list',
            'add' => 'Add plan',
            'found' => '{0} :count plans | {1} :count plan | [2,Inf] :count plans',
        )
    ),
    'planDetailedPage' => array(
        'title' => 'Plan: :title #:id'
    ),
    'planListPage' => array(
        'title' => 'List of plans'
    ),
    'planPostPage' => array(
        'actionTitle' => array(
            1 => 'Create plans',
            2 => 'Update plans'
        ),
        'planPostView' => array(
            'form' => array(
                'planPost' => array(
                    'attributes' => array(
                        'method' => 'POST',
                        'route' => array(
                            1 => 'loansCreatePlan',
                            2 => 'loansUpdatePlan'
                        ),
                        'id' => 'planPost',
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
                            'title' => 'Plan\'s details',
                            'heading' => 'Please fill in the details of the plan.',
                            'help' => 'Please fill in all the mandatory details of this plan.',
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
                                            'help' => '<strong>Description: </strong>The amount from of this plan.<br/><strong>Do: </strong>Type the amount from of this plan.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'1000\'.',
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
                                            'help' => '<strong>Description: </strong>The amount to of this plan.<br/><strong>Do: </strong>Type the amount to of this plan.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'5000\'.',
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
                                            'help' => '<strong>Description: </strong>The repayment period of this plan.<br/><strong>Do: </strong>Type the repayment period of this plan.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'21\'.',
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
                                            'help' => '<strong>Description: </strong>The repayment period cycle of this plan<br/><strong>Do: </strong>Select the repayment period cycle of this plan.<br/></strong>Star:</strong> %s',
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
                                            'help' => '<strong>Description: </strong>The interest rate of this plan.<br/><strong>Do: </strong>Type the interest rate of this plan.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'11\'.',
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
                                            'help' => '<strong>Description: </strong>The pay every of this plan.<br/><strong>Do: </strong>Type the pay every of this plan.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'7\'.',
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
                                            'help' => '<strong>Description: </strong>The cycle of this plan<br/><strong>Do: </strong>Select the cycle of this plan.<br/></strong>Star:</strong> %s',
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
