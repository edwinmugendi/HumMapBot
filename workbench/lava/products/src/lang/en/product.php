<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | Product Language Lines
      |--------------------------------------------------------------------------
     */
    'data' => array(
        'loyable' => array(
            '' => 'Select',
            1 => 'Yes',
            0 => 'No',
        ),
    ),
    'notification' => array(
        'free_price' => 'Free',
        'created' => 'Product created',
        'updated' => 'Product updated',
        'deleted' => 'Product deleted',
    ),
    'view' => array(
        'menu' => 'Products',
        'field' => array(
            'id' => '#',
            'name' => 'Name',
            'merchant_id' => 'Merchant id',
            'location_id' => 'Location id',
            'description' => 'Description',
            'price_1' => 'Price 1',
            'price_2' => 'Price 2',
            'loyable' => 'Loyable',
        ),
        'actions' => array(
            'delete' => array(
                'confirm' => 'Delete product?',
                'deleteMany' => 'Deleted :count products',
                'confirmMany' => 'Delete :count products?',
                'delete' => 'Delete',
                'cancel' => 'Cancel',
            ),
            'undelete' => array(
                'undoDelete' => 'Undo delete',
                'undeleting' => 'Un deleting...',
                'undeleted' => 'Un deleted :count products',
            ),
        ),
        'link' => array(
            'list' => 'Products list',
            'add' => 'Add product',
            'found' => '{0} :count products | {1} :count product | [2,Inf] :count products',
        )
    ),
    'productDetailedPage' => array(
        'title' => 'Product: :title #:id'
    ),
    'productListPage' => array(
        'title' => 'List of products'
    ),
    'productPostPage' => array(
        'actionTitle' => array(
            1 => 'Create products',
            2 => 'Update products'
        ),
        'productPostView' => array(
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
                'productPost' => array(
                    'attributes' => array(
                        'method' => 'POST',
                        'route' => array(
                            1 => 'productsCreateProduct',
                            2 => 'productsUpdateProduct'
                        ),
                        'id' => 'productPost',
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
                            'title' => 'Product\'s details',
                            'heading' => 'Please fill in the details of the product.',
                            'help' => 'Please fill in all the mandatory details of this product.',
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
                                            'help' => '<strong>Description: </strong>The merchant of this product<br/><strong>Do: </strong>Select the merchant of this product.<br/></strong>Star:</strong> %s',
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
                                            'placeholder' => 'Type the name eg \'Full Wash\'',
                                            'help' => '<strong>Description: </strong>The name of this product.<br/><strong>Do: </strong>Type the name of this product.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'Full Wash\'.',
                                            'validator' => array(
                                                'required' => 1
                                            )
                                        ),
                                        array(
                                            'name' => 'Location',
                                            'type' => 'select',
                                            'prepend' => 'user',
                                            'htmlName' => 'location_id',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Select location',
                                            'help' => '<strong>Description: </strong>The location of this product<br/><strong>Do: </strong>Select the location of this product.<br/></strong>Star:</strong> %s',
                                            'validator' => array(
                                                'required' => 1,
                                            )
                                        ),
                                    )
                                ),
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Description',
                                            'type' => 'textarea',
                                            'prepend' => 'user',
                                            'htmlName' => 'description',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the description eg \'Full body wash is\'',
                                            'help' => '<strong>Description: </strong>The description of this product.<br/><strong>Do: </strong>Type the description of this product.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'Full body wash is\'.',
                                            'validator' => array(
                                            )
                                        ),
                                    )
                                ),
                                array(
                                    'fields' => array(
                                        array(
                                            'name' => 'Car Price (Location currency will be used)',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'price_1',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the car price eg \'10\'',
                                            'help' => '<strong>Description: </strong>The car price of this product.<br/><strong>Do: </strong>Type the car price of this product.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'10\'.',
                                            'validator' => array(
                                                'number' => 1,
                                            )
                                        ),
                                        array(
                                            'name' => '4X4 Price (Location currency will be used)',
                                            'type' => 'text',
                                            'prepend' => 'user',
                                            'htmlName' => 'price_2',
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Type the 4X4 price eg \'10\'',
                                            'help' => '<strong>Description: </strong>The 4X4 price of this product.<br/><strong>Do: </strong>Type the 4X4 price of this product.<br/><strong>Star: </strong> %s <br/><strong>Examples: </strong>\'10\'.',
                                            'validator' => array(
                                                'number' => 1,
                                            )
                                        ),
                                        array(
                                            'name' => 'Loyable? (Do customers gain loyalty stamps when they buy this)',
                                            'type' => 'checkbox',
                                            'prepend' => 'user',
                                            'htmlName' => 'loyable',
                                            'checked' => 0,
                                            'displayed' => 1,
                                            'disabled' => 0,
                                            'placeholder' => 'Is this product loyable?',
                                            'help' => '<strong>Description: </strong>Do customers collect loyalty stamps when they buy this product<br/><strong>Do: </strong>Check if this product is loyable.<br/></strong>Star:</strong> %s',
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
                        array(
                            'id' => 'logo',
                            'title' => 'Images',
                            'heading' => 'Please upload the images of the product.',
                            'help' => 'Please upload the images of the product.',
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
