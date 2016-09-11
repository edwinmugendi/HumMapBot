<?php
use Lava\Organizations\OrganizationsValidator;

//Validation extensions
\Validator::resolver(function($translator, $data, $rules, $messages) {
            return new OrganizationsValidator($translator, $data, $rules, $messages);
        });