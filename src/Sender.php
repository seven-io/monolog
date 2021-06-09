<?php namespace Sms77\Monolog;

use Sms77\Api\Client;

class Sender implements MessageSenderInterface {
    private $client;
    private $from;
    private $to;

    public function __construct(Client $client, $from, $to) {
        $this->client = $client;
        $this->from = $from;
        $this->to = $to;
    }

    public function send($text) {
        $this->client->sms($this->to, $text, ['from' => $this->from]);
    }
}
