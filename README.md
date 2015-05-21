# Password Generator

## Why?

- Existing password managers didn't suit the needs I had for this project, or required you to source your own external wordlist
- I've hacked Faker into a password generator for typeable passwords
    - The project I'm using this in requires secure, generated passwords that are easy to type

## Installation

Requires PHP5.4+ (only tested on 5.6 though)

```
composer require kieranajp/password-generator
```

## Example usage

See example.php

## Todo

- [ ] Documentation that doesn't suck
- [x] PSR-2 compliance
- [ ] Test coverage
- [ ] Test on different PHP versions
- [ ] Ability to change the password format
- [ ] Ability to swap out word lists