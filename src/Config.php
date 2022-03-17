<?php namespace Sms77\Monolog;

use Assert\Assertion;
use Monolog\Logger;
use function Assert\that;

class Config {
    const KEY_API_KEY = 'apiKey';
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

    public $apiKey;
    public $app = self::APP_SMS;
    public $debug;
    public $flash;
    public $foreignId;
    public $from;
    public $handlerLoggerLevel = Logger::CRITICAL;
    public $handlerBubble = true;
    public $json;
    public $label;
    public $noReload;
    public $performanceTracking;
    public $to;

    private $data;

    public function __construct(array $data) {
        $this->data = $data;
        $this->init();
    }

    public function getExtra() {
        $extra = [
            self::KEY_DEBUG => $this->debug,
            self::KEY_FROM => $this->from,
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

    private function setApp() {
        $key = static::KEY_APP;
        $app = array_key_exists($key, $this->data) ? $this->data[$key] : $this->app;
        that($app)->nullOr()->inArray([static::APP_SMS, static::APP_VOICE]);
        $this->app = $app;
    }

    private function init() {
        $this->setApp();
        $this->setApiKey();
        $this->setDebug();
        $this->setFlash();
        $this->setForeignId();
        $this->setFrom();
        $this->setHandlerBubble();
        $this->setHandlerLoggerLevel();
        $this->setLabel();
        $this->setJSON();
        $this->setNoReload();
        $this->setPerformanceTracking();
        $this->setTo();
    }

    private function setApiKey() {
        $key = static::KEY_API_KEY;
        $apiKey = array_key_exists($key, $this->data) ? $this->data[$key] : $this->apiKey;
        that($apiKey)->scalar()->minLength(1);
        $this->apiKey = $apiKey;
    }

    private function setDebug() {
        $key = static::KEY_DEBUG;
        $debug = array_key_exists($key, $this->data) ? $this->data[$key] : $this->debug;
        that($debug)->nullOr()->inArray([0, 1]);
        $this->debug = $debug;
    }

    private function setFlash() {
        $key = static::KEY_FLASH;
        $flash = array_key_exists($key, $this->data) ? $this->data[$key] : $this->flash;
        that($flash)->nullOr()->inArray([0, 1]);
        $this->flash = $flash;
    }

    private function setForeignId() {
        $key = static::KEY_FOREIGN_ID;
        $foreignId = array_key_exists($key, $this->data) ? $this->data[$key] : $this->foreignId;
        that($foreignId)->nullOr()->scalar()->minLength(0)->maxLength(64)->regex('/[a-zA-Z0-9, ._@]/');
        $this->foreignId = $foreignId;
    }

    private function setFrom() {
        $key = static::KEY_FROM;
        $from = array_key_exists($key, $this->data) ? $this->data[$key] : $this->from;
        that($from)->nullOr()->scalar()->minLength(0)->maxLength(16);
        $this->from = $from;
    }

    private function setJSON() {
        $key = static::KEY_JSON;
        $json = array_key_exists($key, $this->data) ? $this->data[$key] : $this->json;
        that($json)->nullOr()->inArray([0, 1]);
        $this->json = $json;
    }

    private function setLabel() {
        $key = static::KEY_LABEL;
        $label = array_key_exists($key, $this->data) ? $this->data[$key] : $this->label;
        that($label)->nullOr()->scalar()->minLength(0)->maxLength(100)->regex('/[a-zA-Z0-9, ._@]/');
        $this->label = $label;
    }

    private function setHandlerBubble() {
        $key = static::KEY_HANDLER_BUBBLE;
        $handlerBubble = array_key_exists($key, $this->data) ? $this->data[$key] : $this->handlerBubble;
        Assertion::boolean($handlerBubble);
        $this->handlerBubble = $handlerBubble;
    }

    private function setHandlerLoggerLevel() {
        $key = static::KEY_HANDLER_LOGGER_LEVEL;
        $handlerLoggerLevel = array_key_exists($key, $this->data) ? $this->data[$key] : $this->handlerLoggerLevel;
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

    private function setNoReload() {
        $key = static::KEY_NO_RELOAD;
        $noReload = array_key_exists($key, $this->data) ? $this->data[$key] : $this->noReload;
        that($noReload)->nullOr()->inArray([0, 1]);
        $this->noReload = $noReload;
    }

    private function setPerformanceTracking() {
        $key = static::KEY_PERFORMANCE_TRACKING;
        $performanceTracking = array_key_exists($key, $this->data) ? $this->data[$key] : $this->performanceTracking;
        that($performanceTracking)->nullOr()->inArray([0, 1]);
        $this->performanceTracking = $performanceTracking;
    }

    private function setTo() {
        $key = static::KEY_TO;
        $to = array_key_exists($key, $this->data) ? $this->data[$key] : $this->to;
        that($to)->scalar()->minLength(1);
        $this->to = $to;
    }
}
