# sitedyno/irc-format-stripper
[![Build Status](https://secure.travis-ci.org/sitedyno/irc-format-stripper.png?branch=master)](https://travis-ci.org/sitedyno/irc-format-stripper)
[![codecov](https://codecov.io/gh/sitedyno/irc-format-stripper/branch/master/graph/badge.svg)](https://codecov.io/gh/sitedyno/irc-format-stripper)

Library to strip IRC format codes from strings.

## Install

The recommended method of installation is [through composer](https://getcomposer.org).

`php composer.phar require sitedyno/irc-format-stripper`

## Configuration

There is no configuration at the moment.

## Usage Example

```php
use Sitedyno\Irc\Format\Stripper;

$stripper = new Stripper;
$testMessage = "\x0301This text is black in IRC";
echo $testMessage;
// Outputs: 01This text is black in IRC
$strippedMessage = $stripper->strip($testMessage);
echo $strippedMessage;
// Outputs: This text is black in IRC
```
## Monolog Processor Example

```php
use Sitedyno\Irc\Format\Stripper;

$stripper = new Stripper;
$testMessage = "\x0301This text is black in IRC";
echo $testMessage;
// Outputs: 01This text is black in IRC
$streamHandler = new \Monolog\Handler\StreamHandler(
    'mylog.log',
    \Monolog\Logger::DEBUG
);
$logger = new \Monolog\Logger(
    'mylog',
    [$streamHandler]
);
$logger->pushProcessor(function($record) use ($stripper) {
    $record['message'] = $stripper->strip($record['message']);
    return $record;
});
$logger->info($testMessage);
// Outputs to mylog.log: [2016-12-25 22:00:52] mylog.INFO This text is black in IRC
```
## Testing

To run the unit test suite:

```
curl -s https://getcomposer.org/installer | php
php composer.phar install
./vendor/bin/phpunit
```

## License

Released under the MIT License. See `LICENSE.md`.
