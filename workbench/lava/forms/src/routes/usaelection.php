<?php
\Route::group(array('before' => array('auth', 'https')), function() {

/**
* usaelection routes
*/
//Detailed usaelection
\Route::get('forms/detailed/usaelection/{id}', array('as' => 'formsDetailedUsaelection', 'uses' => 'Lava\Forms\UsaelectionController@getDetailed'));

//List usaelection
\Route::get('forms/list/usaelection', array('as' => 'formsListUsaelection', 'uses' => 'Lava\Forms\UsaelectionController@getList'));

//Post usaelection
\Route::get('forms/post/usaelection/{id?}', array('as' => 'formsPostUsaelection', 'uses' => 'Lava\Forms\UsaelectionController@getPost'));

//Create a usaelection
\Route::post('forms/create/usaelection', array('as' => 'formsCreateUsaelection', 'before' => 'csrf', 'uses' => 'Lava\Forms\UsaelectionController@postCreate'));

//Update a usaelection
\Route::post('forms/update/usaelection', array('as' => 'formsUpdateUsaelection', 'before' => 'csrf', 'uses' => 'Lava\Forms\UsaelectionController@postUpdate'));

//Delete usaelection
\Route::post('forms/delete/usaelection', array('as' => 'formsDeleteusaelection', 'uses' => 'Lava\Forms\UsaelectionController@postDelete'));

//Un-Delete usaelection
\Route::post('forms/undelete/usaelection', array('as' => 'formsUndeleteUsaelection', 'uses' => 'Lava\Forms\UsaelectionController@postUndelete'));
});

