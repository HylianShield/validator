# v0.2.2

- Fix the numeric arrar validator unit test
- Improve performance of Range validators

# v0.2.1

Fix the Numeric array validator

# v0.2.0

Version 0.2.0 adds some new validators.

- Validator\CoreArray\Numeric
- Validator\OneOf
- Validator\String\Subset (abstract)
- Validator\String\Utf8\Mes1
- Validator\String\Utf8\Mes2
- Validator\String\Utf8\Mes3A
- Validator\String\Utf8\WordCharacter

# v0.1.1

Version 0.1.1 fixes behavior for the mutable ranges. Before, `0` was the default value
for range boundaries and therefore ignored when doing a length check.
This has been changed to `NULL` and henceforth constructors using 0 as a value will no
longer spawn results beyond that boundary.

## Bugfixes
- Change default value `$minLength` and `$maxLength` of mutable range constructors from
  `0` to `NULL`.

# v0.1.0

Initial release
