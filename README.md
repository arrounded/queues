# Arrounded/queues

> An optionated helper for dealing with queues

[![Build Status](http://img.shields.io/travis/arrounded/queues.svg?style=flat-square)](https://travis-ci.org/arrounded/queues)
[![Latest Stable Version](http://img.shields.io/packagist/v/arrounded/queues.svg?style=flat-square)](https://packagist.org/packages/arrounded/queues)
[![Total Downloads](http://img.shields.io/packagist/dt/arrounded/queues.svg?style=flat-square)](https://packagist.org/packages/arrounded/queues)
[![Scrutinizer Quality Score](http://img.shields.io/scrutinizer/g/arrounded/queues.svg?style=flat-square)](https://scrutinizer-ci.com/g/arrounded/queues/)
[![Code Coverage](http://img.shields.io/scrutinizer/coverage/g/arrounded/queues.svg?style=flat-square)](https://scrutinizer-ci.com/g/arrounded/queues/)

## Install

Via Composer

``` bash
$ composer require arrounded/queues
```

## Usage

First add the module's service provider and facade to config/app.php:

```php
Arrounded\Queues\ServiceProvider::class
```

```php
'Queues' => Arrounded\Queues\Facades\Queues::class,
```

Now you can start using the helper in your application code via the Facade:

### Pushing jobs

```php
Queues::on('foo')->uses(Foobar::class)->push()
```

This will push a job on the `local_foo_normal` queue.

__Priorities__

```php
Queues::on('foo')->uses(Foobar::class)->priority(Queues::PRIORITY_HIGH)->push();
```

This will push a job on the `local_foo_high` queue.

__Passing a payload__

```php
Queues::on('foo')->uses(Foobar::class)->with([
	'bar' => 'foo'
])->push();
```

This will push a job on the `local_foo_normal` queue with a `{'bar': 'foo'}` payload

__Delaying execution__

```php
Queues::on('foo')->uses(Foobar::class)->delay(10)->push();
```

This will delay the execution of the job by 10 seconds. 

### Prefixing queue names

The default behavior is to prefix all queues with the current app environment. If you want to overwrite this default on an application level, you can do it in your own
ServiceProvider:

```php
$this->app['queues']->setPrefix('foobar') // foobar_foo_normal
```

### Dependency Injection

You can also use dependency injection:

```php
use Arrounded\Queues\Queues;

class FooService 
{
	public function __construct(Queues $queues)
	{
		$this->queues = $queues;
	}
```

## Testing

``` bash
$ composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
