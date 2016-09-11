<?php
use Lava\Surveys\SurveysValidator;

//Validation extensions
\Validator::resolver(function($translator, $data, $rules, $messages) {
            return new SurveysValidator($translator, $data, $rules, $messages);
        });