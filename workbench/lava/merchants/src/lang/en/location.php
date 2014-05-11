<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | Vehicle Language Lines
      |--------------------------------------------------------------------------
     */
    'api' => array(
        'getSingle' => 'Location :field :value found.',
        'getAll' => 'Locations list',
        'feel'=>array(
            1=>'Location :field :value favoured',
            2=>'Location :field :value rated',
            3=>'Location :field :value reviewed'
        )
    ),
    'validation' => array(
        'feeling' => 'VRM is in use',
        'vrmDelete' => 'No such VRM attached to you'
    ),
    'data' => array(
        'type' => array(
            '' => 'Select',
            1 => 'Favourites',
            2 => 'Ratings',
            3 => 'Reviews'
        )
    )
);
