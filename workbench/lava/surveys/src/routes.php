<?php

//API.AI
\Route::get('apiai/{text}', array('as' => 'apiai', 'uses' => 'Lava\Surveys\ApiaiController@query'));

//Airtable test
\Route::get('airtable', array('as' => 'airtable', 'uses' => 'Lava\Surveys\AirtableController@findRecords'));

//Airtable test
\Route::get('airtable1', array('as' => 'airtable1', 'uses' => 'Lava\Surveys\AirtableController@findSingleRecord'));

\Route::group(array('before' => array('https')), function() {
    //Telegram webhook
    \Route::get('tg', array('as' => 'telegramGetWebhook', 'uses' => 'Lava\Surveys\TelegramController@webhookTelegram'));

    //Telegram webhook
    \Route::post('tg', array('as' => 'telegramPostWebhook', 'uses' => 'Lava\Surveys\TelegramController@webhookTelegram'));
});

\Route::group(array('before' => array('auth', 'https')), function() {

    /**
     * Update routes
     */
    //Detailed update
    \Route::get('surveys/detailed/update/{id}', array('as' => 'surveysDetailedUpdate', 'uses' => 'Lava\Surveys\UpdateController@getDetailed'));

    //List update
    \Route::get('surveys/list/update', array('as' => 'surveysListUpdate', 'uses' => 'Lava\Surveys\UpdateController@getList'));

    //Post update
    \Route::get('surveys/post/update/{id?}', array('as' => 'surveysPostUpdate', 'uses' => 'Lava\Surveys\UpdateController@getPost'));

    //Create a update
    \Route::post('surveys/create/update', array('as' => 'surveysCreateUpdate', 'before' => 'csrf', 'uses' => 'Lava\Surveys\UpdateController@postCreate'));

    //Update a update
    \Route::post('surveys/update/update', array('as' => 'surveysUpdateUpdate', 'before' => 'csrf', 'uses' => 'Lava\Surveys\UpdateController@postUpdate'));

    //Delete update
    \Route::post('surveys/delete/update', array('as' => 'surveysDeleteUpdate', 'uses' => 'Lava\Surveys\UpdateController@postDelete'));

    //Un-Delete update
    \Route::post('surveys/undelete/update', array('as' => 'surveysUndeleteUpdate', 'uses' => 'Lava\Surveys\UpdateController@postUndelete'));


    /**
     * Session routes
     */
    //Detailed session
    \Route::get('surveys/detailed/session/{id}', array('as' => 'surveysDetailedSession', 'uses' => 'Lava\Surveys\SessionController@getDetailed'));

    //List session
    \Route::get('surveys/list/session', array('as' => 'surveysListSession', 'uses' => 'Lava\Surveys\SessionController@getList'));

    //Post session
    \Route::get('surveys/post/session/{id?}', array('as' => 'surveysPostSession', 'uses' => 'Lava\Surveys\SessionController@getPost'));

    //Create a session
    \Route::post('surveys/create/session', array('as' => 'surveysCreateSession', 'before' => 'csrf', 'uses' => 'Lava\Surveys\SessionController@postCreate'));

    //Update a session
    \Route::post('surveys/update/session', array('as' => 'surveysUpdateSession', 'before' => 'csrf', 'uses' => 'Lava\Surveys\SessionController@postUpdate'));

    //Delete session
    \Route::post('surveys/delete/session', array('as' => 'surveysDeleteSession', 'uses' => 'Lava\Surveys\SessionController@postDelete'));

    //Un-Delete session
    \Route::post('surveys/undelete/session', array('as' => 'surveysUndeleteSession', 'uses' => 'Lava\Surveys\SessionController@postUndelete'));

    /**
     * Message routes
     */
    //Detailed message
    \Route::get('surveys/detailed/message/{id}', array('as' => 'surveysDetailedMessage', 'uses' => 'Lava\Surveys\MessageController@getDetailed'));

    //List message
    \Route::get('surveys/list/message', array('as' => 'surveysListMessage', 'uses' => 'Lava\Surveys\MessageController@getList'));

    //Post message
    \Route::get('surveys/post/message/{id?}', array('as' => 'surveysPostMessage', 'uses' => 'Lava\Surveys\MessageController@getPost'));

    //Create a message
    \Route::post('surveys/create/message', array('as' => 'surveysCreateMessage', 'before' => 'csrf', 'uses' => 'Lava\Surveys\MessageController@postCreate'));

    //Update a message
    \Route::post('surveys/update/message', array('as' => 'surveysUpdateMessage', 'before' => 'csrf', 'uses' => 'Lava\Surveys\MessageController@postUpdate'));

    //Delete message
    \Route::post('surveys/delete/message', array('as' => 'surveysDeleteMessage', 'uses' => 'Lava\Surveys\MessageController@postDelete'));

    //Un-Delete message
    \Route::post('surveys/undelete/message', array('as' => 'surveysUndeleteMessage', 'uses' => 'Lava\Surveys\MessageController@postUndelete'));
});


