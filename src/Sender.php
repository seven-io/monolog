<?php namespace Seven\Monolog;

use Sms77\Api\Client;

class Sender implements MessageSenderInterface {
    private $app;
    private $client;
    private $extra;
    private $to;

    public function __construct(Client $client, $to, $app, array $extra = []) {
        $this->client = $client;
        $this->to = $to;
        $this->app = $app;
        $this->extra = $extra;
    }

    public function send($message) {
        $extra = $this->extra;
        $to = $this->to;

        if ($this->app === Config::APP_VOICE) $this->client->voice($to, $message, $extra);
        else $this->client->sms($to, $message, array_merge($extra, ['type' => 'direct']));
    }
}
