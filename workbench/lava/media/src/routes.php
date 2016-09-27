<?php

\Route::group(array('before' => array('auth', 'https')), function() {
    /**
     * Media controller routes
     */
    Route::post('media/upload', array('uses' => 'Lava\Media\MediaController@upload'));
    Route::delete('media/drop', array('uses' => 'Lava\Media\MediaController@drop'));
    Route::put('media/describe', array('uses' => 'Lava\Media\MediaController@describe'));
    Route::put('media/order', array('uses' => 'Lava\Media\MediaController@order'));
    Route::get('media/uploaded', array('uses' => 'Lava\Media\MediaController@uploaded'));
    Route::get('media/download', array('uses' => 'Lava\Media\MediaController@download'));
    Route::post('media/download', array('as' => 'mediaDownload', 'uses' => 'Lava\Media\MediaController@download'));
});
