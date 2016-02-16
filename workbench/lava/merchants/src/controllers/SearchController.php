<?php

namespace Lava\Merchants;

/**
 * S# SearchController() function
 * Searchs controller
 * @author Edwin Mugendi
 */
class SearchController extends MerchantsBaseController {

    //Controller
    public $controller = 'search';
    //Lazy load
    public $ownedBy = array('user');

}

//E# SearchController() function