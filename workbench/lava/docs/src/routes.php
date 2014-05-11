<?php

//Load Login or Sign up page
\Route::get('docs', array('as' => 'docsShow', 'uses' => 'Lava\Docs\DocController@getDocs'));