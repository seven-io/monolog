<?php namespace Sms77\Monolog;

use Assert\Assertion;
use Monolog\Logger;
use Sms77\Api\Client;
use function Assert\that;

class Config {
    const KEY_API_KEY = 'client';
    const KEY_APP = '_app';
    const APP_SMS = 'sms';
    const APP_VOICE = 'voice';
    const KEY_DEBUG = 'debug';
    const KEY_FLASH = 'flash';
    const KEY_FOREIGN_ID = 'foreign_id';
    const KEY_FROM = 'from';
    const KEY_HANDLER_BUBBLE = 'handler_bubble';
    const KEY_HANDLER_LOGGER_LEVEL = 'handler_logger_level';
    const KEY_JSON = 'json';
    const KEY_LABEL = 'label';
    const KEY_NO_RELOAD = 'no_reload';
    const KEY_PERFORMANCE_TRACKING = 'performance_tracking';
    const KEY_TO = 'to';

    public $app;
    public $client;
    public $debug;
    public $flash;
    public $foreignId;
    public $from;
    public $handlerLoggerLevel;
    public $handlerBubble;
    public $json;
    public $label;
    public $noReload;
    public $performanceTracking;
    public $to;

    public function __construct(array $data) {
        $data = array_merge([
            static::KEY_HANDLER_BUBBLE => true,
            static::KEY_HANDLER_LOGGER_LEVEL => Logger::CRITICAL,
        ], $data);

        $this->setApp($data[static::KEY_APP]);
        $this->setClient($data[static::KEY_API_KEY]);
        $this->setDebug($data[static::KEY_DEBUG]);
        $this->setFlash($data[static::KEY_FLASH]);
        $this->setForeignId($data[static::KEY_FOREIGN_ID]);
        $this->setFrom($data[static::KEY_FROM]);
        $this->setHandlerBubble($data[static::KEY_HANDLER_BUBBLE]);
        $this->setHandlerLoggerLevel($data[static::KEY_HANDLER_LOGGER_LEVEL]);
        $this->setLabel($data[static::KEY_LABEL]);
        $this->setNoReload($data[static::KEY_NO_RELOAD]);
        $this->setPerformanceTracking($data[static::KEY_PERFORMANCE_TRACKING]);
        $this->setTo($data[static::KEY_TO]);
    }

    public function getExtra() {
        $extra = [
            self::KEY_DEBUG => $this->debug,
            self::KEY_JSON => $this->json,
        ];

        if ($this->app === static::APP_SMS) $extra = array_merge($extra, [
            self::KEY_FLASH => $this->flash,
            self::KEY_FOREIGN_ID => $this->foreignId,
            self::KEY_LABEL => $this->label,
            self::KEY_NO_RELOAD => $this->noReload,
            self::KEY_PERFORMANCE_TRACKING => $this->performanceTracking,
        ]);

        return $extra;
    }

    private function setApp($app) {
        that($app)->nullOr()->inArray([static::APP_SMS, static::APP_VOICE]);
        $this->app = $app;
    }

    private function setClient($apiKey) {
        that($apiKey)->scalar()->minLength(1);
        $this->client = new Client($apiKey, 'monolog');
    }

    private function setDebug($debug) {
        that($debug)->nullOr()->inArray([0, 1]);
        $this->debug = $debug;
    }

    private function setFlash($flash) {
        that($flash)->nullOr()->inArray([0, 1]);
        $this->flash = $flash;
    }

    private function setForeignId($foreignId) {
        that($foreignId)->nullOr()->scalar()->minLength(0)->maxLength(64)->regex('/[a-zA-Z0-9, ._@]/');
        $this->foreignId = $foreignId;
    }

    private function setFrom($from) {
        that($from)->scalar()->minLength(0)->maxLength(16);
        $this->from = $from;
    }

    private function setJSON($json) {
        that($json)->nullOr()->inArray([0, 1]);
        $this->json = $json;
    }

    private function setLabel($label) {
        that($label)->nullOr()->scalar()->minLength(0)->maxLength(100)->regex('/[a-zA-Z0-9, ._@]/');
        $this->label = $label;
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

    private function setNoReload($noReload) {
        that($noReload)->nullOr()->inArray([0, 1]);
        $this->noReload = $noReload;
    }

    private function setPerformanceTracking($performanceTracking) {
        that($performanceTracking)->nullOr()->inArray([0, 1]);
        $this->performanceTracking = $performanceTracking;
    }

    private function setTo($to) {
        that($to)->scalar()->minLength(1);
        $this->to = $to;
    }
}
