<p align="center">
  <img src="https://www.seven.io/wp-content/uploads/Logo.svg" width="250" alt="seven logo" />
</p>

<h1 align="center">seven Handler for Monolog</h1>

<p align="center">
  Forward <a href="https://github.com/Seldaek/monolog">Monolog</a> log entries as SMS or text-to-speech calls via the seven gateway.
</p>

<p align="center">
  <a href="LICENSE"><img src="https://img.shields.io/badge/License-MIT-teal.svg" alt="MIT License" /></a>
  <img src="https://img.shields.io/badge/Monolog-2%20|%203-blue" alt="Monolog 2 | 3" />
  <img src="https://img.shields.io/badge/PHP-7.2%2B-purple" alt="PHP 7.2+" />
  <a href="https://packagist.org/packages/seven.io/monolog"><img src="https://img.shields.io/packagist/v/seven.io/monolog" alt="Packagist" /></a>
</p>

---

## Features

- **Monolog Handler** - Drop-in handler for any Monolog logger instance
- **SMS or Voice** - Choose between SMS and text-to-speech for the log channel

## Prerequisites

- PHP 7.2+
- A [seven account](https://www.seven.io/) with API key ([How to get your API key](https://help.seven.io/en/developer/where-do-i-find-my-api-key))

## Installation

```bash
composer require seven.io/monolog
```

## Usage

```php
use Seven\Monolog\Config;
use Seven\Monolog\Handler;
use Monolog\Logger;

$apiKey = getenv('SEVEN_API_KEY');
$logger = new Logger('demo');

// Forward WARNING-and-above entries as SMS
$cfg = new Config([
    'apiKey'     => $apiKey,
    'from'       => 'Logger',
    'recipients' => '+491234567890',
]);

$logger->pushHandler(new Handler($cfg, Logger::WARNING));
$logger->warning('Something is wrong!');
```

Switch the channel to voice by setting `type` to `voice` in the `Config`.

## Support

Need help? Feel free to [contact us](https://www.seven.io/en/company/contact/) or [open an issue](https://github.com/seven-io/monolog/issues).

## License

[MIT](LICENSE)
