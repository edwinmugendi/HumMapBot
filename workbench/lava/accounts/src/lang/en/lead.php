<?php

return array(
    'data' => array(
        'workflow' => array(
            '' => 'Select',
            1 => 'In talks',
            2 => 'Signed up',
            3 => 'Declined',
        ),
        'action' => array(
            '' => 'Select',
            1 => 'Create Account',
        ),
        'source' => array(
            '' => 'Select',
            1 => 'Web',
            2 => 'Call in',
            3 => 'Call out',
        ),
    ),
    'notification' => array(
        'created' => 'Lead created',
        'updated' => 'Lead updated',
        'deleted' => 'Lead deleted',
    ),
    'view' => array(
        'menu' => 'Leads',
        'field' => array(
            'full_name' => 'Full name',
            'organization' => 'Company name',
            'email' => 'Company email',
            'phone' => 'Company phone',
            'number' => 'employees #',
            'email' => 'Email',
            'country_id' => 'Country',
            'source' => 'Source',
            'workflow' => 'Workflow',
            'note' => 'Note',
            'created_at' => 'Created at',
            'action' => 'Action',
        ),
        'actions' => array(
            'delete' => array(
                'confirm' => 'Delete lead?',
                'deleteMany' => 'Deleted :count leads',
                'confirmMany' => 'Delete :count leads?',
                'delete' => 'Delete',
                'cancel' => 'Cancel',
            ),
            'undelete' => array(
                'undoDelete' => 'Undo delete',
                'undeleting' => 'Un deleting...',
                'undeleted' => 'Un deleted :count leads',
            ),
        ),
        'link' => array(
            'list' => 'Leads list',
            'add' => 'Add lead',
                   'found' => '{0} :count leads | {1} :count lead | [2,Inf] :count leads',
        )
    ),
    'leadDetailedPage' => array(
         'title' => 'Lead: :title #:id'
    ),
    'leadListPage' => array(
        'title' => 'List of leads'
    ),
    'leadPostPage' => array(
        'actionTitle' => array(
            1 => 'Create leads',
            2 => 'Update leads'
        ),
        'leadPostView' => array(
            'form' => array(
                'leadPost' => array(
                    'attributes' => array(
                        'method' => 'POST',
                        'route' => array(
                            1 => 'accountsCreateLead',
                            2 => 'accountsUpdateLead'
                        ),
                        'id' => 'leadPost',
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
                            'title' => 'Lead\'s details',
                            'heading' => 'Please fill in the details of the lead.',
                            'help' => 'Please fill in all the mandatory details of this lead.',
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
                                            'placeholder' => 'Type the name eg \'John James\'',
                                            'help' => '<strong>Description: </strong>The name of the lead.<br/><strong>Do: </strong>Type the name of this lead.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'John James\'.',
                                            'validator' => array(
                                                'required' => 1
                                            )
                                        ),
                                        array(
                                            'name' => 'Organization',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'organization',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the organization eg \'Sapama\'',
                                            'help' => '<strong>Description: </strong>The organization of the lead.<br/><strong>Do: </strong>Type the organization of this lead.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'Sapama\'.',
                                            'validator' => array(
                                                'required' => 1
                                            )
                                        ),
                                        array(
                                            'name' => 'Email',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'email',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type work email eg \'me@mycompany.com\'',
                                            'help' => '<strong>Description: </strong>The email of this lead.<br/><strong>Do: </strong>Type the email of this lead.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'me@mycompany.com\'.',
                                            'validator' => array(
                                                'email' => 1,
                                                'required' => 1
                                            )
                                        ),
                                    )
                                ),
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Company phone',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'phone',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the company phone eg \'072200XXXXX\'',
                                            'help' => '<strong>Description: </strong>The company phone of the lead.<br/><strong>Do: </strong>Type the company phone of this lead.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'072200XXXXX\'.',
                                            'validator' => array(
                                                'required' => 1
                                            )
                                        ),
                                        array(
                                            'name' => 'Number',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'number',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the employee number eg \'10\'',
                                            'help' => '<strong>Description: </strong>The number of employees of the lead.<br/><strong>Do: </strong>Type the number of employees of this lead.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'10\'.',
                                            'validator' => array(
                                                'required' => 1
                                            )
                                        ),
                                        array(
                                            'name' => 'Country',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'country_id',
                                            'class' => 'seachableSelect',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select country',
                                            'help' => '<strong>Description: </strong>The country of this lead.<br/><strong>Do: </strong>Select the country of this lead.<br/><strong>Star: </strong> %s',
                                            'validator' => array(
                                                'required' => 1
                                            )
                                        ),
                                    )
                                ),
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Workflow',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'workflow',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select workflow',
                                            'help' => '<strong>Description: </strong>The workflow of this lead.<br/><strong>Do: </strong>Select the workflow of this lead.<br/><strong>Star: </strong> %s',
                                            'validator' => array(
                                                'required' => 1
                                            )
                                        ),
                                        array(
                                            'name' => 'Source',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'source',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select source',
                                            'help' => '<strong>Description: </strong>The source of this lead.<br/><strong>Do: </strong>Select the source of this lead.<br/><strong>Star: </strong> %s',
                                            'validator' => array(
                                                'required' => 1
                                            )
                                        ),
                                        array(
                                            'name' => 'Contact date',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'contact_date',
                                            'class' => 'datePicker',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select contact date',
                                            'help' => '<strong>Description: </strong>The contact date of this employee.<br/><strong>Do: </strong>Click to select the contact date of this employee.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'' . date('Y') . '-06-12\'.',
                                            'validator' => array(
                                            )
                                        ),
                                    )
                                ),
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Note',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'note',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type note eg \'Contact at a later date\'',
                                            'help' => '<strong>Description: </strong>The note of this lead.<br/><strong>Do: </strong>Type the note of this lead.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'Contact at a later date\'.',
                                            'validator' => array(
                                                'note' => 1
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
                                )
                            )
                        )
                    )
                )
            )
        )
    )
);
