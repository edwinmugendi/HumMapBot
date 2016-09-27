<?php

\Route::group(array('before' => array('auth', 'https')), function() {

    /**
     * Organization routes
     */
    //Change a organization
    \Route::post('organizations/change/organization', array('as' => 'organizationsChangeOrganization', 'uses' => 'Lava\Organizations\OrganizationController@postChangeOrganization'));

    //Detailed organization
    \Route::get('organizations/detailed/organization/{id}', array('as' => 'organizationsDetailedOrganization', 'uses' => 'Lava\Organizations\OrganizationController@getDetailed'));

    //List organization
    \Route::get('organizations/list/organization', array('as' => 'organizationsListOrganization', 'uses' => 'Lava\Organizations\OrganizationController@getList'));

    //Post organization
    \Route::get('organizations/post/organization/{id?}', array('as' => 'organizationsPostOrganization', 'uses' => 'Lava\Organizations\OrganizationController@getPost'));

    //Create a organization
    \Route::post('organizations/create/organization', array('as' => 'organizationsCreateOrganization', 'before' => 'csrf', 'uses' => 'Lava\Organizations\OrganizationController@postCreate'));

    //Update a organization
    \Route::post('organizations/update/organization', array('as' => 'organizationsUpdateOrganization', 'before' => 'csrf', 'uses' => 'Lava\Organizations\OrganizationController@postUpdate'));

    //Delete organization
    \Route::post('organizations/delete/organization', array('as' => 'organizationsDeleteOrganization', 'uses' => 'Lava\Organizations\OrganizationController@postDelete'));

    //Un-Delete organization
    \Route::post('organizations/undelete/organization', array('as' => 'organizationsUndeleteOrganization', 'uses' => 'Lava\Organizations\OrganizationController@postUndelete'));
});


