<?php namespace Sms77\Monolog;

use Assert\Assertion;
use Monolog\Logger;
use Sms77\Api\Client;
use function Assert\that;

class Config {
    const KEY_API_KEY = 'client';
    const KEY_DEBUG = 'debug';
    const KEY_FROM = 'from';
    const KEY_HANDLER_BUBBLE = 'handler_bubble';
    const KEY_HANDLER_LOGGER_LEVEL = 'handler_logger_level';
    const KEY_TO = 'to';

    public $client;
    public $debug;
    public $handlerLoggerLevel;
    public $handlerBubble;
    public $from;
    public $to;

    public function __construct(array $data) {
        $data = array_merge([
            static::KEY_HANDLER_BUBBLE => true,
            static::KEY_HANDLER_LOGGER_LEVEL => Logger::CRITICAL,
        ], $data);

        $this->setClient($data[static::KEY_API_KEY]);
        $this->setDebug($data[static::KEY_DEBUG]);
        $this->setFrom($data[static::KEY_FROM]);
        $this->setHandlerBubble($data[static::KEY_HANDLER_BUBBLE]);
        $this->setHandlerLoggerLevel($data[static::KEY_HANDLER_LOGGER_LEVEL]);
        $this->setTo($data[static::KEY_TO]);
    }

    public function getExtra() {
        return [
            'debug' => $this->debug,
        ];
    }

    private function setClient($apiKey) {
        that($apiKey)->scalar()->minLength(1);
        $this->client = new Client($apiKey, 'monolog');
    }

    private function setDebug($debug) {
        that($debug)->nullOr()->inArray([0, 1]);
        $this->debug = $debug;
    }

    private function setFrom($from) {
        that($from)->scalar()->minLength(0)->maxLength(16);
        $this->from = $from;
    }

    private function setHandlerBubble($handlerBubble) {
        Assertion::boolean($handlerBubble);
        $this->handlerBubble = $handlerBubble;
    }

    private function setHandlerLoggerLevel($handlerLoggerLevel) {
        Assertion::inArray($handlerLoggerLevel, [
            Logger::DEBUG,
            Logger::INFO,
            Logger::NOTICE,
            Logger::WARNING,
            Logger::ERROR,
            Logger::CRITICAL,
            Logger::ALERT,
            Logger::EMERGENCY,
        ]);
        $this->handlerLoggerLevel = $handlerLoggerLevel;
    }

    private function setTo($to) {
        that($to)->scalar()->minLength(1);
        $this->to = $to;
    }
}
