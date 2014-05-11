<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | HTTP Status Language Lines
      |--------------------------------------------------------------------------
     */
    'systemCode' => array(
        700 => array(
            'httpStatusCode' => '200',
            'shortDescription' => 'OK',
            'developerMessage' => 'Succeed.',
            'userMessage' => ':action succeed.',
            'moreInfo' => ''
        ),
        804 => array(
            'httpStatusCode' => 304,
            'shortDescription' => 'Not Modified',
            'developerMessage' => ':action not modified.',
            'userMessage' => ':action has not be modified since the last time.',
            'moreInfo' => ''
        ),
        900 => array(
            'httpStatusCode' => '400',
            'shortDescription' => 'Bad Request',
            'developerMessage' => 'Input validation failed.',
            'userMessage' => 'Your request to :action could not be recognized. Please try again or contact Sapama Customer Care for help.',
            'moreInfo' => ''
        ),
        901 => array(
            'httpStatusCode' => 401,
            'shortDescription' => 'Unauthorized',
            'developerMessage' => 'HTTP code: :code. :action unauthorized.',
            'userMessage' => 'You don\'t have enough rights to :action. Contact Sapama Customer Care to be permitted to :action',
            'moreInfo' => ''
        ),
        903 => array(
            'httpStatusCode' => '403',
            'shortDescription' => 'Forbidden',
            'developerMessage' => 'Forbidden or Don\'t own',
            'userMessage' => ':action is not allowed. Please contact Sapama Customer Care.',
            'moreInfo' => ''
        ),
        904 => array(
            'httpStatusCode' => '404',
            'shortDescription' => 'Not found',
            'developerMessage' => ':type with :field \':value\' not found.',
            'userMessage' => ':action not found. Sorry for any inconvinience',
            'moreInfo' => ''
        ),
        919 => array(
            'httpStatusCode' => 404,
            'shortDescription' => 'Not found',
            'developerMessage' => 'HTTP code: :code. :action whose file name is :name not found on disk.',
            'userMessage' => ':action not found. Sapama is looking for it. Sorry for any inconvinience',
            'moreInfo' => ''
        ),
        921 => array(
            'httpStatusCode' => 400,
            'shortDescription' => 'Bad Request',
            'developerMessage' => 'HTTP code: :code. Input validation failed while trying to :action.',
            'userMessage' => ':action not found. Sapama is looking for it. Sorry for any inconvinience',
            'moreInfo' => ''
        ),
        1000 => array(
            'httpStatusCode' => 500,
            'shortDescription' => 'Internal Server Error',
            'developerMessage' => 'HTTP code: :code. :action internal server error.',
            'userMessage' => 'Sapama encountered a technical hiche :action.',
            'moreInfo' => ''
        ),
        1020 => array(
            'httpStatusCode' => 500,
            'shortDescription' => 'Model ID conflict',
            'developerMessage' => 'This :type already exists in out database.',
            'userMessage' => 'Sapama encountered a technical hiche :action.',
            'moreInfo' => ''
        ),
        1021 => array(
            'httpStatusCode' => 500,
            'shortDescription' => 'File name conflict',
            'developerMessage' => 'HTTP code: :code. :action failed since there already exists a file with :name as name.',
            'userMessage' => 'Sapama encountered a technical hiche :action.',
            'moreInfo' => ''
        ),
        1022 => array(
            'httpStatusCode' => 500,
            'shortDescription' => 'Database Insert Error',
            'developerMessage' => 'HTTP code: :code. :action failed due to database error.',
            'userMessage' => 'Sapama encountered a technical hiche :action.',
            'moreInfo' => ''
        )
    )
);
