<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | Option Language Lines
      |--------------------------------------------------------------------------
     */

    'notification' => array(
        'created' => 'Option created',
        'updated' => 'Option updated',
        'deleted' => 'Option deleted',
    ),
    'view' => array(
        'menu' => 'Options',
        'field' => array(
            'id' => '#',
            'title' => 'Title',
            'value' => 'Value',
        ),
        'actions' => array(
            'delete' => array(
                'confirm' => 'Delete option?',
                'deleteMany' => 'Deleted :count options',
                'confirmMany' => 'Delete :count options?',
                'delete' => 'Delete',
                'cancel' => 'Cancel',
            ),
            'undelete' => array(
                'undoDelete' => 'Undo delete',
                'undeleting' => 'Un deleting...',
                'undeleted' => 'Un deleted :count options',
            ),
        ),
        'link' => array(
            'list' => 'Options list',
            'add' => 'Add option',
            'found' => '{0} :count options | {1} :count option | [2,Inf] :count options',
        )
    ),
    'optionDetailedPage' => array(
        'title' => 'Option: :title #:id'
    ),
    'optionListPage' => array(
        'title' => 'List of options'
    ),
    'optionPostPage' => array(
        'actionTitle' => array(
            1 => 'Create options',
            2 => 'Update options'
        ),
        'optionPostView' => array(
            'form' => array(
                'optionPost' => array(
                    'attributes' => array(
                        'method' => 'POST',
                        'route' => array(
                            1 => 'surveysCreateOption',
                            2 => 'surveysUpdateOption'
                        ),
                        'id' => 'optionPost',
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
                            'title' => 'Option\'s details',
                            'heading' => 'Please fill in the details of the option.',
                            'help' => 'Please fill in all the mandatory details of this option.',
                            'stared' => 1,
                            'rows' => array(
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Title',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'title',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the title eg \'Male\'',
                                            'help' => '<strong>Description: </strong>The title of this option.<br/><strong>Do: </strong>Type the title of this option.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'Male\'.',
                                            'validator' => array(
                                                'required' => 1
                                            )
                                        ),
                                        array(
                                            'name' => 'Value',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'value',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the value eg \'m\'',
                                            'help' => '<strong>Description: </strong>The value of this option.<br/><strong>Do: </strong>Type the value of this option.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'m\'.',
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
