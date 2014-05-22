<?php
use Lava\Products\ProductsValidator;

//Validation extensions
\Validator::resolver(function($translator, $data, $rules, $messages) {
            return new ProductsValidator($translator, $data, $rules, $messages);
        });