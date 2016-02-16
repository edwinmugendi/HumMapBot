<?php

namespace Lava\Media;

use \Google_Client;

/**
 * S# GcloudController() Class
 * @author Edwin Mugendi
 * Google Controller
 */
class GcloudController {

    protected $client;

    public function __construct() {
        $this->client = new Google_Client();
        $this->client->setClientId(\Config::get('google.client_id'));
        $this->client->setClientSecret(\Config::get('google.client_secret'));
        $this->client->setRedirectUri('postmessage');

        $this->cal = new Google_Stora($this->client);
    }

    public function google_test() {
        var_dump($this->isUserGoogleLinked('edwin.sapama@gmail.com'));

        dd($this->createUpdateEvent($this->calendar_id, 'This is it', 'Meet with Edwin', '2013-12-26T16:00:00', '2013-12-26T18:00:00'));
    }

}

//E# GcloudController() Class