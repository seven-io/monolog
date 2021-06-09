![Sms77.io Logo](https://www.sms77.io/wp-content/uploads/2019/07/sms77-Logo-400x79.png "Sms77.io Logo")

# Monolog Handler

Send log entries by SMS via [Sms77](https://www.sms77.io).

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
        Config::KEY_API_KEY => getenv('SMS77_API_KEY'),
        Config::KEY_FROM => 'Monolog',
        Config::KEY_TO => '+491716992343',
    ]))
    ->addCritical('critical bug');
```

### Support

Need help? Feel free to [contact us](https://www.sms77.io/en/company/contact/).

[![MIT](https://img.shields.io/badge/License-MIT-teal.svg)](./LICENSE)
