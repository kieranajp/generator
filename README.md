# Password Generator

## Why?

- Existing password managers didn't suit the needs I had for this project, or required you to source your own external wordlist
- I've hacked Faker into a password generator for typeable passwords
    - The project I'm using this in requires secure, generated passwords that are easy to type

## Installation

Requires PHP5.3.3+ (though the unit tests only run on 5.4+ so that's highly recommended)

```
composer require kieranajp/password-generator
```

## Example usage

To set a password format, the can now be easily done using the following keywords:
- word 
- num 
- symbol
seperated by a ":" delimiter.

```
$g->setFormat("word:num:symbol")
```

See example.php

## Todo

- [ ] Documentation that doesn't suck
- [x] PSR-2 compliance
- [x] Test coverage
- [x] Test on different PHP versions
- [x] Ability to change the password format
- [ ] Ability to swap out word lists
