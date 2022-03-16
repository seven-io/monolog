![](https://www.sms77.io/wp-content/uploads/2019/07/sms77-Logo-400x79.png "sms77 Logo")

# Monolog Handler

Send log entries by SMS via [sms77](https://www.sms77.io).

## Installation

```bash
composer require sms77/monolog
```

## Usage

```php
use Sms77\Api\Client;
use Sms77\Monolog\Config;
use Sms77\Monolog\Handler;
use Monolog\Logger;

(new Logger('demo'))
    ->pushHandler(Handler::buildFromArray([
        Config::KEY_API_KEY => getenv('SMS77_API_KEY'), // sms77 API key required for sending
        Config::KEY_DEBUG => 0, // 0 or 1
        Config::KEY_FROM => 'Monolog', // optional sender - max 11 alphanumeric or 16 numeric characters
        Config::KEY_NO_RELOAD => 0, // 0 or 1
        Config::KEY_PERFORMANCE_TRACKING => 0, // 0 or 1
        Config::KEY_TO => '+491716992343', // recipient(s) separated by comma
    ]))
    ->addCritical('critical bug');
```

### Support

Need help? Feel free to [contact us](https://www.sms77.io/en/company/contact/).

[![MIT](https://img.shields.io/badge/License-MIT-teal.svg)](LICENSE)
