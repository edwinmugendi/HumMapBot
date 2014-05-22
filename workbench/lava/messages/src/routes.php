<?php

//Sign out User
\Route::get('message/test/send/{type}', array('as' => 'testSendSMS', 'uses' => 'Lava\Messages\MessageController@testSend'));
