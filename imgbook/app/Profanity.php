<?php

namespace App;

// require_once '../vendor/autoload.php';
use GuzzleHttp\Client;

class Profanity
{
    private $client;

    public function __construct($uri) {
        $this->client = new Client([
            'base_uri' => $uri,
        ]);
    }

    public function checkProfanity($text) {
        return $this->client->request('GET', 'containsprofanity?text=' . $text);
    }
}