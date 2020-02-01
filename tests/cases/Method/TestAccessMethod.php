<?php

class TestAccessMethod extends Object
{
	private function _private()
	{
		return 1;
	}
	protected function _protected()
	{
		return 2;
	}
	public function _public()
	{
		return 3;
	}
	private static function privateStatic()
	{
		return 4;
	}
	protected static function protectedStatic()
	{
		return 5;
	}
	public static function publicStatic()
	{
		return 6;
	}

	private function args($a, $b, $c)
	{
		return func_get_args();
	}

	protected function argsProtected($a, $b, $c)
	{
		return func_get_args();
	}

	public $public;
	protected function setProperty($p)
	{
		$this->public = $p;
	}
}

class TestAccessMethod2 extends TestAccessMethod
{

}

class TestAccessMethodWithConstructor extends TestAccessMethod2
{
	public function __construct()
	{
		throw new Exception;
	}
	private static function privateStatic()
	{
		return 10;
	}
}

class TestAccessMethodWithDestructor extends TestAccessMethod2
{
	public function __destruct()
	{
		throw new Exception;
	}
	private static function privateStatic()
	{
		return 11;
	}
}

abstract class TestAccessMethodAbstract extends TestAccessMethod2
{
	private static function privateStatic()
	{
		return 12;
	}
}

class TestAccessMethodNonInstantiable extends TestAccessMethod2
{
	private static function privateStatic()
	{
		return 13;
	}
}
