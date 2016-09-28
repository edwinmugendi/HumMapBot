<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | Update Language Lines
      |--------------------------------------------------------------------------
     */
    'data' => array(
        'type' => array(
            '' => 'Select',
            'incoming' => 'Incoming',
            'outgoing' => 'Outgoing',
        ),
        'channel' => array(
            '' => 'Select',
            'telegram' => 'Telegram',
        /* 'facebook' => 'Facebook', */
        )
    ),
    'notification' => array(
        'created' => 'Update created',
        'updated' => 'Update updated',
        'deleted' => 'Update deleted',
    ),
    'view' => array(
        'menu' => 'Updates',
        'field' => array(
            'id' => '#',
            'update_id' => 'Update id',
            'type' => 'Type',
            'message' => 'Message',
            'channel' => 'Channel',
        ),
        'actions' => array(
            'delete' => array(
                'confirm' => 'Delete update?',
                'deleteMany' => 'Deleted :count updates',
                'confirmMany' => 'Delete :count updates?',
                'delete' => 'Delete',
                'cancel' => 'Cancel',
            ),
            'undelete' => array(
                'undoDelete' => 'Undo delete',
                'undeleting' => 'Un deleting...',
                'undeleted' => 'Un deleted :count updates',
            ),
        ),
        'link' => array(
            'list' => 'Updates list',
            'add' => 'Add update',
            'found' => '{0} :count updates | {1} :count update | [2,Inf] :count updates',
        )
    ),
    'updateDetailedPage' => array(
        'title' => 'Update: :title #:id'
    ),
    'updateListPage' => array(
        'title' => 'List of updates'
    ),
    'updatePostPage' => array(
        'actionTitle' => array(
            1 => 'Create updates',
            2 => 'Update updates'
        ),
        'updatePostView' => array(
            'form' => array(
                'updatePost' => array(
                    'attributes' => array(
                        'method' => 'POST',
                        'route' => array(
                            1 => 'surveysCreateUpdate',
                            2 => 'surveysUpdateUpdate'
                        ),
                        'id' => 'updatePost',
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
                            'title' => 'Update\'s details',
                            'heading' => 'Please fill in the details of the update.',
                            'help' => 'Please fill in all the mandatory details of this update.',
                            'stared' => 1,
                            'rows' => array(
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Channel',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'channel',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select channel',
                                            'help' => '<strong>Description: </strong>The channel of this update.<br/><strong>Do: </strong>Select the channel of this update.<br/><strong>Star: </strong> %s ',
                                            'validator' => array(
                                                'required' => 1
                                            )
                                        ),
                                        array(
                                            'name' => 'Type',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'type',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select type',
                                            'help' => '<strong>Description: </strong>The type of this update.<br/><strong>Do: </strong>Select the type of this update.<br/><strong>Star: </strong> %s ',
                                            'validator' => array(
                                                'required' => 1
                                            )
                                        ),
                                        array(
                                            'name' => 'Update id',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'update_id',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the update id eg \'12213123\'',
                                            'help' => '<strong>Description: </strong>The update id of this update.<br/><strong>Do: </strong>Type the update id of this update.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'12213123\'.',
                                            'validator' => array(
                                                'required' => 1
                                            )
                                        ),
                                        array(
                                            'name' => 'Message',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'message',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the message id eg \'{text=\'Hello World\'}\'',
                                            'help' => '<strong>Description: </strong>The message of this update.<br/><strong>Do: </strong>Type the message id of this update.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'{text=\'Hello World\'}\'.',
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
