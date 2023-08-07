<?php namespace Seven\Monolog\Tests;

use Seven\Monolog\MessageSenderInterface;

class MessageSenderMock implements MessageSenderInterface {
    public $sent;

    public function send($message) {
        $this->sent = true;
    }
}
