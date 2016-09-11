<?php

return array(
    'data' => array(
        'workflow' => array(
            '' => 'Select',
            1 => 'Open',
            2 => 'Solved',
        ),
        'in_out' => array(
            '' => 'Select',
            'in' => 'Incoming',
            'out' => 'Outgoing',
        ),
    ),
    'notification' => array(
        'created' => 'Chat created',
        'updated' => 'Chat updated',
        'deleted' => 'Chat deleted',
    ),
    'view' => array(
        'menu' => 'Chats',
        'field' => array(
            'id' => '#',
            'user_id' => 'Customer',
            'sender_id' => 'Sender',
            'recipient_id' => 'Recipient',
            'message' => 'Message',
            'in_out' => 'In / Out',
            'workflow' => 'Status',
        ),
        'actions' => array(
            'delete' => array(
                'confirm' => 'Delete chat?',
                'deleteMany' => 'Deleted :count chats',
                'confirmMany' => 'Delete :count chats?',
                'delete' => 'Delete',
                'cancel' => 'Cancel',
            ),
            'undelete' => array(
                'undoDelete' => 'Undo delete',
                'undeleting' => 'Un deleting...',
                'undeleted' => 'Un deleted :count chats',
            ),
        ),
        'link' => array(
            'list' => 'Chats list',
            'add' => 'Add chat',
            'found' => '{0} :count chats | {1} :count chat | [2,Inf] :count chats',
        )
    ),
    'chatImportPage' => array(
        'title' => 'Import chats'
    ),
    'chatDetailedPage' => array(
        'title' => 'Chat: :title #:id'
    ),
    'chatListPage' => array(
        'title' => 'List of chats'
    ),
    'chatPostPage' => array(
        'actionTitle' => array(
            1 => 'Create chats',
            2 => 'Update chats'
        ),
        'chatPostView' => array(
            'form' => array(
                'chatPost' => array(
                    'attributes' => array(
                        'method' => 'POST',
                        'route' => array(
                            1 => 'loansCreateChat',
                            2 => 'loansUpdateChat'
                        ),
                        'id' => 'chatPost',
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
                            'title' => 'Chat\'s details',
                            'heading' => 'Please fill in the details of the chat.',
                            'help' => 'Please fill in all the mandatory details of this chat.',
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
                                            'help' => '<strong>Description: </strong>The amount from of this chat.<br/><strong>Do: </strong>Type the amount from of this chat.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'1000\'.',
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
                                            'help' => '<strong>Description: </strong>The amount to of this chat.<br/><strong>Do: </strong>Type the amount to of this chat.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'5000\'.',
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
                                            'help' => '<strong>Description: </strong>The repayment period of this chat.<br/><strong>Do: </strong>Type the repayment period of this chat.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'21\'.',
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
                                            'help' => '<strong>Description: </strong>The repayment period cycle of this chat<br/><strong>Do: </strong>Select the repayment period cycle of this chat.<br/></strong>Star:</strong> %s',
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
                                            'help' => '<strong>Description: </strong>The interest rate of this chat.<br/><strong>Do: </strong>Type the interest rate of this chat.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'11\'.',
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
                                            'help' => '<strong>Description: </strong>The pay every of this chat.<br/><strong>Do: </strong>Type the pay every of this chat.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'7\'.',
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
                                            'help' => '<strong>Description: </strong>The cycle of this chat<br/><strong>Do: </strong>Select the cycle of this chat.<br/></strong>Star:</strong> %s',
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
