# Environment Synchronization

<p align="center">
    <img src="/.github/images/logo.png?raw=true" alt="Env Sync"/>
</p>

[![StyleCI Status][badge_styleci]][link_styleci]
[![Github Workflow Status][badge_build]][link_build]
[![Coverage Status][badge_coverage]][link_scrutinizer]
[![Scrutinizer Code Quality][badge_quality]][link_scrutinizer]

[![Stable Version][badge_stable]][link_packagist]
[![Unstable Version][badge_unstable]][link_packagist]
[![Total Downloads][badge_downloads]][link_packagist]
[![License][badge_license]][link_license]

## Table of contents

* [Installation](#installation)
* [How to use](#how-to-use)
    * [Laravel / Lumen Frameworks](#laravel--lumen-frameworks)
    * [Other using](#other-using)
    * [Example](#example)

## Installation

To get the latest version of `Environment Synchronization`, simply require the project using [Composer](https://getcomposer.org):

```bash
$ composer require andrey-helldar/env-sync --dev
```

Or manually update `require-dev` block of `composer.json` and run `composer update`.

```json
{
    "require-dev": {
        "andrey-helldar/env-sync": "^1.2"
    }
}
```

## How to use

> Note
> This package scans files with `*.php`, `*.json`, `*.yml`, `*.yaml` and `*.twig` extensions in the specified folder, receiving from them calls to the `env` and `getenv` functions.
> Based on the received values, the package creates a key-value array. When saving, the keys are split into blocks by the first word before the `_` character.

### Laravel / Lumen Frameworks

Just execute the `php artisan env:sync` command.

You can also specify the invocation when executing the `composer update` command in `composer.json` file:

```json
{
    "scripts": {
        "post-update-cmd": [
            "php artisan env:sync"
        ]
    }
}
```

Now, every time you run the `composer update` command, the environment settings file will be synchronized.

If you want to force the stored values, you can change the configuration file by publishing it with the command:

```bash
php artisan vendor:publish --provider="Helldar\EnvSync\ServiceProvider"
```

Now you can change the file `config/env-sync.php`.

### Other using

To call a command in your application, you need to do the following:

```php
use Helldar\EnvSync\Services\Compiler;
use Helldar\EnvSync\Services\Finder;
use Helldar\EnvSync\Services\Parser;
use Helldar\EnvSync\Services\Stringify;
use Helldar\EnvSync\Services\Syncer;
use Helldar\EnvSync\Support\Config;
use Symfony\Component\Finder\Finder as SymfonyFinder;

protected function syncer(): Syncer
{
    $parser    = new Parser();
    $stringify = new Stringify();
    $config    = new Config();
    $compiler  = new Compiler($stringify, $config);
    $finder    = new Finder(SymfonyFinder::create());

    return new Syncer($parser, $compiler, $finder);
}

protected function sync()
{
    $this->syncer()
       ->path(__DIR__)
       ->filename('.env.example')
       ->store();
}
```

If you want to define default values or specify which key values should be stored, you need to pass an array to the constructor of the `Config` class:

```php
use Helldar\EnvSync\Services\Compiler;
use Helldar\EnvSync\Services\Finder;
use Helldar\EnvSync\Services\Parser;
use Helldar\EnvSync\Services\Stringify;
use Helldar\EnvSync\Services\Syncer;
use Helldar\EnvSync\Support\Config;
use Symfony\Component\Finder\Finder as SymfonyFinder;

protected function syncer(): Syncer
{
    $parser    = new Parser();
    $stringify = new Stringify();
    $config    = new Config($this->config());
    $compiler  = new Compiler($stringify, $config);
    $finder    = new Finder(SymfonyFinder::create());

    return new Syncer($parser, $compiler, $finder);
}

protected function config(): array
{
    return require realpath(__DIR__ . '/your-path/your-config.php');
}
```

You can also suggest your implementation by sending a PR. We will be glad 😊

[badge_build]:          https://img.shields.io/github/workflow/status/andrey-helldar/env-sync/native?style=flat-square

[badge_downloads]:      https://img.shields.io/packagist/dt/andrey-helldar/env-sync.svg?style=flat-square

[badge_license]:        https://img.shields.io/packagist/l/andrey-helldar/env-sync.svg?style=flat-square

[badge_coverage]:       https://img.shields.io/scrutinizer/coverage/g/andrey-helldar/env-sync.svg?style=flat-square

[badge_quality]:        https://img.shields.io/scrutinizer/g/andrey-helldar/env-sync.svg?style=flat-square

[badge_stable]:         https://img.shields.io/github/v/release/andrey-helldar/env-sync?label=stable&style=flat-square

[badge_styleci]:        https://styleci.io/repos/333111450/shield

[badge_unstable]:       https://img.shields.io/badge/unstable-dev--main-orange?style=flat-square

[link_build]:           https://github.com/andrey-helldar/env-sync/actions

[link_license]:         LICENSE

[link_packagist]:       https://packagist.org/packages/andrey-helldar/env-sync

[link_scrutinizer]:     https://scrutinizer-ci.com/g/andrey-helldar/env-sync/?branch=main

[link_styleci]:         https://github.styleci.io/repos/333111450
