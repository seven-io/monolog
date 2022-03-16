<?php namespace Sms77\Monolog;

use Sms77\Api\Client;

class Sender implements MessageSenderInterface {
    private $client;
    private $extra;
    private $from;
    private $to;

    public function __construct(Client $client, $from, $to, array $extra = []) {
        $this->client = $client;
        $this->from = $from;
        $this->to = $to;
        $this->extra = $extra;
    }

    public function send($message) {
        $extra = array_merge($this->extra, [
            'from' => $this->from,
        ]);

        $this->client->sms($this->to, $message, $extra);
    }
}
