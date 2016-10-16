<?php
\Route::group(array('before' => array('auth', 'https')), function() {

/**
* data contact routes
*/
//Detailed data contact
\Route::get('forms/detailed/data_contact/{id}', array('as' => 'formsDetailedDataContact', 'uses' => 'Lava\Forms\DataContactController@getDetailed'));

//List data contact
\Route::get('forms/list/data_contact', array('as' => 'formsListDataContact', 'uses' => 'Lava\Forms\DataContactController@getList'));

//Post data contact
\Route::get('forms/post/data_contact/{id?}', array('as' => 'formsPostDataContact', 'uses' => 'Lava\Forms\DataContactController@getPost'));

//Create a data contact
\Route::post('forms/create/data_contact', array('as' => 'formsCreateDataContact', 'before' => 'csrf', 'uses' => 'Lava\Forms\DataContactController@postCreate'));

//Update a data contact
\Route::post('forms/update/data_contact', array('as' => 'formsUpdateDataContact', 'before' => 'csrf', 'uses' => 'Lava\Forms\DataContactController@postUpdate'));

//Delete data contact
\Route::post('forms/delete/data_contact', array('as' => 'formsDeletedataContact', 'uses' => 'Lava\Forms\DataContactController@postDelete'));

//Un-Delete data contact
\Route::post('forms/undelete/data_contact', array('as' => 'formsUndeleteDataContact', 'uses' => 'Lava\Forms\DataContactController@postUndelete'));
});

