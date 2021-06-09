<?php namespace Sms77\Monolog\Tests;

use Sms77\Monolog\MessageSenderInterface;

class MessageSenderMock implements MessageSenderInterface {
    public $sent;

    public function send($message) {
        $this->sent = true;
    }
}
