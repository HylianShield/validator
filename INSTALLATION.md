# Installation

Installing the HylianShield validator should be fairly painless and we support multple installation methods.

## Composer

```bash
php composer.phar require hylianshield/validator "~0"
```

## Github / Contributors

```bash
git clone git@github.com:hylianshield/validator.git
```

And then add /path/to/validator/src in your autoloader as root for `\HylianShield\Validator`.
Note that this is not necessary if you follow the developer instructions.

### Developers

After forking and cloning the repo (you replaced hylianshield with your own name in the previous step),
one can install the developer environment.

```bash
make install-development
```

And when updating your environment to the latest version, simply use:

```bash
make update-development
```

Note that `make install-development` will automatically install a [`pre-commit` hook](http://git-scm.com/book/en/Customizing-Git-Git-Hooks#Client-Side-Hooks) that runs the testsuite before committing your code.

See [the contributing guide](CONTRIBUTING.md) for more information.

## Download ZIP

Download the [master zip archive](https://github.com/HylianShield/validator/archive/master.zip) and extract it in your third party / vendor directory.
Then add /path/to/validator/src in your autoloader as root for `\HylianShield\Validator`.

# Frameworks

In the near future, we will supply a direct bridge between your framework and the HylianShield validators.
Those bridges will be hosted in their own projects and need their own installation.
[For more information, you can read our frameworks documentation](FRAMEWORKS.md)
