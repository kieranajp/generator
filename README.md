# Password Generator

[![codecov](https://codecov.io/gh/kieranajp/generator/branch/master/graph/badge.svg)](https://codecov.io/gh/kieranajp/generator)

A teeny library to generate memorable yet secure passwords.

## Why?

- Existing password managers didn't suit the needs I had for this project, or required you to source your own external wordlist
- I've hacked Faker into a password generator for typeable passwords
    - The project I'm using this in requires secure, generated passwords that are easy to type

## Installation

Requires PHP 7.0+. Install with Composer.

```sh
$ composer require kieranajp/password-generator
```

If you require PHP 5.3 - 5.6 support, install v1.

## Example usage

To quickly try this out, you can run `php example.php`. This file contains the basic usage.

```php
require 'vendor/autoload.php';
$g = new \Kieranajp\Generator\Generator();
$g->generate(); // [ "Reagan467$Lera^" ]
$g->generate(2); // [ "Christina835$Frami$", "Terrance103:Evie." ]
```

By default, passwords are of the following format: `word - number - symbol - word - symbol`.  This can easily be changed as follows:

```php
$g->setFormat("word:num:symbol")
```

The default list of symbols is easy to type by a less-savvy computer user on a standard QWERTY keyboard. Other symbols can be added with `$g->addSymbol('🤡')` and removed with `$g->removeSymbol('🤡')`.
