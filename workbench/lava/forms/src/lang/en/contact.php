<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | Contact Language Lines
      |--------------------------------------------------------------------------
     */
    'data' => array(
        'gender' => array(
            'male' => 'Male',
            'female' => 'Female',
        ),
        'yes_no' => array(
            'y' => 'Yes',
            'n' => 'No',
        ),
        'workflow' => array(
            'y' => 'Yes',
            'n' => 'No',
        )
    ),
    'notification' => array(
        'created' => 'Contact created',
        'updated' => 'Contact updated',
        'deleted' => 'Contact deleted',
    ),
    'view' => array(
        'menu' => 'Contacts',
        'field' => array(
            'workflow' => 'status',
            'id' => '#',
            'session_id' => 'Session id',
            'full_name' => 'Full name',
            'age' => 'Age',
            'phone' => 'Phone',
            'gender' => 'Gender',
            'height' => 'Height',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'food_chicken' => 'Chicken',
            'food_fish' => 'Fish',
            'names' => 'Names',
            'channel_chat_id' => 'Chat id',
            'channel' => 'Channel'
        ),
        'actions' => array(
            'delete' => array(
                'confirm' => 'Delete contact?',
                'deleteMany' => 'Deleted :count contacts',
                'confirmMany' => 'Delete :count contacts?',
                'delete' => 'Delete',
                'cancel' => 'Cancel',
            ),
            'undelete' => array(
                'undoDelete' => 'Undo delete',
                'undeleting' => 'Un deleting...',
                'undeleted' => 'Un deleted :count contacts',
            ),
        ),
        'link' => array(
            'list' => 'Contacts list',
            'add' => 'Add contact',
            'found' => '{0} :count contacts | {1} :count contact | [2,Inf] :count contacts',
        )
    ),
    'contactDetailedPage' => array(
        'title' => 'Contact: :title #:id'
    ),
    'contactListPage' => array(
        'title' => 'List of contacts'
    ),
    'contactPostPage' => array(
        'actionTitle' => array(
            1 => 'Create contacts',
            2 => 'Update contacts'
        ),
        'contactPostView' => array(
            'form' => array(
                'contactPost' => array(
                    'attributes' => array(
                        'method' => 'POST',
                        'route' => array(
                            1 => 'surveysCreateContact',
                            2 => 'surveysUpdateContact'
                        ),
                        'id' => 'contactPost',
                        'class' => 'commonContainer'
                    ),
                    'stars' => array(
                        'required' => array(
                            'text' => 'Required',
                            'fieldText' => 'This field is required',
                            'description' => 'Required fields are marked with a red star'
                        ),
                        'contactal' => array(
                            'text' => 'Contactal',
                            'fieldText' => 'This field is contactal but important',
                            'description' => 'Contactal fields marked with blue star'
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
                            'title' => 'Contact\'s details',
                            'heading' => 'Please fill in the details of the contact.',
                            'help' => 'Please fill in all the mandatory details of this contact.',
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
                                            'help' => '<strong>Description: </strong>The title of this contact.<br/><strong>Do: </strong>Type the title of this contact.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'Male\'.',
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
                                            'help' => '<strong>Description: </strong>The value of this contact.<br/><strong>Do: </strong>Type the value of this contact.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'m\'.',
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
