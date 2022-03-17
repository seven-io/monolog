<?php namespace Sms77\Monolog;

use Sms77\Api\Client;

class Sender implements MessageSenderInterface {
    private $app;
    private $client;
    private $extra;
    private $from;
    private $to;

    public function __construct(Client $client, $from, $to, $app, array $extra = []) {
        $this->client = $client;
        $this->from = $from;
        $this->to = $to;
        $this->app = $app;
        $this->extra = $extra;
    }

    public function send($message) {
        $extra = array_merge($this->extra, [
            'from' => $this->from,
        ]);
        $to = $this->to;

        if ($this->app === Config::APP_VOICE) $this->client->voice($to, $message, $extra);
        else $this->client->sms($to, $message, $extra);
    }
}
