<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | Question Language Lines
      |--------------------------------------------------------------------------
     */
    'data' => array(
        'type' => array(
            '' => 'Select',
            'text' => 'Text',
            'integer' => 'Integer',
            'decimal' => 'Decimal',
            'photo' => 'Photo',
            'gps' => 'GPS',
            'radio' => 'Single select (Radio)',
            'checkbox' => 'Multi select (checkbox)'
        ),
    ),
    'notification' => array(
        'created' => 'Question created',
        'updated' => 'Question updated',
        'deleted' => 'Question deleted',
        'form_updated' => '{0} 0 questions updated | {1} 1 question updated | [2,Inf] :updated of :count questions updated',
    ),
    'view' => array(
        'menu' => 'Questions',
        'questions_list' => 'List of questions',
        'field' => array(
            'id' => '#',
            'name' => 'Name',
            'type' => 'Type',
            'regex' => 'regex',
            'title' => 'Title',
            'error_message' => 'Error message',
        ),
        'actions' => array(
            'delete' => array(
                'confirm' => 'Delete question?',
                'deleteMany' => 'Deleted :count questions',
                'confirmMany' => 'Delete :count questions?',
                'delete' => 'Delete',
                'cancel' => 'Cancel',
            ),
            'undelete' => array(
                'undoDelete' => 'Undo delete',
                'undeleting' => 'Un deleting...',
                'undeleted' => 'Un deleted :count questions',
            ),
        ),
        'link' => array(
            'list' => 'Questions list',
            'add' => 'Add question',
            'found' => '{0} :count questions | {1} :count question | [2,Inf] :count questions',
        )
    ),
    'questionDetailedPage' => array(
        'title' => 'Question: :title #:id'
    ),
    'questionListPage' => array(
        'title' => 'List of questions'
    ),
    'questionPostPage' => array(
        'actionTitle' => array(
            1 => 'Create questions',
            2 => 'Update questions'
        ),
        'questionPostView' => array(
            'form' => array(
                'questionPost' => array(
                    'attributes' => array(
                        'method' => 'POST',
                        'route' => array(
                            1 => 'surveysCreateQuestion',
                            2 => 'surveysUpdateQuestion'
                        ),
                        'id' => 'questionPost',
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
                            'title' => 'Question\'s details',
                            'heading' => 'Please fill in the details of the question.',
                            'help' => 'Please fill in all the mandatory details of this question.',
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
                                            'placeholder' => 'Type the title eg \'What\'s your age?\'',
                                            'help' => '<strong>Description: </strong>The title of this question.<br/><strong>Do: </strong>Type the title of this question.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'What\'s your age?\'.',
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
                                            'placeholder' => 'Type the name eg \'age\'',
                                            'help' => '<strong>Description: </strong>The name of this question.<br/><strong>Do: </strong>Type the name of this question.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'age\'.',
                                            'validator' => array(
                                                'required' => 1
                                            )
                                        ),
                                    )
                                ),
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Type',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'type',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select type',
                                            'help' => '<strong>Description: </strong>The type of this question.<br/><strong>Do: </strong>Select the type of this question.<br/><strong>Star: </strong> %s ',
                                            'validator' => array(
                                                'required' => 1
                                            )
                                        ),
                                        array(
                                            'name' => 'Regex',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'regex',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the regex eg \'number\'',
                                            'help' => '<strong>Description: </strong>The regex of this question.<br/><strong>Do: </strong>Type the regex of this question.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'number\'.',
                                            'validator' => array(
                                                'required' => 1
                                            )
                                        ),
                                    )
                                ),
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Error message',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'error_message',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the error message eg \'This field is required\'',
                                            'help' => '<strong>Description: </strong>The error message of this question.<br/><strong>Do: </strong>Type the error message of this question.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'This field is required\'.',
                                            'validator' => array(
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
