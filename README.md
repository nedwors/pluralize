# Pluralize

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nedwors/pluralize.svg?style=flat-square)](https://packagist.org/packages/nedwors/pluralize)
[![Build Status](https://img.shields.io/travis/nedwors/pluralize/master.svg?style=flat-square)](https://travis-ci.org/nedwors/pluralize)
[![Quality Score](https://img.shields.io/scrutinizer/g/nedwors/pluralize.svg?style=flat-square)](https://scrutinizer-ci.com/g/nedwors/pluralize)
[![Total Downloads](https://img.shields.io/packagist/dt/nedwors/pluralize.svg?style=flat-square)](https://packagist.org/packages/nedwors/pluralize)

A Laravel package that provides null-safe pluralization. Although made with the Blade templating engine in mind, it can be used anywhere.

From this:

```php
@isset($pizzas)

{{ $pizzas->count() }} {{ Str::plural('Pizza') }}

@else

-

@endisset
```

To this:

```php
{{ pluralize('Pizza', $pizzas) }}
```

#### Ok... That's cool? I suppose?...
It has some real power backing it up.

How about this:

```php
pluralize('Pizza', $pizzas)->or('...')
```

Or even this:

```php
pluralize('Pizza', $pizzas)
 
    ->as(fn($plural, $count) => "There is|are $count $plural")
    ->or(fn($plural) => "$plural is not set")
```

## TOC

- [Installation](#installation)
    * [Setup](#setup)
- [Introduction](#introduction)
    * [Core Principles](#core-principles)
    * [Helper vs Class](#helper-vs-class)
- [Features](#features)
    * [Create](#create)
    * [Parse](#parse)

## Installation

You can install the package via composer

```bash
composer require nedwors/pluralize
```
### Setup
Minimal, if any, setup is required. The package is ready to work out of the box with sensible defaults. 

The default outputs are shown below. The 1st comment represents the output when `$pizzas` has a count of 10; the 2nd represents when `$pizzas` is null:

```php
pluralize('Pizza', $pizzas)

// 10 Pizzas
// -
```
However you are free to [configure](#configuration) these defaults, and fine tune the system further.

## Introduction

### Helper vs Class
This documentation's examples are based on the helper function `pluralize()`. But, the underlying class can also be used instead. For instance, the following are equivalent:

```php
pluralize('Dog', $dogs, '...')

Pluralize::this('Dog')->from($dogs)->or('...')
```
For every feature discussed, they are available from either invocation.

## Features

The default outputs of the package are:


```php
pluralize('Pizza', $pizzas)

// When $pizzas = null, '-'
// When $pizzas = 10, '10 Pizzas'
```

Supports `null` fallbacks:

```php
pluralize('Pizza', $pizzas)
    ->or('Oops, pizzas not found')

// When $pizzas = null, 'Oops, pizzas not found'
```

```php
pluralize('Pizza', $pizzas)
    ->over(0)
    ->as(fn($plural, $count) => "You have $count $plural")
    ->or('Oops, you have no pizzas')

// When $pizzas = null, 'Oops, you have no pizzas'
// When $pizzas->count() = 1, 'You have 1 pizza'
// When $pizzas->count() = 2, 'You have 2 pizzas'
```

```php
pluralize('Pizza', $pizzas)
    ->as(fn($plural, $count) => "There is|are $count $plural")

// When $pizzas->count() = 1, 'There is 1 pizza'
// When $pizzas->count() = 2, 'There are 2 pizzas'
```

## Usage

``` php
// Usage description here
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email nedwors@gmail.com instead of using the issue tracker.

## Credits

- [Sam Rowden](https://github.com/nedwors)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
