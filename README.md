Access
======

Tool for access to private and protected members of object. It's handy for unit tests.


Property
--------

```php
class Foo
{
	private $foo;
}

$a = Access(new Foo, '$foo');

$a->set(3);
assert(3, $a->get());
```


Method
------

```php
class Foo
{
	private function foo()
	{
		return 4;
	}
}

$a = Access(new Foo, 'foo');

assert(4, $a->call());
```


Whole class
-----------

```php
class Foo
{
	private $foo;

	private function bar($plus)
	{
		return $this->foo + $plus;
	}
}

$a = Access(new Foo);

$a->foo = 10;
assert(10, $a->foo);
assert(11, $a->bar(1));
```


## Chaining objects and arrays

```php
class Foo
{
	private $foo;

	public function __construct()
	{
		$this->foo = ['arrayKey' => new Bar];
	}
}
class Bar
{
	private $bar;
}

$a = AccessProxy(new Foo);

$a->foo['arrayKey']->bar = 100;
assert($a->foo['arrayKey']->bar === 100);

assert($a->foo instanceof AccessProxy);
assert(is_array($a->foo->getInstance()));
assert($a->foo['arrayKey'] instanceof AccessProxy);
assert($a->foo['arrayKey']->getInstance() instanceof Bar);
```


Requirements
------------
Library has no external dependencies.

Fully works with PHP >= 5.3.2.
PHP >= 5.2.0 is supported partially (see below).

AccessMethod require PHP 5.3.2 or later.
AccessProperty require PHP 5.3.0 or later.

PHP >= 5.2.0 AND < 5.3.2 not supported:
 * Final classes.
 * Private methods.
 * Read private static property.
 * Write private property.
 * No limitation when extension [runkit](https://pecl.php.net/package/runkit) or [classkit](https://pecl.php.net/package/classkit) is provided.


Instalations
------------

### GitHub

Each version is tagged and available on [download page](https://github.com/PetrP/Access/tags).

```php
require_once __DIR__ . '/.../Access/src/Init.php';
```

### Composer & Packagist

Access is available on [Packagist](http://packagist.org/packages/PetrP/Access), where you can get it via [Composer](http://getcomposer.org).


Author
-------
Petr Procházka
http://petrp.cz petr@petrp.cz
