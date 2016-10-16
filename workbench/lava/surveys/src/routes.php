<?php

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
     * Form routes
     */
    //Question form
    \Route::get('surveys/question/form/{id}', array('as' => 'surveysQuestionForm', 'uses' => 'Lava\Surveys\FormController@getQuestion'));

    //Post question form
    \Route::post('surveys/post_question_form', array('as' => 'surveysPostFormQuestion', 'uses' => 'Lava\Surveys\FormController@postQuestion'));

    //Detailed form
    \Route::get('surveys/detailed/form/{id}', array('as' => 'surveysDetailedForm', 'uses' => 'Lava\Surveys\FormController@getDetailed'));

    //List form
    \Route::get('surveys/list/form', array('as' => 'surveysListForm', 'uses' => 'Lava\Surveys\FormController@getList'));

    //Post form
    \Route::get('surveys/post/form/{id?}', array('as' => 'surveysPostForm', 'uses' => 'Lava\Surveys\FormController@getPost'));

    //Create a form
    \Route::post('surveys/create/form', array('as' => 'surveysCreateForm', 'before' => 'csrf', 'uses' => 'Lava\Surveys\FormController@postCreate'));

    //Update a form
    \Route::post('surveys/update/form', array('as' => 'surveysUpdateForm', 'before' => 'csrf', 'uses' => 'Lava\Surveys\FormController@postUpdate'));

    //Delete form
    \Route::post('surveys/delete/form', array('as' => 'surveysDeleteForm', 'uses' => 'Lava\Surveys\FormController@postDelete'));

    //Un-Delete form
    \Route::post('surveys/undelete/form', array('as' => 'surveysUndeleteForm', 'uses' => 'Lava\Surveys\FormController@postUndelete'));

    //Workflow form
    \Route::post('surveys/workflow/form', array('as' => 'surveysWorkflowForm', 'uses' => 'Lava\Surveys\FormController@postWorkflow'));

    /**
     * Question routes
     */
    //Get options question
    \Route::get('surveys/option/question', array('as' => 'surveysGetOptionQuestion', 'uses' => 'Lava\Surveys\QuestionController@getOptionView'));

    //Save options question
    \Route::post('surveys/save_option/question', array('as' => 'surveysSaveOptionQuestion', 'uses' => 'Lava\Surveys\QuestionController@postSaveOption'));

    //Detailed question
    \Route::get('surveys/detailed/question/{id}', array('as' => 'surveysDetailedQuestion', 'uses' => 'Lava\Surveys\QuestionController@getDetailed'));

    //List question
    \Route::get('surveys/list/question', array('as' => 'surveysListQuestion', 'uses' => 'Lava\Surveys\QuestionController@getList'));

    //Post question
    \Route::get('surveys/post/question/{id?}', array('as' => 'surveysPostQuestion', 'uses' => 'Lava\Surveys\QuestionController@getPost'));

    //Create a question
    \Route::post('surveys/create/question', array('as' => 'surveysCreateQuestion', 'before' => 'csrf', 'uses' => 'Lava\Surveys\QuestionController@postCreate'));

    //Update a question
    \Route::post('surveys/update/question', array('as' => 'surveysUpdateQuestion', 'before' => 'csrf', 'uses' => 'Lava\Surveys\QuestionController@postUpdate'));

    //Delete question
    \Route::post('surveys/delete/question', array('as' => 'surveysDeleteQuestion', 'uses' => 'Lava\Surveys\QuestionController@postDelete'));

    //Un-Delete question
    \Route::post('surveys/undelete/question', array('as' => 'surveysUndeleteQuestion', 'uses' => 'Lava\Surveys\QuestionController@postUndelete'));

    /**
     * Option routes
     */
    //Detailed option
    \Route::get('surveys/detailed/option/{id}', array('as' => 'surveysDetailedOption', 'uses' => 'Lava\Surveys\OptionController@getDetailed'));

    //List option
    \Route::get('surveys/list/option', array('as' => 'surveysListOption', 'uses' => 'Lava\Surveys\OptionController@getList'));

    //Post option
    \Route::get('surveys/post/option/{id?}', array('as' => 'surveysPostOption', 'uses' => 'Lava\Surveys\OptionController@getPost'));

    //Create a option
    \Route::post('surveys/create/option', array('as' => 'surveysCreateOption', 'before' => 'csrf', 'uses' => 'Lava\Surveys\OptionController@postCreate'));

    //Update a option
    \Route::post('surveys/update/option', array('as' => 'surveysUpdateOption', 'before' => 'csrf', 'uses' => 'Lava\Surveys\OptionController@postUpdate'));

    //Delete option
    \Route::post('surveys/delete/option', array('as' => 'surveysDeleteOption', 'uses' => 'Lava\Surveys\OptionController@postDelete'));

    //Un-Delete option
    \Route::post('surveys/undelete/option', array('as' => 'surveysUndeleteOption', 'uses' => 'Lava\Surveys\OptionController@postUndelete'));
});


