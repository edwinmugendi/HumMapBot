<?php
use Lava\Payments\PaymentsValidator;

//Validation extensions
\Validator::resolver(function($translator, $data, $rules, $messages) {
            return new PaymentsValidator($translator, $data, $rules, $messages);
        });