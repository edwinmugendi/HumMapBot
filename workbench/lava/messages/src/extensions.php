<?php
use Lava\Messages\MessagesValidator;

//Validation extensions
\Validator::resolver(function($translator, $data, $rules, $messages) {
            return new MessagesValidator($translator, $data, $rules, $messages);
        });