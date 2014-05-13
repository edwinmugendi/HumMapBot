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
        900 => array(
            'httpStatusCode' => '400',
            'shortDescription' => 'Bad Request',
            'developerMessage' => 'Input validation failed.',
            'userMessage' => 'Your request to :action could not be recognized. Please try again or contact Sapama Customer Care for help.',
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
        1000 => array(
            'httpStatusCode' => '500',
            'shortDescription' => 'Internal Server Error',
            'developerMessage' => ':message',
            'userMessage' => 'Sapama encountered a technical hiche :action.',
            'moreInfo' => ''
        )
    )
);
