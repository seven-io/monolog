<?php namespace Seven\Monolog;

use Assert\Assertion;
use Monolog\Logger;
use function Assert\that;

class Config {
    const APP_SMS = 'sms';
    const APP_VOICE = 'voice';
    const KEY_API_KEY = 'apiKey';
    const KEY_APP = '_app';
    const KEY_FLASH = 'flash';
    const KEY_FOREIGN_ID = 'foreign_id';
    const KEY_FROM = 'from';
    const KEY_HANDLER_BUBBLE = 'handler_bubble';
    const KEY_HANDLER_LOGGER_LEVEL = 'handler_logger_level';
    const KEY_LABEL = 'label';
    const KEY_PERFORMANCE_TRACKING = 'performance_tracking';
    const KEY_TO = 'to';

    protected $apiKey;
    protected $app = self::APP_SMS;
    protected $flash = false;
    protected $foreignId;
    protected $from;
    protected $handlerLoggerLevel = Logger::CRITICAL;
    protected $handlerBubble = true;
    protected $label;
    protected $performanceTracking = false;
    protected $to;

    private $data;

    public function __construct(array $data) {
        $this->data = $data;
        $this->init();
    }

    public function getApiKey() {
        return $this->apiKey;
    }

    public function getApp() {
        return $this->app;
    }

    public function getFlash() {
        return (int)$this->flash;
    }

    public function getForeignID() {
        return $this->foreignId;
    }

    public function getFrom() {
        return $this->from;
    }

    public function getHandlerBubble() {
        return $this->handlerBubble;
    }

    public function getHandlerLoggerLevel() {
        return $this->handlerLoggerLevel;
    }

    public function getLabel() {
        return $this->label;
    }

    public function getPerformanceTracking() {
        return (int)$this->performanceTracking;
    }

    public function getTo() {
        return $this->to;
    }

    private function getOption($key, $default) {
        return array_key_exists($key, $this->data) ? $this->data[$key] : $default;
    }

    private function init() {
        $this->setApp();
        $this->setApiKey();
        $this->setFlash();
        $this->setForeignId();
        $this->setFrom();
        $this->setHandlerBubble();
        $this->setHandlerLoggerLevel();
        $this->setLabel();
        $this->setPerformanceTracking();
        $this->setTo();
    }

    private function setApiKey() {
        $apiKey = $this->getOption(static::KEY_API_KEY, $this->getApiKey());
        that($apiKey)->scalar()->minLength(1);
        $this->apiKey = $apiKey;
    }

    private function setApp() {
        $app = $this->getOption(static::KEY_APP, $this->getApp());
        that($app)->nullOr()->inArray([static::APP_SMS, static::APP_VOICE]);
        $this->app = $app;
    }

    private function setFlash() {
        $flash = $this->getOption(static::KEY_FLASH, $this->getFlash());
        that($flash)->nullOr()->inArray([0, 1]);
        $this->flash = $flash;
    }

    private function setForeignId() {
        $foreignId = $this->getOption(static::KEY_FOREIGN_ID, $this->getForeignID());
        that($foreignId)->nullOr()->scalar()->minLength(0)->maxLength(64)->regex('/[a-zA-Z0-9, ._@]/');
        $this->foreignId = $foreignId;
    }

    private function setFrom() {
        $from = $this->getOption(static::KEY_FROM, $this->getFrom());
        that($from)->nullOr()->scalar()->minLength(0)->maxLength(16);
        $this->from = $from;
    }

    private function setLabel() {
        $label = $this->getOption(static::KEY_LABEL, $this->getLabel());
        that($label)->nullOr()->scalar()->minLength(0)->maxLength(100)->regex('/[a-zA-Z0-9, ._@]/');
        $this->label = $label;
    }

    private function setHandlerBubble() {
        $handlerBubble = $this->getOption(static::KEY_HANDLER_BUBBLE, $this->getHandlerBubble());
        Assertion::boolean($handlerBubble);
        $this->handlerBubble = $handlerBubble;
    }

    private function setHandlerLoggerLevel() {
        $handlerLoggerLevel = $this->getOption(static::KEY_HANDLER_LOGGER_LEVEL, $this->getHandlerLoggerLevel());
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

    private function setPerformanceTracking() {
        $performanceTracking = $this->getOption(static::KEY_PERFORMANCE_TRACKING, $this->getPerformanceTracking());
        that($performanceTracking)->nullOr()->inArray([0, 1]);
        $this->performanceTracking = $performanceTracking;
    }

    private function setTo() {
        $to = $this->getOption(static::KEY_TO, $this->getTo());
        that($to)->scalar()->minLength(1);
        $this->to = $to;
    }
}
