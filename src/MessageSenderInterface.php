<?php namespace Seven\Monolog;

interface MessageSenderInterface {
    /**
     * @param string $message
     */
    public function send($message);
}
