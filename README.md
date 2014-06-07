# Validator

[![Build Status](https://travis-ci.org/HylianShield/validator.png?branch=master)](https://travis-ci.org/HylianShield/validator)
[![Latest Stable Version](https://poser.pugx.org/hylianshield/hylianshield/v/stable.png)](https://packagist.org/packages/hylianshield/validator)
[![Latest Unstable Version](https://poser.pugx.org/hylianshield/hylianshield/v/unstable.png)](https://packagist.org/packages/hylianshield/hylianshield)
[![Coverage Status](https://coveralls.io/repos/HylianShield/validator/badge.png)](https://coveralls.io/r/HylianShield/validator)

Everything between your input and app.

## Support

To a fault, we support PHP 5.3, 5.4 and 5.5, which are all unit tested using Travis CI.

## What is the HylianShield validator?

HylianShield will barricade nasty data from your application. It tries to solve this by supplying powerful validators.

Data validation is not just about keeping your application secure. Although it should help you determine if data was malformed, it will also help you write stricter and less buggy code.

We recognize that PHP has no proper type hinting for scalar data types. This is a huge pain to deal with, since arguments that should accept scalar values, actually will support the `mixed` data type, meaning any and all data you find laying around in your application can be sent through there.
