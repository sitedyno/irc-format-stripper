# sitedyno/irc-format-stripper
[![Build Status](https://secure.travis-ci.org/sitedyno/irc-format-stripper.png?branch=master)](https://travis-ci.org/sitedyno/irc-format-stripper)

Library to strip IRC format codes from strings.

## Install

The recommended method of installation is [through composer](https://getcomposer.org).

`php composer.phar require sitedyno/irc-format-stripper`

## Configuration

There is no configuration at the moment.

## Usage Example

```php
use Sitedyno\Irc\Format;

$testMessage = "\x0301This text is black in IRC";
$strippedMessage = new (Stripper)->strip($testMessage);
echo $strippedMessage;
// Outputs: This text is black in IRC
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
