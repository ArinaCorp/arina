# Arina

## DIRECTORY STRUCTURE

```
src/ 				source code
vendors				3rd-party packages
runtime/            contains files generated during runtime
tests/              contains various tests for the basic application
web/				the entry script and Web resources
```

## REQUIREMENTS

The minimum requirement by this project that your Web server supports PHP 5.4.0. with extensions:
- mbstring
- curl
- pdo
- json

## INSTALL

### Vendors

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

To install vendors run
```
composer global require "fxp/composer-asset-plugin:~1.1.1"
composer install -o
```
If you use composer.phar as local file, you have to use commands begin with `php composer.phar`

or

`make vendors-install`

### .env

Next create `.env` file:

Copy from example: `cp .env.example` and set custom vars. 

Or run `make env`

### Create DB

You can create DB manual or use command `make db-create db-name=<name_of_db>`

### Run migrations

You have to run:

`php yii modules-migrate` or `make db-migrate`

## Usage guide

If you want to add this project to remote repository using PhpStorm, follow next steps

    1. At the end of installing project remove current VCS in composer dialog.
    2. In PhpStorm -> VCS -> Enable Version Control Integration
    3. Add all files to git
    4. VCS -> Commit and Push
    5. Before Push phase define your repository
