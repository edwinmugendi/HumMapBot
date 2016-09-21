<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | Session Language Lines
      |--------------------------------------------------------------------------
     */
    'notification' => array(
        'created' => 'Session created',
        'updated' => 'Session updated',
        'deleted' => 'Session deleted',
    ),
    'view' => array(
        'menu' => 'Sessions',
        'field' => array(
            'id' => '#',
            'full_name' => 'Full name',
            'phone' => 'Phone',
            'current_question' => 'Current question',
        ),
        'actions' => array(
            'delete' => array(
                'confirm' => 'Delete session?',
                'deleteMany' => 'Deleted :count sessions',
                'confirmMany' => 'Delete :count sessions?',
                'delete' => 'Delete',
                'cancel' => 'Cancel',
            ),
            'undelete' => array(
                'undoDelete' => 'Undo delete',
                'undeleting' => 'Un deleting...',
                'undeleted' => 'Un deleted :count sessions',
            ),
        ),
        'link' => array(
            'list' => 'Sessions list',
            'add' => 'Add session',
            'found' => '{0} :count sessions | {1} :count session | [2,Inf] :count sessions',
        )
    ),
    'sessionDetailedPage' => array(
        'title' => 'Session: :title #:id'
    ),
    'sessionListPage' => array(
        'title' => 'List of sessions'
    ),
    'sessionPostPage' => array(
        'actionTitle' => array(
            1 => 'Create sessions',
            2 => 'Update sessions'
        ),
        'sessionPostView' => array(
            'form' => array(
                'sessionPost' => array(
                    'attributes' => array(
                        'method' => 'POST',
                        'route' => array(
                            1 => 'surveysCreateSession',
                            2 => 'surveysUpdateSession'
                        ),
                        'id' => 'sessionPost',
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
                            'title' => 'Session\'s details',
                            'heading' => 'Please fill in the details of the session.',
                            'help' => 'Please fill in all the mandatory details of this session.',
                            'stared' => 1,
                            'rows' => array(
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Full name',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'full_name',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the full name eg \'John Doe\'',
                                            'help' => '<strong>Description: </strong>The full name of this session.<br/><strong>Do: </strong>Type the full name of this session.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'John Doe\'.',
                                            'validator' => array(
                                                'required' => 1
                                            )
                                        ),
                                        array(
                                            'name' => 'Phone',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'phone',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the phone eg \'254722906835\'',
                                            'help' => '<strong>Description: </strong>The phone of this session.<br/><strong>Do: </strong>Type the phone of this session.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'254722906835\'.',
                                            'validator' => array(
                                                'required' => 1
                                            )
                                        ),
                                        array(
                                            'name' => 'Current question',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'current_question',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the current question eg \'2\'',
                                            'help' => '<strong>Description: </strong>The current question of this session.<br/><strong>Do: </strong>Type the current question of this session.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'2\'.',
                                            'validator' => array(
                                                'required' => 1
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
