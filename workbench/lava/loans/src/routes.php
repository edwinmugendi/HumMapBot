<?php

\Route::group(array('before' => 'api'), function() {
    
});

\Route::group(array('before' => 'auth'), function() {
    
        /**
     * Schedule routes
     */
    //Detailed schedule
    \Route::get('loans/detailed/schedule/{id}', array('as' => 'loansDetailedSchedule', 'uses' => 'Lava\Loans\ScheduleController@getDetailed'));

    //List schedule
    \Route::get('loans/list/schedule', array('as' => 'loansListSchedule', 'uses' => 'Lava\Loans\ScheduleController@getList'));

    //Post schedule
    \Route::get('loans/post/schedule/{id?}', array('as' => 'loansPostSchedule', 'uses' => 'Lava\Loans\ScheduleController@getPost'));

    //Create a schedule
    \Route::post('loans/create/schedule', array('as' => 'loansCreateSchedule', 'before' => 'csrf', 'uses' => 'Lava\Loans\ScheduleController@postCreate'));

    //Update a schedule
    \Route::post('loans/update/schedule', array('as' => 'loansUpdateSchedule', 'before' => 'csrf', 'uses' => 'Lava\Loans\ScheduleController@postUpdate'));

    //Delete schedule
    \Route::post('loans/delete/schedule', array('as' => 'loansDeleteSchedule', 'uses' => 'Lava\Loans\ScheduleController@postDelete'));

    //Un-Delete schedule
    \Route::post('loans/undelete/schedule', array('as' => 'loansUndeleteSchedule', 'uses' => 'Lava\Loans\ScheduleController@postUndelete'));

    /**
     * Plan routes
     */
    //Detailed plan
    \Route::get('loans/detailed/plan/{id}', array('as' => 'loansDetailedPlan', 'uses' => 'Lava\Loans\PlanController@getDetailed'));

    //List plan
    \Route::get('loans/list/plan', array('as' => 'loansListPlan', 'uses' => 'Lava\Loans\PlanController@getList'));

    //Post plan
    \Route::get('loans/post/plan/{id?}', array('as' => 'loansPostPlan', 'uses' => 'Lava\Loans\PlanController@getPost'));

    //Create a plan
    \Route::post('loans/create/plan', array('as' => 'loansCreatePlan', 'before' => 'csrf', 'uses' => 'Lava\Loans\PlanController@postCreate'));

    //Update a plan
    \Route::post('loans/update/plan', array('as' => 'loansUpdatePlan', 'before' => 'csrf', 'uses' => 'Lava\Loans\PlanController@postUpdate'));

    //Delete plan
    \Route::post('loans/delete/plan', array('as' => 'loansDeletePlan', 'uses' => 'Lava\Loans\PlanController@postDelete'));

    //Un-Delete plan
    \Route::post('loans/undelete/plan', array('as' => 'loansUndeletePlan', 'uses' => 'Lava\Loans\PlanController@postUndelete'));

    /**
     * Loan routes
     */
    //Detailed loan
    \Route::get('loans/detailed/loan/{id}', array('as' => 'loansDetailedLoan', 'uses' => 'Lava\Loans\LoanController@getDetailed'));

    //List loan
    \Route::get('loans/list/loan', array('as' => 'loansListLoan', 'uses' => 'Lava\Loans\LoanController@getList'));

    //Post loan
    \Route::get('loans/post/loan/{id?}', array('as' => 'loansPostLoan', 'uses' => 'Lava\Loans\LoanController@getPost'));

    //Create a loan
    \Route::post('loans/create/loan', array('as' => 'loansCreateLoan', 'before' => 'csrf', 'uses' => 'Lava\Loans\LoanController@postCreate'));

    //Update a loan
    \Route::post('loans/update/loan', array('as' => 'loansUpdateLoan', 'before' => 'csrf', 'uses' => 'Lava\Loans\LoanController@postUpdate'));

    //Delete loan
    \Route::post('loans/delete/loan', array('as' => 'loansDeleteLoan', 'uses' => 'Lava\Loans\LoanController@postDelete'));

    //Un-Delete loan
    \Route::post('loans/undelete/loan', array('as' => 'loansUndeleteLoan', 'uses' => 'Lava\Loans\LoanController@postUndelete'));

});
