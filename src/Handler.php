<?php namespace Sms77\Monolog;

use Monolog\Handler\AbstractProcessingHandler;

class Handler extends AbstractProcessingHandler {
    private $sender;

    public function __construct(MessageSenderInterface $sender, Config $config) {
        parent::__construct($config->handlerLoggerLevel, $config->handlerBubble);

        $this->sender = $sender;
    }

    public static function buildFromArray(array $cfg) {
        return static::buildFromConfig(new Config($cfg));
    }

    public static function buildFromConfig(Config $cfg) {
        return new Handler(new Sender($cfg->client, $cfg->from, $cfg->to), $cfg);
    }

    protected function write(array $record) {
        $this->sender->send($record['formatted']);
    }
}
