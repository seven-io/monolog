<?php namespace Seven\Monolog;

use Monolog\Handler\AbstractProcessingHandler;
use Sms77\Api\Client;

class Handler extends AbstractProcessingHandler {
    private $sender;

    public function __construct(MessageSenderInterface $sender, Config $config) {
        parent::__construct($config->getHandlerLoggerLevel(), $config->getHandlerBubble());
        $this->sender = $sender;
    }

    public static function buildFromArray(array $cfg) {
        return static::buildFromConfig(new Config($cfg));
    }

    public static function buildFromConfig(Config $cfg) {
        $client = new Client($cfg->getApiKey(), 'monolog');

        $extra = [
            Config::KEY_FROM => $cfg->getFrom(),
            Config::KEY_JSON => $cfg->getJSON(),
        ];
        if ($cfg->getApp() === Config::APP_SMS) $extra = array_merge($extra, [
            Config::KEY_FLASH => $cfg->getFlash(),
            Config::KEY_FOREIGN_ID => $cfg->getForeignID(),
            Config::KEY_LABEL => $cfg->getLabel(),
            Config::KEY_NO_RELOAD => $cfg->getNoReload(),
            Config::KEY_PERFORMANCE_TRACKING => $cfg->getPerformanceTracking(),
        ]);

        $sender = new Sender($client, $cfg->getTo(), $cfg->getApp(), $extra);

        return new Handler($sender, $cfg);
    }

    protected function write(array $record) {
        $this->sender->send($record['formatted']);
    }
}
