<?php namespace Seven\Monolog\Tests;

use Monolog\Logger;
use PHPUnit_Framework_TestCase;
use Seven\Monolog\Config;
use Seven\Monolog\Handler;

class SmsTest extends PHPUnit_Framework_TestCase {
    /** @test */
    public function it_should_act_like_sending_a_message() {
        $spy = new MessageSenderMock;
        $cfg = new Config([
            Config::KEY_API_KEY => getenv('SEVEN_API_KEY_SANDBOX'),
            Config::KEY_FLASH => 0,
            Config::KEY_FOREIGN_ID => 'mock',
            Config::KEY_FROM => 'MonologTest',
            Config::KEY_LABEL => 'mock',
            Config::KEY_PERFORMANCE_TRACKING => 1,
            Config::KEY_TO => '+491716992343',
        ]);
        $handler = new Handler($spy, $cfg);
        $logger = new Logger('test');

        $logger
            ->pushHandler($handler)
            ->addCritical('testing a critical message!');

        self::assertTrue($spy->sent);
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_should_really_send_message() {
        $cfg = [
            Config::KEY_API_KEY => getenv('SEVEN_API_KEY_SANDBOX'),
            Config::KEY_FLASH => 1,
            Config::KEY_FOREIGN_ID => 'live',
            Config::KEY_FROM => 'Monolog',
            Config::KEY_LABEL => 'live',
            Config::KEY_PERFORMANCE_TRACKING => 0,
            Config::KEY_TO => '+491716992343',
        ];
        $handler = Handler::buildFromArray($cfg);
        $logger = new Logger('example');

        $logger
            ->pushHandler($handler)
            ->addCritical('critical bug');
    }
}
