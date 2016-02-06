<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | HTTP Status Language Lines
      |--------------------------------------------------------------------------
     */
    'system_code' => array(
        700 => array(
            'http_status_code' => '200',
            'short_description' => 'OK',
            'developer_message' => 'Succeed.',
            'user_message' => ':action succeed.',
            'more_info' => ''
        ),
        900 => array(
            'http_status_code' => '400',
            'short_description' => 'Bad Request',
            'developer_message' => 'Input validation failed.',
            'user_message' => 'Your request to :action could not be recognized. Please try again or contact Sapama Customer Care for help.',
            'more_info' => ''
        ),
        903 => array(
            'http_status_code' => '403',
            'short_description' => 'Forbidden',
            'developer_message' => 'Forbidden or Don\'t own',
            'user_message' => ':action is not allowed. Please contact Sapama Customer Care.',
            'more_info' => ''
        ),
        904 => array(
            'http_status_code' => '404',
            'short_description' => 'Not found',
            'developer_message' => ':type not found.',
            'user_message' => ':action not found. Sorry for any inconvinience',
            'more_info' => ''
        ),
        '1000' => array(
            'http_status_code' => '500',
            'short_description' => 'Internal Server Error',
            'developer_message' => 'Internal Server Error',
            'user_message' => 'Sapama encountered a technical hiche :action.',
            'more_info' => ''
        )
    )
);
