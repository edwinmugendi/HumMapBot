<?php
\Route::group(array('before' => array('auth', 'https')), function() {

/**
* contact routes
*/
//Detailed contact
\Route::get('forms/detailed/contact/{id}', array('as' => 'formsDetailedContact', 'uses' => 'Lava\Forms\ContactController@getDetailed'));

//List contact
\Route::get('forms/list/contact', array('as' => 'formsListContact', 'uses' => 'Lava\Forms\ContactController@getList'));

//Post contact
\Route::get('forms/post/contact/{id?}', array('as' => 'formsPostContact', 'uses' => 'Lava\Forms\ContactController@getPost'));

//Create a contact
\Route::post('forms/create/contact', array('as' => 'formsCreateContact', 'before' => 'csrf', 'uses' => 'Lava\Forms\ContactController@postCreate'));

//Update a contact
\Route::post('forms/update/contact', array('as' => 'formsUpdateContact', 'before' => 'csrf', 'uses' => 'Lava\Forms\ContactController@postUpdate'));

//Delete contact
\Route::post('forms/delete/contact', array('as' => 'formsDeletecontact', 'uses' => 'Lava\Forms\ContactController@postDelete'));

//Un-Delete contact
\Route::post('forms/undelete/contact', array('as' => 'formsUndeleteContact', 'uses' => 'Lava\Forms\ContactController@postUndelete'));
});

