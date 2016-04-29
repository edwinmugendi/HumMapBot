<?php
use Lava\Loans\LoansValidator;

//Validation extensions
\Validator::resolver(function($translator, $data, $rules, $messages) {
            return new LoansValidator($translator, $data, $rules, $messages);
        });