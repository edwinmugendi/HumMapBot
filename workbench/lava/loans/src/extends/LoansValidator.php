<?php

namespace Lava\Loans;

use Symfony\Component\Translation\TranslatorInterface;
use Carbon\Carbon;

/**
 * S# LoansValidator() function
 * Loans Validator
 * @author Edwin Mugendi
 * @todo We are extending the Payments Validator because PHP does not offer multiple inheritance. We extend alphabetically
 */
class LoansValidator extends \Lava\Payments\PaymentsValidator {

    //Message object
    private $message;

}
