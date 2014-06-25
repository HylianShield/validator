# How to contribute

Third party input is essential for keeping us awesome. We want to keep contributing as easy as possible, by laying down a few ground rules.

## Getting started

* Make sure you have a [GitHub account](https://github.com/signup/free)
* Submit a ticket for your issue, assuming one does not already exist.
  * Clearly describe the issue including steps to reproduce when it is a bug.
  * Make sure you fill in the earliest version that you know has the issue.
* Fork the repository on GitHub
* Install the development version of HylianShield validator `make install-development`
  See [the installation manual](INSTALLATION.md) for more information

Note that `make install-development` will automatically install a [`pre-commit` hook](http://git-scm.com/book/en/Customizing-Git-Git-Hooks#Client-Side-Hooks) that runs the testsuite before committing your code.

## Making Changes

* Create a topic branch from where you want to base your work.
  * This is usually the master branch.
  * Only target release branches if you are certain your fix must be on that
    branch.
  * To quickly create a topic branch based on master; `git checkout -b
    fix/master/my_contribution master`. Please avoid working directly on the
    `master` branch.
* Ensure your dependencies are up to date `make update-development`
* Make commits of logical units.
* Check for unnecessary whitespace with `git diff --check` before committing.
* Make sure your commit messages are in the proper format.
* Make sure you have added the necessary tests for your changes.
* Run *all* tests to assure nothing else was accidentally broken `make test`.
  * Although Travis CI automatically runs a test against your pull, you should
    test locally before pushing / opening a pull request.
  * Make sure your code is backward compatible with PHP 5 >= PHP 5.3
* Make sure your code has a complete code coverage `make codecoverage`.
* DO NOT bump the version unless you are the project maintainer.
  * We want to prevent conflicts in the version number.
  * Version numbers will be bumped just prior to a new release.
  * We use [semantic versioning](http://semver.org/) and release accordingly.

## Submitting changes

* Push your changes to a topic branch in your fork of the repository.
* Submit a pull request to the repository in the HylianShield organization.
* After feedback has been given we expect responses within two weeks. After two
  weeks we may close the pull request if it isn't showing any activity.

## Updating the API documentation

To update the API documentation, hosted on hylianshield.github.io/validator, please
follow these steps:

* Create a fresh clone of the validator repo in a separate folder.
  * The documentation uses different composer dependencies and would ruin your
    local development environment. Additionally, your pre-commit hook would fail
    because there is no test suite installed for the API documentation.
  * The documentation branch shares no files with all other branches and is an orphan branch.
* Checkout to the API branch `git checkout gh-pages` and branch it off for a new
  new pull, with the current version in the branch name `git checkout gh-pages/v0.8.12`
* Ensure you have the PHP5 extension php5-xsl* installed.
* Ensure you have the graphviz* package installed.
* Either install or update the documentation dependencies using `make install`
  or `make update` respectively.
* Generate the new documentation using `make dox`.
* Commit the new documentation with at least the new version in the commit message.
* Push the changes to your repo and open a pull from yourrepo/gh-pages/vx.x.x to hylianshield/gh-pages/vx.x.x

(*) The name may differ based on your operating system. Ubuntu was assumed.
