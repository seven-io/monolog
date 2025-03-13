<img src="https://www.seven.io/wp-content/uploads/Logo.svg" width="250" />

# Monolog Handler

Send log entries by SMS or make text-to-speech calls via [seven](https://www.seven.io).

## Installation
This package can be installed via composer.

```bash
composer require seven.io/monolog
```

## Usage

```php
use Seven\Monolog\Config;
use Seven\Monolog\Handler;
use Monolog\Logger;

$logger = Logger('demo');
$apiKey = getenv('SEVEN_API_KEY'); // seven API key required for sending

// SMS
$cfg = [
    Config::KEY_API_KEY => $apiKey,
    Config::KEY_FLASH => 0, // 0 or 1
    Config::KEY_FOREIGN_ID => 'MyForeignID', // optional foreign ID max 64 chars consisting of a-zA-Z0-9, ._@
    Config::KEY_FROM => 'Monolog', // optional sender - max 11 alphanumeric or 16 numeric characters
    Config::KEY_JSON => 0, // 0 or 1
    Config::KEY_LABEL => 'MyLabel', // optional label max 100 chars consisting of a-zA-Z0-9, ._@
    Config::KEY_PERFORMANCE_TRACKING => 0, // 0 or 1
    Config::KEY_TO => '+491234567890', // recipient(s) separated by comma
];
$handler = Handler::buildFromArray($cfg);
$logger
    ->pushHandler($handler)
    ->addCritical('critical bug');

// text-to-speech call
$cfg = [
    Config::KEY_API_KEY => $apiKey,
    Config::KEY_APP => Config::APP_VOICE,
    Config::KEY_FROM => '+4901234567890', // optional sender - must be verified or a shared inbound number
    Config::KEY_JSON => 0, // 0 or 1
    Config::KEY_TO => '+491234567890', // recipient(s) separated by comma
];
$handler = Handler::buildFromArray($cfg);
$logger
    ->pushHandler($handler)
    ->addCritical('critical bug');
```

### Support

Need help? Feel free to [contact us](https://www.seven.io/en/company/contact/).

[![MIT](https://img.shields.io/badge/License-MIT-teal.svg)](LICENSE)
