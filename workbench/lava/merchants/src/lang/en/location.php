<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | Location Language Lines
      |--------------------------------------------------------------------------
     */
    'notification' => array(
        'created' => 'Location created',
        'updated' => 'Location updated',
        'deleted' => 'Location deleted',
        'list' => 'Location list',
        'feel' => array(
            1 => 'Location :field :value favoured',
            2 => 'Location :field :value rated',
            3 => 'Location :field :value reviewed'
        )
    ),
    'data' => array(
        'workflow' => array(
            '' => 'Select',
            1 => 'Active',
            2 => 'Inactive',
            3 => 'Suspended',
        ),
        'type' => array(
            '' => 'Select',
            1 => 'Favourites',
            2 => 'Ratings',
            3 => 'Reviews'
        ),
        'loyalty_stamps' => array(
            '' => 'Select',
            0 => 'None (I don\'t run loyalty campaign)',
            1 => 1,
            2 => 2,
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
            6 => 6,
            7 => 7,
            8 => 8,
            9 => 9,
            10 => 10,
        ),
        'date_format' => array(
            '' => 'Select',
            'dd/mm/yyyy' => 'dd/mm/yyyy',
            'mm/dd/yyyy' => 'mm/dd/yyyy',
            'yyyy/mm/dd' => 'yyyy/mm/dd'
        ),
        'yes_no' => array(
            '' => 'Select',
            1 => 'Yes',
            0 => 'No',
        ),
        'hours' => array(
            '' => 'Select',
            '00:00' => '00:00',
            '00:15' => '00:15',
            '00:30' => '00:30',
            '00:45' => '00:45',
            '01:00' => '01:00',
            '01:15' => '01:15',
            '01:30' => '01:30',
            '01:45' => '01:45',
            '02:00' => '02:00',
            '02:15' => '02:15',
            '02:30' => '02:30',
            '02:45' => '02:45',
            '03:00' => '03:00',
            '03:15' => '03:15',
            '03:30' => '03:30',
            '03:45' => '03:45',
            '04:00' => '04:00',
            '04:15' => '04:15',
            '04:30' => '04:30',
            '04:45' => '04:45',
            '05:00' => '05:00',
            '05:15' => '05:15',
            '05:30' => '05:30',
            '05:45' => '05:45',
            '06:00' => '06:00',
            '06:15' => '06:15',
            '06:30' => '06:30',
            '06:45' => '06:45',
            '07:00' => '07:00',
            '07:15' => '07:15',
            '07:30' => '07:30',
            '07:45' => '07:45',
            '08:00' => '08:00',
            '08:15' => '08:15',
            '08:30' => '08:30',
            '08:45' => '08:45',
            '09:00' => '09:00',
            '09:15' => '09:15',
            '09:30' => '09:30',
            '09:45' => '09:45',
            '10:00' => '10:00',
            '10:15' => '10:15',
            '10:30' => '10:30',
            '10:45' => '10:45',
            '11:00' => '11:00',
            '11:15' => '11:15',
            '11:30' => '11:30',
            '11:45' => '11:45',
            '12:00' => '12:00',
            '12:15' => '12:15',
            '12:30' => '12:30',
            '12:45' => '12:45',
            '13:00' => '13:00',
            '13:15' => '13:15',
            '13:30' => '13:30',
            '13:45' => '13:45',
            '14:00' => '14:00',
            '14:15' => '14:15',
            '14:30' => '14:30',
            '14:45' => '14:45',
            '15:00' => '15:00',
            '15:15' => '15:15',
            '15:30' => '15:30',
            '15:45' => '15:45',
            '16:00' => '16:00',
            '16:15' => '16:15',
            '16:30' => '16:30',
            '16:45' => '16:45',
            '17:00' => '17:00',
            '17:15' => '17:15',
            '17:30' => '17:30',
            '17:45' => '17:45',
            '18:00' => '18:00',
            '18:15' => '18:15',
            '18:30' => '18:30',
            '18:45' => '18:45',
            '19:00' => '19:00',
            '19:15' => '19:15',
            '19:30' => '19:30',
            '19:45' => '19:45',
            '20:00' => '20:00',
            '20:15' => '20:15',
            '20:30' => '20:30',
            '20:45' => '20:45',
            '21:00' => '21:00',
            '21:15' => '21:15',
            '21:30' => '21:30',
            '21:45' => '21:45',
            '22:00' => '22:00',
            '22:15' => '22:15',
            '22:30' => '22:30',
            '22:45' => '22:45',
            '23:00' => '23:00',
            '23:15' => '23:15',
            '23:30' => '23:30',
            '23:45' => '23:45',
        ),
    ),
    'view' => array(
        'menu' => 'Locations',
        'field' => array(
            'id' => '#',
            'merchant_id' => 'Merchant',
            'workflow' => 'Status',
            'name' => 'Name',
            'about' => 'About',
            'phone' => 'Phone',
            'email' => 'Email',
            'postal_code' => 'Postal code',
            'country_id' => 'Country',
            'province' => 'Province',
            'city' => 'City',
            'street' => 'Street',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'timezone_id' => 'Timezone',
            'currency_id' => 'Currency',
            'date_format' => 'Date format',
            'loyalty_stamps' => 'Loyalty stamps',
            'surcharge' => 'Surcharge',
            'website' => 'Website',
            'facebook' => 'Facebook',
            'twitter' => 'Twitter',
            'pay_location' => 'Pay location',
            
            'is_monday_open' => 'Is Monday open?',
            'monday_opens_at' => 'Monday opens at',
            'monday_closes_at' => 'Monday closes at',
            'is_tuesday_open' => 'Is Tuesday open?',
            'tuesday_opens_at' => 'Tuesday opens at',
            'tuesday_closes_at' => 'Tuesday closes at',
            'is_wednesday_open' => 'Is Wednesday open?',
            'wednesday_opens_at' => 'Wednesday opens at',
            'wednesday_closes_at' => 'Wednesday closes at',
            'is_thursday_open' => 'Is Thursday open?',
            'thursday_opens_at' => 'Thursday opens at',
            'thursday_closes_at' => 'Thursday closes at',
            'is_friday_open' => 'Is Friday open?',
            'friday_opens_at' => 'Friday opens at',
            'friday_closes_at' => 'Friday closes at',
            'is_saturday_open' => 'Is Saturday open?',
            'saturday_opens_at' => 'Saturday opens at',
            'saturday_closes_at' => 'Saturday closes at',
            'is_sunday_open' => 'Is Sunday open?',
            'sunday_opens_at' => 'Sunday opens at',
            'sunday_closes_at' => 'Sunday closes at',
            'is_holiday_open' => 'Is Holiday open?',
            'holiday_opens_at' => 'Holiday opens at',
            'holiday_closes_at' => 'Holiday closes at',
        ),
        'actions' => array(
            'delete' => array(
                'confirm' => 'Delete location?',
                'deleteMany' => 'Deleted :count locations',
                'confirmMany' => 'Delete :count locations?',
                'delete' => 'Delete',
                'cancel' => 'Cancel',
            ),
            'undelete' => array(
                'undoDelete' => 'Undo delete',
                'undeleting' => 'Un deleting...',
                'undeleted' => 'Un deleted :count locations',
            ),
        ),
        'link' => array(
            'list' => 'Locations list',
            'add' => 'Add location',
            'found' => '{0} :count locations | {1} :count location | [2,Inf] :count locations',
        )
    ),
    'locationDetailedPage' => array(
        'title' => 'Location: :title #:id'
    ),
    'locationListPage' => array(
        'title' => 'List of locations'
    ),
    'locationPostPage' => array(
        'actionTitle' => array(
            1 => 'Create locations',
            2 => 'Update locations'
        ),
        'locationPostView' => array(
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
                'locationPost' => array(
                    'attributes' => array(
                        'method' => 'POST',
                        'route' => array(
                            1 => 'merchantsCreateLocation',
                            2 => 'merchantsUpdateLocation'
                        ),
                        'id' => 'locationPost',
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
                            'title' => 'Location\'s details',
                            'heading' => 'Please fill in the details of the location.',
                            'help' => 'Please fill in all the mandatory details of this location.',
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
                                            'help' => '<strong>Description: </strong>The merchant of this location<br/><strong>Do: </strong>Select the merchant of this location.<br/></strong>Star:</strong> %s',
                                            'validator' => array(
                                                'required' => 1,
                                            )
                                        ),
                                        array(
                                            'name' => 'Name',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'name',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the name eg \'XYZ Car Wash\'',
                                            'help' => '<strong>Description: </strong>The name of this location.<br/><strong>Do: </strong>Type the name of this location.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'XYZ Car Wash\'.',
                                            'validator' => array(
                                                'required' => 1
                                            )
                                        ),
                                        array(
                                            'name' => '# of loyalty stamps for free wash',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'loyalty_stamps',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select loyalty stamps',
                                            'help' => '<strong>Description: </strong>The loyalty stamps of this merchant<br/><strong>Do: </strong>Select the loyalty stamps of this merchant.<br/></strong>Star:</strong> %s',
                                            'validator' => array(
                                                'required' => 1,
                                                'integer' => 1,
                                            )
                                        ),
                                        array(
                                            'name' => 'Surcharge for each transaction, leave blank if none',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'surcharge',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the surcharge eg \'20\'',
                                            'help' => '<strong>Description: </strong>The surcharge of this location.<br/><strong>Do: </strong>Type the surcharge of this location.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'20\'.',
                                            'validator' => array(
                                                'numeric' => 1,
                                            )
                                        ),
                                    )
                                ),
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Notification Phone (comma separated for multiple), include country code without +',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'phone',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the phone, comma separated for multiple eg \'4477447744,4477447743\'',
                                            'help' => '<strong>Description: </strong>The phone of this location.<br/><strong>Do: </strong>Type the phone of this location.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'4477447744,4477447743\'.',
                                            'validator' => array(
                                            )
                                        ),
                                        array(
                                            'name' => 'Email (comma separated for multiple)',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'email',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the email, comma separated for multiple eg \'john.doe@email.com,john.doe1@email.com\'',
                                            'help' => '<strong>Description: </strong>The email of this location.<br/><strong>Do: </strong>Type the email of this location.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'john.doe@email.com,john.doe1@email.com\'.',
                                            'validator' => array(
                                            )
                                        ),
                                    )
                                ),
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'About',
                                            'type' => 'textarea',
                                            'prepend' => 'user',
                                            'htmlName' => 'about',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the about eg \'Car Wash XYZ is\'',
                                            'help' => '<strong>Description: </strong>The about of this location.<br/><strong>Do: </strong>Type the about of this location.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'Car Wash XYZ is\'.',
                                            'validator' => array(
                                            )
                                        ),
                                    )
                                ),
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Website (with http or https)',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'website',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the website eg \'www.carwash.com\'',
                                            'help' => '<strong>Description: </strong>The website of this location.<br/><strong>Do: </strong>Type the website of this location.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'www.carwash.com\'.',
                                            'validator' => array(
                                                'url' => 1,
                                            )
                                        ),
                                        array(
                                            'name' => 'Facebook page link (with http or https)',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'facebook',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the facebook page link eg \'www.carwash.com\'',
                                            'help' => '<strong>Description: </strong>The facebook page link of this location.<br/><strong>Do: </strong>Type the facebook page link of this location.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'www.carwash.com\'.',
                                            'validator' => array(
                                                'url' => 1,
                                            )
                                        ),
                                        array(
                                            'name' => 'Twitter link (with http or https)',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'twitter',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the twitter link  eg \'www.carwash.com\'',
                                            'help' => '<strong>Description: </strong>The twitter of this location.<br/><strong>Do: </strong>Type the twitter of this location.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'www.carwash.com\'.',
                                            'validator' => array(
                                                'url' => 1,
                                            )
                                        ),
                                    )
                                ),
                            )
                        ),
                        array(
                            'id' => 'settings',
                            'title' => 'Currency and time',
                            'heading' => 'Please set the currency and time settings of this location.',
                            'help' => 'Please set the currency and time settings of this location.',
                            'stared' => 0,
                            'rows' => array(
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Time zone',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'timezone_id',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select time zone',
                                            'help' => '<strong>Description: </strong>The time zone of this location<br/><strong>Do: </strong>Select the time zone of this location.<br/></strong>Star:</strong> %s',
                                            'validator' => array(
                                                'required' => 1,
                                            )
                                        ),
                                        array(
                                            'name' => 'Currency',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'currency_id',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select currency',
                                            'help' => '<strong>Description: </strong>The currency of this location<br/><strong>Do: </strong>Select the currency of this location.<br/></strong>Star:</strong> %s',
                                            'validator' => array(
                                                'required' => 1,
                                            )
                                        ),
                                        array(
                                            'name' => 'Date format',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'date_format',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select date format',
                                            'help' => '<strong>Description: </strong>The date format of this location<br/><strong>Do: </strong>Select the date format of this location.<br/></strong>Star:</strong> %s',
                                            'validator' => array(
                                                'required' => 1,
                                            )
                                        ),
                                    )
                                ),
                            )
                        ),
                        array(
                            'id' => 'address',
                            'title' => 'Address information',
                            'heading' => 'Please fill in the address of the location.',
                            'help' => 'Please fill in all the mandatory address of this location.',
                            'stared' => 1,
                            'rows' => array(
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Street',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'street',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the street eg \'Standard Street\'',
                                            'help' => '<strong>Description: </strong>The street of this location.<br/><strong>Do: </strong>Type the street of this location.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'Standard Street\'.',
                                            'validator' => array(
                                            )
                                        ),
                                        array(
                                            'name' => 'City',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'city',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the city eg \'New York\'',
                                            'help' => '<strong>Description: </strong>The city of this location.<br/><strong>Do: </strong>Type the city of this location.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'New York\'.',
                                            'validator' => array(
                                            )
                                        ),
                                        array(
                                            'name' => 'Province / State',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'province',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the province eg \'Washington DC\'',
                                            'help' => '<strong>Description: </strong>The province of this location.<br/><strong>Do: </strong>Type the province of this location.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'Washington DC\'.',
                                            'validator' => array(
                                            )
                                        ),
                                    )
                                ),
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Postal code',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'postal_code',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the postal code eg \'200200\'',
                                            'help' => '<strong>Description: </strong>The postal code of this location.<br/><strong>Do: </strong>Type the postal code of this location.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'200200\'.',
                                            'validator' => array(
                                            )
                                        ),
                                        array(
                                            'name' => 'Country',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'country_id',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select country',
                                            'help' => '<strong>Description: </strong>The country of this location.<br/><strong>Do: </strong>Select the country of this location.<br/><strong>Star: </strong> %s',
                                            'validator' => array(
                                            )
                                        ),
                                    ),
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
                            'id' => 'hours',
                            'title' => 'Opening hours',
                            'heading' => 'Please fill in the opening hours of the location.',
                            'help' => 'Please fill in all the mandatory opening hours of this location.',
                            'stared' => 1,
                            'rows' => array(
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Is Monday opens?',
                                            'type' => 'checkbox',
                                            'prepend' => 'user',
                                            'htmlName' => 'is_monday_open',
                                            'checked' => 0,
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Check if location is open on Monday',
                                            'help' => '<strong>Description: </strong>Do you open on Monday?<br/><strong>Do: </strong>Check if location is open on Monday<br/><strong>Star: </strong> %s',
                                            'validator' => array(
                                            )
                                        ),
                                        array(
                                            'name' => 'Monday opens at',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'monday_opens_at',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select Monday opening hours',
                                            'help' => '<strong>Description: </strong>Monday opening hours of this location<br/><strong>Do: </strong>Select Monday opening hours of this location<br/><strong>Star: </strong> %s',
                                            'validator' => array(
                                            )
                                        ),
                                        array(
                                            'name' => 'Monday closes at',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'monday_closes_at',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select Monday closing hours',
                                            'help' => '<strong>Description: </strong>Monday closing hours of this location<br/><strong>Do: </strong>Select Monday closing hours of this location<br/><strong>Star: </strong> %s',
                                            'validator' => array(
                                            )
                                        ),
                                    )
                                ),
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Is Tuesday opens?',
                                            'type' => 'checkbox',
                                            'prepend' => 'user',
                                            'htmlName' => 'is_tuesday_open',
                                            'checked' => 0,
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Check if location is open on Tuesday',
                                            'help' => '<strong>Description: </strong>Do you open on Tuesday?<br/><strong>Do: </strong>Check if location is open on Tuesday<br/><strong>Star: </strong> %s',
                                            'validator' => array(
                                            )
                                        ),
                                        array(
                                            'name' => 'Tuesday opens at',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'tuesday_opens_at',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select Tuesday opening hours',
                                            'help' => '<strong>Description: </strong>Tuesday opening hours of this location<br/><strong>Do: </strong>Select Tuesday opening hours of this location<br/><strong>Star: </strong> %s',
                                            'validator' => array(
                                            )
                                        ),
                                        array(
                                            'name' => 'Tuesday closes at',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'tuesday_closes_at',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select Tuesday closing hours',
                                            'help' => '<strong>Description: </strong>Tuesday closing hours of this location<br/><strong>Do: </strong>Select Tuesday closing hours of this location<br/><strong>Star: </strong> %s',
                                            'validator' => array(
                                            )
                                        ),
                                    )
                                ),
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Is Wednesday opens?',
                                            'type' => 'checkbox',
                                            'prepend' => 'user',
                                            'htmlName' => 'is_wednesday_open',
                                            'checked' => 0,
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Check if location is open on Wednesday',
                                            'help' => '<strong>Description: </strong>Do you open on Wednesday?<br/><strong>Do: </strong>Check if location is open on Wednesday<br/><strong>Star: </strong> %s',
                                            'validator' => array(
                                            )
                                        ),
                                        array(
                                            'name' => 'Wednesday opens at',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'wednesday_opens_at',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select Wednesday opening hours',
                                            'help' => '<strong>Description: </strong>Wednesday opening hours of this location<br/><strong>Do: </strong>Select Wednesday opening hours of this location<br/><strong>Star: </strong> %s',
                                            'validator' => array(
                                            )
                                        ),
                                        array(
                                            'name' => 'Wednesday closes at',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'wednesday_closes_at',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select Wednesday closing hours',
                                            'help' => '<strong>Description: </strong>Wednesday closing hours of this location<br/><strong>Do: </strong>Select Wednesday closing hours of this location<br/><strong>Star: </strong> %s',
                                            'validator' => array(
                                            )
                                        ),
                                    )
                                ),
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Is Thursday opens?',
                                            'type' => 'checkbox',
                                            'prepend' => 'user',
                                            'htmlName' => 'is_thursday_open',
                                            'checked' => 0,
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Check if location is open on Thursday',
                                            'help' => '<strong>Description: </strong>Do you open on Thursday?<br/><strong>Do: </strong>Check if location is open on Thursday<br/><strong>Star: </strong> %s',
                                            'validator' => array(
                                            )
                                        ),
                                        array(
                                            'name' => 'Thursday opens at',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'thursday_opens_at',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select Thursday opening hours',
                                            'help' => '<strong>Description: </strong>Thursday opening hours of this location<br/><strong>Do: </strong>Select Thursday opening hours of this location<br/><strong>Star: </strong> %s',
                                            'validator' => array(
                                            )
                                        ),
                                        array(
                                            'name' => 'Thursday closes at',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'thursday_closes_at',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select Thursday closing hours',
                                            'help' => '<strong>Description: </strong>Thursday closing hours of this location<br/><strong>Do: </strong>Select Thursday closing hours of this location<br/><strong>Star: </strong> %s',
                                            'validator' => array(
                                            )
                                        ),
                                    )
                                ),
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Is Friday opens?',
                                            'type' => 'checkbox',
                                            'prepend' => 'user',
                                            'htmlName' => 'is_friday_open',
                                            'checked' => 0,
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Check if location is open on Friday',
                                            'help' => '<strong>Description: </strong>Do you open on Friday?<br/><strong>Do: </strong>Check if location is open on Friday<br/><strong>Star: </strong> %s',
                                            'validator' => array(
                                            )
                                        ),
                                        array(
                                            'name' => 'Friday opens at',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'friday_opens_at',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select Friday opening hours',
                                            'help' => '<strong>Description: </strong>Friday opening hours of this location<br/><strong>Do: </strong>Select Friday opening hours of this location<br/><strong>Star: </strong> %s',
                                            'validator' => array(
                                            )
                                        ),
                                        array(
                                            'name' => 'Friday closes at',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'friday_closes_at',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select Friday closing hours',
                                            'help' => '<strong>Description: </strong>Friday closing hours of this location<br/><strong>Do: </strong>Select Friday closing hours of this location<br/><strong>Star: </strong> %s',
                                            'validator' => array(
                                            )
                                        ),
                                    )
                                ),
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Is Saturday opens?',
                                            'type' => 'checkbox',
                                            'prepend' => 'user',
                                            'htmlName' => 'is_saturday_open',
                                            'checked' => 0,
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Check if location is open on Saturday',
                                            'help' => '<strong>Description: </strong>Do you open on Saturday?<br/><strong>Do: </strong>Check if location is open on Saturday<br/><strong>Star: </strong> %s',
                                            'validator' => array(
                                            )
                                        ),
                                        array(
                                            'name' => 'Saturday opens at',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'saturday_opens_at',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select Saturday opening hours',
                                            'help' => '<strong>Description: </strong>Saturday opening hours of this location<br/><strong>Do: </strong>Select Saturday opening hours of this location<br/><strong>Star: </strong> %s',
                                            'validator' => array(
                                            )
                                        ),
                                        array(
                                            'name' => 'Saturday closes at',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'saturday_closes_at',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select Saturday closing hours',
                                            'help' => '<strong>Description: </strong>Saturday closing hours of this location<br/><strong>Do: </strong>Select Saturday closing hours of this location<br/><strong>Star: </strong> %s',
                                            'validator' => array(
                                            )
                                        ),
                                    )
                                ),
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Is Sunday opens?',
                                            'type' => 'checkbox',
                                            'prepend' => 'user',
                                            'htmlName' => 'is_sunday_open',
                                            'checked' => 0,
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Check if location is open on Sunday',
                                            'help' => '<strong>Description: </strong>Do you open on Sunday?<br/><strong>Do: </strong>Check if location is open on Sunday<br/><strong>Star: </strong> %s',
                                            'validator' => array(
                                            )
                                        ),
                                        array(
                                            'name' => 'Sunday opens at',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'sunday_opens_at',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select Sunday opening hours',
                                            'help' => '<strong>Description: </strong>Sunday opening hours of this location<br/><strong>Do: </strong>Select Sunday opening hours of this location<br/><strong>Star: </strong> %s',
                                            'validator' => array(
                                            )
                                        ),
                                        array(
                                            'name' => 'Sunday closes at',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'sunday_closes_at',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select Sunday closing hours',
                                            'help' => '<strong>Description: </strong>Sunday closing hours of this location<br/><strong>Do: </strong>Select Sunday closing hours of this location<br/><strong>Star: </strong> %s',
                                            'validator' => array(
                                            )
                                        ),
                                    )
                                ),
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Is Holiday opens?',
                                            'type' => 'checkbox',
                                            'prepend' => 'user',
                                            'htmlName' => 'is_holiday_open',
                                            'checked' => 0,
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Check if location is open on Holidays',
                                            'help' => '<strong>Description: </strong>Do you open on Holiday?<br/><strong>Do: </strong>Check if location is open on Holidays<br/><strong>Star: </strong> %s',
                                            'validator' => array(
                                            )
                                        ),
                                        array(
                                            'name' => 'Holiday opens at',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'holiday_opens_at',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select Holiday opening hours',
                                            'help' => '<strong>Description: </strong>Holiday opening hours of this location<br/><strong>Do: </strong>Select Holiday opening hours of this location<br/><strong>Star: </strong> %s',
                                            'validator' => array(
                                            )
                                        ),
                                        array(
                                            'name' => 'Holiday closes at',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'holiday_closes_at',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select Holiday closing hours',
                                            'help' => '<strong>Description: </strong>Holiday closing hours of this location<br/><strong>Do: </strong>Select Holiday closing hours of this location<br/><strong>Star: </strong> %s',
                                            'validator' => array(
                                            )
                                        ),
                                    )
                                ),
                            )
                        ),
                        array(
                            'id' => 'logo',
                            'title' => 'Images',
                            'heading' => 'Please upload the images of the location.',
                            'help' => 'Please upload the images of the location.',
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
                        array(
                            'id' => 'map',
                            'title' => 'Map location',
                            'heading' => 'Pick map location of the location.',
                            'help' => 'Pick map location of the location.',
                            'stared' => 0,
                            'rows' => array(
                                array(
                                    'fields' => array(
                                        array(
                                            'dataSource' => 'mapView'
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
