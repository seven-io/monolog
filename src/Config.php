<?php namespace Sms77\Monolog;

use Assert\Assertion;
use Monolog\Logger;
use function Assert\that;

class Config {
    const APP_SMS = 'sms';
    const APP_VOICE = 'voice';
    const KEY_API_KEY = 'apiKey';
    const KEY_APP = '_app';
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

    protected $apiKey;
    protected $app = self::APP_SMS;
    protected $debug = false;
    protected $flash = false;
    protected $foreignId;
    protected $from;
    protected $handlerLoggerLevel = Logger::CRITICAL;
    protected $handlerBubble = true;
    protected $json = false;
    protected $label;
    protected $noReload = false;
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

    public function getDebug() {
        return (int)$this->debug;
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

    public function getJSON() {
        return (int)$this->json;
    }

    public function getLabel() {
        return $this->label;
    }

    public function getNoReload() {
        return (int)$this->noReload;
    }

    public function getPerformanceTracking() {
        return (int)$this->performanceTracking;
    }

    public function getTo() {
        return $this->to;
    }

    public function getExtra() {
        $extra = [
            self::KEY_DEBUG => $this->getDebug(),
            self::KEY_FROM => $this->getFrom(),
            self::KEY_JSON => $this->getJSON(),
        ];

        if ($this->getApp() === static::APP_SMS) $extra = array_merge($extra, [
            self::KEY_FLASH => $this->getFlash(),
            self::KEY_FOREIGN_ID => $this->getForeignID(),
            self::KEY_LABEL => $this->getLabel(),
            self::KEY_NO_RELOAD => $this->getNoReload(),
            self::KEY_PERFORMANCE_TRACKING => $this->getPerformanceTracking(),
        ]);

        return $extra;
    }

    private function getOption($key, $default) {
        return array_key_exists($key, $this->data) ? $this->data[$key] : $default;
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
        $apiKey = $this->getOption(static::KEY_API_KEY, $this->getApiKey());
        that($apiKey)->scalar()->minLength(1);
        $this->apiKey = $apiKey;
    }

    private function setApp() {
        $app = $this->getOption(static::KEY_APP, $this->getApp());
        that($app)->nullOr()->inArray([static::APP_SMS, static::APP_VOICE]);
        $this->app = $app;
    }

    private function setDebug() {
        $debug = $this->getOption(static::KEY_DEBUG, $this->getDebug());
        that($debug)->nullOr()->inArray([0, 1]);
        $this->debug = $debug;
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

    private function setJSON() {
        $json = $this->getOption(static::KEY_JSON, $this->getJSON());
        that($json)->nullOr()->inArray([0, 1]);
        $this->json = $json;
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

    private function setNoReload() {
        $noReload = $this->getOption(static::KEY_NO_RELOAD, $this->getNoReload());
        that($noReload)->nullOr()->inArray([0, 1]);
        $this->noReload = $noReload;
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
