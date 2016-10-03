<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | Form Language Lines
      |--------------------------------------------------------------------------
     */
    'data' => array(
        'workflow' => array(
            '' => 'Select',
            'published' => 'Published',
            'unpublished' => 'Un-unpublished',
        ),
    ),
    'notification' => array(
        'created' => 'Form created',
        'updated' => 'Form updated',
        'deleted' => 'Form deleted',
    ),
    'view' => array(
        'menu' => 'Forms',
        'modal_heading' => 'Options',
        'field' => array(
            'id' => '#',
            'name' => 'Name',
            'workflow' => 'Status',
        ),
        'actions' => array(
            'delete' => array(
                'confirm' => 'Delete form?',
                'deleteMany' => 'Deleted :count forms',
                'confirmMany' => 'Delete :count forms?',
                'delete' => 'Delete',
                'cancel' => 'Cancel',
            ),
            'undelete' => array(
                'undoDelete' => 'Undo delete',
                'undeleting' => 'Un deleting...',
                'undeleted' => 'Un deleted :count forms',
            ),
            'edit_questions' => array(
                'edit_questions' => 'Edit questions'
            ),
        ),
        'link' => array(
            'list' => 'Forms list',
            'add' => 'Add form',
            'found' => '{0} :count forms | {1} :count form | [2,Inf] :count forms',
        )
    ),
    'formQuestionPage' => array(
        'title' => 'Form: :title #:id',
    ),
    'formDetailedPage' => array(
        'title' => 'Form: :title #:id'
    ),
    'formListPage' => array(
        'title' => 'List of forms'
    ),
    'formPostPage' => array(
        'actionTitle' => array(
            1 => 'Create forms',
            2 => 'Update forms'
        ),
        'formPostView' => array(
            'form' => array(
                'media' => array(
                    'count' => 10,
                    'describe' => 0,
                    'type' => 'image',
                    'accept' => 'image/*',
                    'icons' => array(
                        array(
                            'name' => 'Photo',
                            'icon' => 'arrow-down'
                        )
                    ),
                    'heading' => 'How to upload ',
                    'list' => array(
                        'Click the <strong>CAMERA</strong> <i class="icon-data-camera common-color"></i> icon below to choose your photos,',
                    )
                ),
                'formPost' => array(
                    'attributes' => array(
                        'method' => 'POST',
                        'route' => array(
                            1 => 'surveysCreateForm',
                            2 => 'surveysUpdateForm'
                        ),
                        'id' => 'formPost',
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
                            'title' => 'Form\'s details',
                            'heading' => 'Please fill in the details of the form.',
                            'help' => 'Please fill in all the mandatory details of this form.',
                            'stared' => 1,
                            'rows' => array(
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Status',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'workflow',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select status',
                                            'help' => '<strong>Description: </strong>The status of this form.<br/><strong>Do: </strong>Select the status of this form.<br/><strong>Star: </strong> %s ',
                                            'validator' => array(
                                                'required' => 1
                                            )
                                        ),
                                        array(
                                            'name' => 'Name',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'name',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the name eg \'Contact form\'',
                                            'help' => '<strong>Description: </strong>The name of this form.<br/><strong>Do: </strong>Type the name of this form.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'Contact form\'.',
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
                        array(
                            'id' => 'logo',
                            'title' => 'Images',
                            'heading' => 'Please upload the images of the form.',
                            'help' => 'Please upload the images of the form.',
                            'stared' => 0,
                            'rows' => array(
                                array(
                                    'fields' => array(
                                        array(
                                            'dataSource' => 'mediaView'
                                        )
                                    )
                                )
                            )
                        ),
                    )
                )
            )
        )
    )
);
