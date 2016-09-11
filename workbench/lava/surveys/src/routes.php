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
});


