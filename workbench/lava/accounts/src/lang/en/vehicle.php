<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | Vehicles Language Lines
      |--------------------------------------------------------------------------
     */
    'notification' => array(
        'check_registry' => 'VRM is in use',
        'user_owns' => 'User doesn\'t own this vehicle with vrm :vrm',
        'created' => 'Vehicle added',
        'updated' => 'Vehicle updated',
        'deleted' => 'Vehicle deleted',
        'list' => 'Vehicles list',
    ),
    'data' => array(
        'type' => array(
            '' => 'Select',
            1 => 'Car',
            2 => '4X4',
        ),
    ),
    'view' => array(
        'menu' => 'Vehicles',
        'field' => array(
            'id' => '#',
            'user_id' => 'User',
            'vrm' => 'Vrm',
            'purpose' => 'Purpose',
            'type' => 'Type',
            'is_default' => 'Is default?',
            'make' => 'Make',
            'model' => 'Model',
            'six_month_rate' => '6 month_rate',
            'twelve_month_rate' => '12 month_rate',
            'date_of_first_registration' => 'Registration date',
            'year_of_manufacture' => 'Year of_manufacture',
            'cylinder capacity' => 'Cylinder capacity',
            'co2_emisssions' => 'Co2 emisssions',
            'fuel_type' => 'Fuel type',
            'tax_status' => 'Tax status',
            'colour' => 'Colour',
            'type_approval' => 'Type approval',
            'wheel_plan' => 'Wheel plan',
            'revenue_weight' => 'Revenue weight',
            'tax_details' => 'Tax details',
            'mot_details' => 'Mot details',
            'taxed' => 'Taxed',
            'mot' => 'MOT',
            'api_status' => 'API status',
            'api_message' => 'API message',
        ),
        'actions' => array(
            'delete' => array(
                'confirm' => 'Delete vehicle?',
                'deleteMany' => 'Deleted :count vehicles',
                'confirmMany' => 'Delete :count vehicles?',
                'delete' => 'Delete',
                'cancel' => 'Cancel',
            ),
            'undelete' => array(
                'undoDelete' => 'Undo delete',
                'undeleting' => 'Un deleting...',
                'undeleted' => 'Un deleted :count vehicles',
            ),
        ),
        'link' => array(
            'list' => 'Vehicles list',
            'add' => 'Add vehicle',
            'found' => '{0} :count vehicles | {1} :count vehicle | [2,Inf] :count vehicles',
        )
    ),
    'vehicleDetailedPage' => array(
        'title' => 'Vehicle: :title #:id'
    ),
    'vehicleListPage' => array(
        'title' => 'List of vehicles'
    ),
    'vehiclePostPage' => array(
        'actionTitle' => array(
            1 => 'Create vehicles',
            2 => 'Update vehicles'
        ),
        'vehiclePostView' => array(
            'form' => array(
                'vehiclePost' => array(
                    'attributes' => array(
                        'method' => 'POST',
                        'route' => array(
                            1 => 'productsCreateVehicle',
                            2 => 'productsUpdateVehicle'
                        ),
                        'id' => 'vehiclePost',
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
                            'title' => 'Vehicle\'s details',
                            'heading' => 'Please fill in the details of the vehicle.',
                            'help' => 'Please fill in all the mandatory details of this vehicle.',
                            'stared' => 1,
                            'rows' => array(
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Merchant',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'merchant_id',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select merchant',
                                            'help' => '<strong>Description: </strong>The merchant of this vehicle<br/><strong>Do: </strong>Select the merchant of this vehicle.<br/></strong>Star:</strong> %s',
                                            'validator' => array(
                                                'required' => 1,
                                            )
                                        ),
                                        array(
                                            'name' => 'Code',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'code',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the code eg \'PROMO\'',
                                            'help' => '<strong>Description: </strong>The code of this vehicle.<br/><strong>Do: </strong>Type the code of this vehicle.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'PROMO\'.',
                                            'validator' => array(
                                                'required' => 1
                                            )
                                        ),
                                        array(
                                            'name' => 'Location (Vehicle will apply only to this location)',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'location_id',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select location',
                                            'help' => '<strong>Description: </strong>The location of this vehicle<br/><strong>Do: </strong>Select the location of this vehicle.<br/></strong>Star:</strong> %s',
                                            'validator' => array(
                                            )
                                        ),
                                    )
                                ),
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Description',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'description',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the description eg \'Full body wash is\'',
                                            'help' => '<strong>Description: </strong>The description of this vehicle.<br/><strong>Do: </strong>Type the description of this vehicle.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'Full body wash is\'.',
                                            'validator' => array(
                                                'required' => 1,
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
                                            'help' => '<strong>Description: </strong>The type of this vehicle<br/><strong>Do: </strong>Select the type of this vehicle.<br/></strong>Star:</strong> %s',
                                            'validator' => array(
                                                'required' => 1,
                                            )
                                        ),
                                        array(
                                            'name' => 'Value',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'value',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the value eg \'10\'',
                                            'help' => '<strong>Description: </strong>The value of this vehicle.<br/><strong>Do: </strong>Type the value of this vehicle.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'10\'.',
                                            'validator' => array(
                                                'number' => 1,
                                                'required' => 1,
                                            )
                                        ),
                                        array(
                                            'name' => 'Expiry date',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'expiry_date',
                                            'class' => 'datePicker',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select expiry date',
                                            'help' => '<strong>Description: </strong>The expiry date of this vehicle.<br/><strong>Do: </strong>Click to select the expiry date of this vehicle.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'1970-06-12\'.',
                                            'validator' => array(
                                                'required' => 1,
                                            )
                                        ),
                                        array(
                                            'name' => 'Applicable only to customers who have not transacted yet or simply new customers?',
                                            'type' => 'checkbox',
                                            'prepend' => 'user',
                                            'htmlName' => 'new_customer',
                                            'checked' => 0,
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Applicable only to customers who have not transacted yet or simply new customers?',
                                            'help' => '<strong>Description: </strong>Is this vehicle only applicable to customers who have not transacted?<br/><strong>Do: </strong>Check if this vehicle is only applicable to customer who have not transacted.<br/></strong>Star:</strong> %s',
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
