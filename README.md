![](https://www.sms77.io/wp-content/uploads/2019/07/sms77-Logo-400x79.png "sms77 Logo")

# Monolog Handler

Send log entries by SMS or make text-to-speech calls via [sms77](https://www.sms77.io).

## Installation
This package can be installed via composer.

```bash
composer require sms77/monolog
```

## Usage

```php
use Sms77\Api\Client;
use Sms77\Monolog\Config;
use Sms77\Monolog\Handler;
use Monolog\Logger;

$logger = Logger('demo');
$apiKey = getenv('SMS77_API_KEY'); // sms77 API key required for sending

// SMS
$cfg = [
    Config::KEY_API_KEY => $apiKey,
    Config::KEY_DEBUG => 0, // 0 or 1
    Config::KEY_FLASH => 0, // 0 or 1
    Config::KEY_FOREIGN_ID => 'MyForeignID', // optional foreign ID max 64 chars consisting of a-zA-Z0-9, ._@
    Config::KEY_FROM => 'Monolog', // optional sender - max 11 alphanumeric or 16 numeric characters
    Config::KEY_JSON => 0, // 0 or 1
    Config::KEY_LABEL => 'MyLabel', // optional label max 100 chars consisting of a-zA-Z0-9, ._@
    Config::KEY_NO_RELOAD => 0, // 0 or 1
    Config::KEY_PERFORMANCE_TRACKING => 0, // 0 or 1
    Config::KEY_TO => '+491716992343', // recipient(s) separated by comma
];
$handler = Handler::buildFromArray($cfg);
$logger
    ->pushHandler($handler)
    ->addCritical('critical bug');

// text-to-speech call
$cfg = [
    Config::KEY_API_KEY => $apiKey,
    Config::KEY_APP => Config::APP_VOICE,
    Config::KEY_DEBUG => 0, // 0 or 1
    Config::KEY_FROM => '+491771783130', // optional sender - must be verified or a shared inbound number
    Config::KEY_JSON => 0, // 0 or 1
    Config::KEY_TO => '+491716992343', // recipient(s) separated by comma
];
$handler = Handler::buildFromArray($cfg);
$logger
    ->pushHandler($handler)
    ->addCritical('critical bug');
```

### Support

Need help? Feel free to [contact us](https://www.sms77.io/en/company/contact/).

[![MIT](https://img.shields.io/badge/License-MIT-teal.svg)](LICENSE)
