<?php

class AccessClass extends AccessBase
{
	private $methods = array();
	private $properties = array();

	public function __construct($object)
	{
		parent::__construct($object, new ReflectionClass($object));
	}

	public function __call($name, $args)
	{
		if (!isset($this->methods[$name]))
		{
			$a = new AccessMethod($this->reflection->getName(), $name);
			$this->methods[$name] = $a->asInstance($this->instance);
		}
		return $this->methods[$name]->callArgs($args);
	}

	public function & __get($name)
	{
		if (!isset($this->properties[$name]))
		{
			$a = new AccessProperty($this->reflection->getName(), $name);
			$this->properties[$name] = $a->asInstance($this->instance);
		}
		$tmp = $this->properties[$name]->get($name);
		return $tmp;
	}

	public function __set($name, $value)
	{
		if (!isset($this->properties[$name]))
		{
			$a = new AccessProperty($this->reflection->getName(), $name);
			$this->properties[$name] = $a->asInstance($this->instance);
		}
		return $this->properties[$name]->set($value);
	}

	public function asInstance($object)
	{
		parent::asInstance($object);
		foreach ($this->methods as $a)
		{
			$a->asInstance($this->instance);
		}
		foreach ($this->properties as $a)
		{
			$a->asInstance($this->instance);
		}
		return $this;
	}
}
