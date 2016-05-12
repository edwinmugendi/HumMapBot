<?php

namespace Lava\Merchants;

use Symfony\Component\Translation\TranslatorInterface;
use Carbon\Carbon;

/**
 * S# MerchantsValidator() function
 * Merchants Validator
 * @author Edwin Mugendi
 * @todo We are extending the Accounts Validator because PHP does not offer multiple inheritance. We extend alphabetically
 */
class MerchantsValidator extends \Lava\Loans\LoansValidator {

    //Message object
    private $message;

    /**
     * S# validateBetweenIf() function
     * Validate that the value of attribute is between min and max when another attribute is equal to a given value
     *
     * @author Edwin Mugendi <edwinmugendi@gmail.com>
     * @param  string  $attribute
     * @param  mixed   $value
     * @param  mixed   $parameters
     * @return bool
     */
    protected function validateBetweenIf($attribute, $value, $parameters) {
        $this->requireParameterCount(4, $parameters, 'between_if');
        if ($parameters[1] == array_get($this->data, $parameters[0])) {
            return $this->validateBetween($attribute, $value, array($parameters[2], $parameters[3]));
        }//E# if statement
        return true;
    }

//E# validateBetweenIf() function

    /**
     * S# replaceBetweenIf() function
     * Replace all place-holders for the between_if rule.
     *
     * @author Edwin Mugendi <edwinmugendi@gmail.com>
     * @param  string  $message
     * @param  string  $attribute
     * @param  string  $rule
     * @param  array   $parameters
     * @return string
     */
    protected function replaceBetweenIf($message, $attribute, $rule, $parameters) {
        return str_replace(array(':other', ':value', ':min', ':max'), $parameters, $message);
    }

//E# replaceBetweenIf() function
}
