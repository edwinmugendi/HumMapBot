<?php

/**
 * S# BaseArrayDataModel() Class
 * @author Edwin Mugendi
 * Base Array Data Model Model
 */
class BaseArrayDataModel {

    /**
     * S# getPerPageSelectOptions() function
     * Get the per page select options arr
     * @return array per page select options array
     */
    public static function getPerPageSelectOptions() {
        return array(
            '' => \Lang::get('common.data.per_page.-1'),
            25 => \Lang::get('common.data.per_page.25'),
            50 => \Lang::get('common.data.per_page.50'),
            75 => \Lang::get('common.data.per_page.75'),
            100 => \Lang::get('common.data.per_page.100'),
        );
    }

//E# getPerPageSelectOptions() function

    /**
     * S# getOrderSelectOptions() function
     * Get the order select options arr
     * @return array order select options array
     */
    public static function getOrderSelectOptions() {
        return array(
            '' => \Lang::get('common.data.order.-1'),
            'asc' => \Lang::get('common.data.order.asc'),
            'desc' => \Lang::get('common.data.order.desc'),
        );
    }

//E# getOrderSelectOptions() function
}

//E# BaseArrayDataModel() Class