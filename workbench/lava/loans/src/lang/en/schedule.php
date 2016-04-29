<?php

return array(
    'notification' => array(
        'created' => 'Schedule created',
        'updated' => 'Schedule updated',
        'deleted' => 'Schedule deleted',
    ),
    'view' => array(
        'menu' => 'Schedules',
        'field' => array(
            'id' => '#',
            'loan_id' => 'Loan',
            'due_date' => 'Due date',
            'amount' => 'amount',
        ),
        'actions' => array(
            'delete' => array(
                'confirm' => 'Delete schedule?',
                'deleteMany' => 'Deleted :count schedules',
                'confirmMany' => 'Delete :count schedules?',
                'delete' => 'Delete',
                'cancel' => 'Cancel',
            ),
            'undelete' => array(
                'undoDelete' => 'Undo delete',
                'undeleting' => 'Un deleting...',
                'undeleted' => 'Un deleted :count schedules',
            ),
        ),
        'link' => array(
            'list' => 'Schedules list',
            'add' => 'Add schedule',
            'found' => '{0} :count schedules | {1} :count schedule | [2,Inf] :count schedules',
        )
    ),
    'scheduleDetailedPage' => array(
        'title' => 'Schedule: :title #:id'
    ),
    'scheduleListPage' => array(
        'title' => 'List of schedules'
    ),
    'schedulePostPage' => array(
        'actionTitle' => array(
            1 => 'Create schedules',
            2 => 'Update schedules'
        ),
        'schedulePostView' => array(
            'form' => array(
                'schedulePost' => array(
                    'attributes' => array(
                        'method' => 'POST',
                        'route' => array(
                            1 => 'loansCreateSchedule',
                            2 => 'loansUpdateSchedule'
                        ),
                        'id' => 'schedulePost',
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
                            'title' => 'Schedule\'s details',
                            'heading' => 'Please fill in the details of the schedule.',
                            'help' => 'Please fill in all the mandatory details of this schedule.',
                            'stared' => 1,
                            'rows' => array(
                                array(
                                    'fields' => array(
                                            array(
                                            'name' => 'Loan',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'loan_id',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select loan',
                                            'help' => '<strong>Description: </strong>The loan of this schedule<br/><strong>Do: </strong>Select the loan of this schedule.<br/></strong>Star:</strong> %s',
                                            'validator' => array(
                                                'required' => 1,
                                            )
                                        ),
                                        array(
                                            'name' => 'Amount',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'amount',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the amount eg \'300\'',
                                            'help' => '<strong>Description: </strong>The amount of this schedule.<br/><strong>Do: </strong>Type the amount of this schedule.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'300\'.',
                                            'validator' => array(
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
                                            'help' => '<strong>Description: </strong>The due date of this schedule.<br/><strong>Do: </strong>Click to select the due date of this schedule.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'' . date('Y') . '-06-12\'.',
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
