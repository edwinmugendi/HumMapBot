<?php
\Route::group(array('before' => array('auth', 'https')), function() {

/**
* testing routes
*/
//Detailed testing
\Route::get('forms/detailed/testing/{id}', array('as' => 'formsDetailedTesting', 'uses' => 'Lava\Forms\TestingController@getDetailed'));

//List testing
\Route::get('forms/list/testing', array('as' => 'formsListTesting', 'uses' => 'Lava\Forms\TestingController@getList'));

//Post testing
\Route::get('forms/post/testing/{id?}', array('as' => 'formsPostTesting', 'uses' => 'Lava\Forms\TestingController@getPost'));

//Create a testing
\Route::post('forms/create/testing', array('as' => 'formsCreateTesting', 'before' => 'csrf', 'uses' => 'Lava\Forms\TestingController@postCreate'));

//Update a testing
\Route::post('forms/update/testing', array('as' => 'formsUpdateTesting', 'before' => 'csrf', 'uses' => 'Lava\Forms\TestingController@postUpdate'));

//Delete testing
\Route::post('forms/delete/testing', array('as' => 'formsDeletetesting', 'uses' => 'Lava\Forms\TestingController@postDelete'));

//Un-Delete testing
\Route::post('forms/undelete/testing', array('as' => 'formsUndeleteTesting', 'uses' => 'Lava\Forms\TestingController@postUndelete'));
});

