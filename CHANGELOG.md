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
