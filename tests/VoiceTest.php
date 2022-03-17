<?php namespace Sms77\Monolog\Tests;

use Monolog\Logger;
use PHPUnit_Framework_TestCase;
use Sms77\Monolog\Config;
use Sms77\Monolog\Handler;

class VoiceTest extends PHPUnit_Framework_TestCase {
    /** @test */
    public function it_should_act_like_sending_a_message() {
        $spy = new MessageSenderMock;
        $cfg = new Config([
            Config::KEY_API_KEY => getenv('SMS77_DUMMY_API_KEY'),
            Config::KEY_APP => Config::APP_VOICE,
            Config::KEY_DEBUG => 1,
            Config::KEY_FROM => 'MonologTest',
            Config::KEY_JSON => 1,
            Config::KEY_TO => '+491771783130',
        ]);
        $handler = new Handler($spy, $cfg);
        $logger = new Logger('test');

        $logger
            ->pushHandler($handler)
            ->addCritical('testing a critical voice message!');

        self::assertTrue($spy->sent);
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_should_really_send_message() {
        $cfg = [
            Config::KEY_API_KEY => getenv('SMS77_API_KEY'),
            Config::KEY_APP => Config::APP_VOICE,
            Config::KEY_DEBUG => 0,
            Config::KEY_FROM => 'Monolog',
            Config::KEY_JSON => 0,
            Config::KEY_TO => '+491771783130',
        ];
        $handler = Handler::buildFromArray($cfg);
        $logger = new Logger('example');

        $logger
            ->pushHandler($handler)
            ->addCritical('critical bug');
    }
}
