<?php
use Lava\Accounts\AccountsValidator;

//Validation extensions
\Validator::resolver(function($translator, $data, $rules, $messages) {
            return new AccountsValidator($translator, $data, $rules, $messages);
        });