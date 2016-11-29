<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | Message Language Lines
      |--------------------------------------------------------------------------
     */
    'data' => array(
        'type' => array(
            '' => 'Select',
            'in' => 'In',
            'out' => 'Out',
        )
    ),
    'notification' => array(
        'created' => 'Message created',
        'updated' => 'Message updated',
        'deleted' => 'Message deleted',
    ),
    'view' => array(
        'menu' => 'Messages',
        'field' => array(
            'id' => '#',
            'session_id' => 'Session',
            'text' => 'Text',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
            'type' => 'Type',
        ),
        'actions' => array(
            'delete' => array(
                'confirm' => 'Delete message?',
                'deleteMany' => 'Deleted :count messages',
                'confirmMany' => 'Delete :count messages?',
                'delete' => 'Delete',
                'cancel' => 'Cancel',
            ),
            'undelete' => array(
                'undoDelete' => 'Undo delete',
                'undeleting' => 'Un deleting...',
                'undeleted' => 'Un deleted :count messages',
            ),
        ),
        'link' => array(
            'list' => 'Messages list',
            'add' => 'Add message',
            'found' => '{0} :count messages | {1} :count message | [2,Inf] :count messages',
        )
    ),
    'messageDetailedPage' => array(
        'title' => 'Message: :title #:id'
    ),
    'messageListPage' => array(
        'title' => 'List of messages'
    ),
    'messagePostPage' => array(
        'actionTitle' => array(
            1 => 'Create messages',
            2 => 'Update messages'
        ),
        'messagePostView' => array(
            'form' => array(
                'messagePost' => array(
                    'attributes' => array(
                        'method' => 'POST',
                        'route' => array(
                            1 => 'surveysCreateMessage',
                            2 => 'surveysUpdateMessage'
                        ),
                        'id' => 'messagePost',
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
                            'title' => 'Message\'s details',
                            'heading' => 'Please fill in the details of the message.',
                            'help' => 'Please fill in all the mandatory details of this message.',
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
                                            'help' => '<strong>Description: </strong>The full name of this message.<br/><strong>Do: </strong>Type the full name of this message.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'John Doe\'.',
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
                                            'help' => '<strong>Description: </strong>The phone of this message.<br/><strong>Do: </strong>Type the phone of this message.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'254722906835\'.',
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
                                            'help' => '<strong>Description: </strong>The current question of this message.<br/><strong>Do: </strong>Type the current question of this message.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'2\'.',
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
