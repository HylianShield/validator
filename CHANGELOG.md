# v0.6.1

- Merged in hotfix from parent project: Validator\Financial\Bic updated for ISO 9362.
- Update `make composer` to install composer without the need of `curl`
- Improved documentation

# v0.6.0

- Split off the validator as a separate project
- Removed custom autoloader in favor of Composer
- Removed sluggish benchmarking suite

# v0.5.0

- Validator\Encoding\Base64

# v0.4.0

- Validator\OneOf\Many

# v0.3.0

- Added benchmarking suite and initial benchmarks
- Improved performance of the Range validator
- Conditionally improved performance of the String\Subset validator

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
