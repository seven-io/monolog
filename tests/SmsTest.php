<?php namespace Sms77\Monolog\Tests;

use Monolog\Logger;
use PHPUnit_Framework_TestCase;
use Sms77\Monolog\Config;
use Sms77\Monolog\Handler;

class SmsTest extends PHPUnit_Framework_TestCase {
    /** @test */
    public function it_should_act_like_sending_a_message() {
        $spy = new MessageSenderMock;

        (new Logger('test'))
            ->pushHandler(new Handler($spy, new Config([
                Config::KEY_API_KEY => getenv('SMS77_DUMMY_API_KEY'),
                Config::KEY_FROM => 'MonologTest',
                Config::KEY_TO => '+491716992343',
            ])))
            ->addCritical('testing a critical message!');

        self::assertTrue($spy->sent);
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_should_really_send_message() {
        (new Logger('example'))
            ->pushHandler(Handler::buildFromArray([
                Config::KEY_API_KEY => getenv('SMS77_API_KEY'),
                Config::KEY_FROM => 'Monolog',
                Config::KEY_TO => '+491716992343',
            ]))
            ->addCritical('critical bug');
    }
}
