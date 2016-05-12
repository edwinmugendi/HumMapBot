<?php

return array(
    'data' => array(
        'currency' => array(
            'KES' => 'KES',
        ),
        'workflow' => array(
            '' => 'Select',
            'ACCEPTED' => 'Accepted',
            'DECLINED' => 'Declined',
        ),
    ),
    'notification' => array(
        'created' => 'Offer created',
        'updated' => 'Offer updated',
        'deleted' => 'Offer deleted',
    ),
    'view' => array(
        'menu' => 'Offers',
        'field' => array(
            'id' => '#',
            'user_id' => 'Customer',
            'plan_id' => 'Plan',
            'currency' => 'Currency',
            'principal' => 'Principal',
            'workflow' => 'Status',
        ),
        'actions' => array(
            'delete' => array(
                'confirm' => 'Delete offer?',
                'deleteMany' => 'Deleted :count offers',
                'confirmMany' => 'Delete :count offers?',
                'delete' => 'Delete',
                'cancel' => 'Cancel',
            ),
            'undelete' => array(
                'undoDelete' => 'Undo delete',
                'undeleting' => 'Un deleting...',
                'undeleted' => 'Un deleted :count offers',
            ),
        ),
        'link' => array(
            'list' => 'Offers list',
            'add' => 'Add offer',
            'found' => '{0} :count offers | {1} :count offer | [2,Inf] :count offers',
        )
    ),
    'offerDetailedPage' => array(
        'title' => 'Offer: :title #:id'
    ),
    'offerListPage' => array(
        'title' => 'List of offers'
    ),
    'offerPostPage' => array(
        'actionTitle' => array(
            1 => 'Create offers',
            2 => 'Update offers'
        ),
        'offerPostView' => array(
            'form' => array(
                'offerPost' => array(
                    'attributes' => array(
                        'method' => 'POST',
                        'route' => array(
                            1 => 'loansCreateOffer',
                            2 => 'loansUpdateOffer'
                        ),
                        'id' => 'offerPost',
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
                            'title' => 'Offer\'s details',
                            'heading' => 'Please fill in the details of the offer.',
                            'help' => 'Please fill in all the mandatory details of this offer.',
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
                                            'help' => '<strong>Description: </strong>The customer of this offer<br/><strong>Do: </strong>Select the customer of this offer.<br/></strong>Star:</strong> %s',
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
                                            'help' => '<strong>Description: </strong>The plan of this offer<br/><strong>Do: </strong>Select the plan of this offer.<br/></strong>Star:</strong> %s',
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
                                            'help' => '<strong>Description: </strong>The currency of this offer<br/><strong>Do: </strong>Select the currency of this offer.<br/></strong>Star:</strong> %s',
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
                                            'help' => '<strong>Description: </strong>The principal of this offer.<br/><strong>Do: </strong>Type the principal of this offer.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'1000\'.',
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
                                            'help' => '<strong>Description: </strong>The workflow of this offer<br/><strong>Do: </strong>Select the workflow of this offer.<br/></strong>Star:</strong> %s',
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
