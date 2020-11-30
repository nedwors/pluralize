# Pluralize - A Laravel string helper

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nedwors/pluralize.svg?style=flat-square)](https://packagist.org/packages/nedwors/pluralize)
[![Build Status](https://img.shields.io/travis/nedwors/pluralize/master.svg?style=flat-square)](https://travis-ci.org/nedwors/pluralize)

A Laravel package that provides null-safe, meaningful pluralization of strings. 

Go from this...

```php
@if($pizzas)

{{ $pizzas->count() }} {{ Str::plural('Pizza', $pizzas->count()) }}

@else

-

@endif

// 2 Pizzas
// -
```

To this...

```php
{{ pluralize('Pizza', $pizzas) }}

// 2 Pizzas
// -
```
Nice eh?

No more `count($me)`, `$me->count()` or `$me->total()`... Just pass in your variable and have it counted for you.

No need to repeat `{{ $lemons->count() }} {{ Str::plural('Lemon', $lemons->count()) }}` over and over everywhere in your views. Just a unified format across your app.

No need to think anymore about whether the variable is `null` and what to do if so, just a clean `-`, or [whatever you want](#or).

> The stuff of nightmares...
>
> `Call to a member function count() on null`

## Docs

- [Installation](#installation)
    * [Setup](#setup)
- [Introduction](#introduction)
    * [Helper vs Class](#helper-vs-class)
    * [Usage](#usage)
- [Features/API](#features/api)
    * [Pluralize](#pluralize)
    * [This](#this)
    * [From](#from)
    * [Or](#or)
    * [As](#as)
- [Configuration](#configuration)
    * [Default Bindings](#default-bindings)
    * [Specific Bindings](#specific-bindings)
    * [Driver](#driver)

## Installation

You can install the package via composer

```bash
composer require nedwors/pluralize
```
### Setup
Minimal, if any, setup is required. The package is ready to work out of the box with sensible defaults. 

The defaults are shown below. The 1st comment represents the returned string when `$pizzas` has a count of 10; the 2nd represents when `$pizzas` is null:

```php
pluralize('Pizza', $pizzas)

// 10 Pizzas
// -
```
However you are free to [configure](#configuration) these defaults, and fine tune the system further.

## Introduction

### Helper vs Class
This documentation's examples are based on the helper function `pluralize()`. However, the underlying class can be used just the same for every feature. For instance, the following are equivalent:

```php
pluralize('Dog', $dogs, '...')

pluralize('Dog')->from($dogs)->or('...')

Pluralize::this('Dog')->from($dogs)->or('...')
```

### Usage
The underlying class in the package implements the `Stringable` interface, so in your Blade views it works just by calling the helper function or class. 
```php
pluralize('Dog', $dogs)
```

Outside your views, do any of the following
```php
pluralize('Dog', $dogs)() // Invoke

pluralize('Dog', $dogs)->go() // Call the go() method

(string) pluralize('Dog', $dogs) // Cast the type
```

## Features/API

### Pluralize

Pluralize has 4 main functions:

```php
Pluralize::this(...)->from(...)->as(...)->or(...)
```

The `pluralize()` helper function has 4 parameters that map to these functions:

```php
pluralize('this', 'from', 'or', 'as')
```
You'll notice that `or` is listed before `as` in the parameter list. This helps with usability for most use cases.

It can be accessed fluently too

```php
pluralize(...)->from(...)->as(...)->or(...)
```

### This
The singular form of the string you wish to be pluralized.


```php
// The first argument to the helper function

pluralize('Rocket')
```

### From
The count/total/sum you wish to pluralize the string from.

The variable you pass can be an `int`, an `array`, a [`Collection`](https://laravel.com/docs/8.x/collections), a [`LengthAwarePaginator`](https://laravel.com/docs/8.x/pagination#displaying-pagination-results) or a [`Paginator`](https://laravel.com/docs/8.x/pagination#displaying-pagination-results).

```php
// The second argument to the helper function

pluralize('Rocket', $rockets)

// Or, as a method

pluralize('Rocket')->from($rockets)
```
   
> By this point, it's worth noting that you are good to go. Nothing more  is required for most uses.
> 
> Pluralize does provide extra features for more flexibility. These are detailed below, as well as [configuration](#configuration).

### Or

The string to display if the [count](#from) is `null`.

This is not required. If not provided, it will simply defer to the default `-`.

```php
// The third argument to the helper function

pluralize('Rocket', $rockets, '...')

// Or, as a method

pluralize('Rocket', $rockets)->or('...')
```

In addition to providing a `string`, you can pass a `Closure` that will receive the pluralized form of the word.

```php
pluralize('Rocket', $rockets)
    ->or(fn($plural) => "Oops, $plural is not defined")

// Oops, Rockets is not defined
```
##### Why would I ever write a `Closure` when I can just type `Oops, Rockets is not defined`?

It's true, it's probably unlikely. But at least the power is there if needed. For instance, perhaps you want to grab the `Auth::user()`, or give context with the current time.

However, the power of using a `Closure` really comes when [configuring](#configuration) the package.

### As

The format to display the pluralization.

This is not required. If not provided, it will simply defer to the default `n items`.

The most useful means is declaring this as a `Closure`, which is passed the plural form of the string and the count.

```php
// The fourth argument to the helper function

pluralize('Rocket', $rockets, '...', fn($plural, $count) => "$plural: $count")

// Or, probably more usefully, as a method

pluralize('Rocket', $rockets)->as(fn($plural, $count) => "$plural: $count")

// Rockets: 10
```
How about if you wanted something along the lines of `there are 10 Rockets`? When there's 1 `Rocket`, you'll end up with `There are 1 Rocket`... Hmm. Well, the pipe operator is your friend! Simply declare the singular output to the left, the plural to the right.
```php
pluralize('Rocket', $rockets)
    ->as(fn($plural, $count) => "There is|are $count $plural")

// There is 1 Rocket
// There are 2 Rockets
```
Now, you can pass a `string` if you really, really want to...
```php
pluralize('Rocket', $rockets)
    ->as('Not sure how many, but you have some Rockets')

// Now sure how many, but you have some Rockets
```
...but this is most useful when used with your [configuration](#configuration).

## Configuration
You can easily configure different aspects of the package. This is all done via the `Pluralize` class in your service provider.
### Default Bindings
You can declare the default formats for use in your app by calling `Pluralize::bind()` with no arguments
```php
// In your service provider's boot() method
Pluralize::bind()
    ->output(fn($plural, $count) => "$plural: $count")
    ->fallback('...')

// In your view
pluralize('Car', $cars)

// When $cars = null, ...
// When $cars = 10, Cars: 10
```

> The default Output is `n items`. The default Fallback is `-`.

### Specific Bindings
You can bind to the word you want to pluralize for specific formatting

```php
// In your service provider's boot() method
Pluralize::bind('Hotdog')
    ->output(fn($plural, $count) => "Yum, $count hotdogs!")

// In your view
pluralize('Car', $cars) // 10 Cars
pluralize('Hotdog', $hotdogs) // Yum, 10 hotdogs!
```
You can set an arbitrary key to be referred to at time of render

```php
// In your service provider's boot() method
Pluralize::bind('ye-olde')
    ->fallback(fn($plural) => "Thou hath not declared $plural")

// In your view
pluralize('Robot', null) // -
pluralize('DeLorean', null)->or('ye-olde') // Thou hath not declared DeLoreans
```

### Driver
The package uses the Laravel [`Str::plural()`](https://laravel.com/docs/8.x/helpers#method-str-plural) method for pluralizing the strings passed in. You are free to use your own driver if desired. This would be especially useful for non-english languages.

Write your custom driver implementing the `Pluralization` interface. This defines one method, `run()`, which is passed the singular string and the current count. Here's the current implementation:

```php
public function run(string $string, $count): string
{
    return Str::plural($string, $count);
}
```
Then set this as the desired driver in the `boot()` method of your service provider

```php
Pluralize::driver(NewDriver::class)
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
