<?php

namespace Lava\Messages;

use Symfony\Component\Translation\TranslatorInterface;
use Carbon\Carbon;

/**
 * S# MessagesValidator() function
 * Messages Validator
 * @author Edwin Mugendi
 * @todo We are extending the Merchant Validator because PHP does not offer multiple inheritance. We extend alphabetically
 */
class MessagesValidator extends \Lava\Merchants\MerchantsValidator {

    //Message object
    private $message;

}
