<?php

use GuzzleHttp\Client;

class Profanity
{
    private $baseLink = "https://www.purgomalum.com/service/json?text=";

    public function __construct() {

    }

    public function checkProfanity($text) {
        $client->request('GET', $baseLink + $text);
    }
}