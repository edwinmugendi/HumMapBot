<?php

\Route::group(array('before' => 'auth'), function() {
    /**
     * Form routes
     */
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

    /**
     * Question routes
     */
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


