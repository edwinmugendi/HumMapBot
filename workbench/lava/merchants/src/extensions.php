<?php
use Lava\Merchants\MerchantsValidator;

//Validation extensions
\Validator::resolver(function($translator, $data, $rules, $messages) {
            return new MerchantsValidator($translator, $data, $rules, $messages);
        });