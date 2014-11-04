# Validator

HylianShield will barricade nasty data from your application. It tries to solve this by supplying powerful validators.

Data validation is not just about keeping your application secure. Although it should help you determine if data was malformed, it will also help you write stricter and less buggy code.

We recognize that PHP has no proper type hinting for scalar data types. This is a huge pain to deal with, since arguments that should accept scalar values, actually will support the `mixed` data type, meaning any and all data you find laying around in your application can be sent through there.

## User guide

- [How to play: An installation manual](INSTALLATION.md)
- [API Docs: A completely generated API documentation](http://hylianshield.github.io/validator/)
- [Use case: An example of the HylianShield validator in action](USECASE.md)
- [Reference: An overview of the available validators and their arguments](REFERENCE.md)
- [Debugging: Add some context and meaning to failing validations](DEBUGGING.md)
- [Frameworks: 1-2-3-go. Direct integration with your framework](FRAMEWORKS.md)
- [Changelog: What changed in the last versions?](CHANGELOG.md)
- [Contributing: How do I add a validator in the mix?](CONTRIBUTING.md)

## Support

To a fault, we support PHP 5.3, 5.4 and 5.5, which are all unit tested using Travis CI.

## TL;DR

HylianShield [*validator*](http://hylianshield.github.io/validator/) is an *awesome* project, works on your [*framework*](FRAMEWORKS.md) or *custom* code base. It uses [*composer*](INSTALLATION.md) as dependency manager, is hosted on [*packagist*](https://packagist.org/packages/hylianshield/validator). [#TravisCI](https://travis-ci.org/HylianShield/validator) #PHP5.3 #PHP5.4 #PHP5.5

[![Build Status](https://travis-ci.org/HylianShield/validator.png?branch=master)](https://travis-ci.org/HylianShield/validator) [![Latest Stable Version](https://poser.pugx.org/hylianshield/validator/v/stable.png)](https://packagist.org/packages/hylianshield/validator)
