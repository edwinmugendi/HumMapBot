<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */


if (\App::environment() == 'local') {
    DB::listen(function($sql, $bindings, $time) {
        \Log::debug(json_encode($sql));
    });
}

//Import: Get Step
\Route::get('import/get_step', array('as' => 'getImportStep', 'uses' => '\ImportController@getStep'));

//Import: Import Upload
\Route::post('import/uploading', array('as' => 'postImportUpload', 'uses' => '\ImportController@postUpload'));

//Import: Import
\Route::post('import/import', array('as' => 'postImportImport', 'uses' => '\ImportController@postImport'));
