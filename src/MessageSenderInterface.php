<?php namespace Sms77\Monolog;

interface MessageSenderInterface {
    /**
     * @param string $message
     */
    public function send($message);
}
