<?php

class AccessClass extends AccessBase
{
	public function __construct($object)
	{
		parent::__construct($object, new ReflectionClass($object));
	}

	public function __call($name, $args)
	{
		$a = new AccessMethod($this->reflection->getName(), $name);
		$a->asInstance($this->instance);
		return $a->callArgs($args);
	}

	public function & __get($name)
	{
		$a = new AccessProperty($this->reflection->getName(), $name);
		$a->asInstance($this->instance);
		$tmp = $a->get($name);
		return $tmp;
	}

	public function __set($name, $value)
	{
		$a = new AccessProperty($this->reflection->getName(), $name);
		$a->asInstance($this->instance);
		return $a->set($value);
	}

}
