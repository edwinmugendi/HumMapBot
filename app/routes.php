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

Route::get('/', function() {
    return View::make('hello');
});

//Log database queries
/*
DB::listen(function($sql, $bindings, $time) {
            \Log::debug(json_encode($sql));
            \Log::debug(json_encode($bindings));
        });
 * 
 */