<?php

class AccessProperty extends AccessBase
{
	public function __construct($object, $property)
	{
		parent::__construct($object, new ReflectionProperty($object, $property));
		$this->reflection->setAccessible(true);
	}

	public function get()
	{
		if ($this->instance)
		{
			return $this->reflection->getValue($this->instance);
		}
		$this->check();
		return $this->reflection->getValue();
	}

	public function set($value)
	{
		if ($this->instance)
		{
			return $this->reflection->setValue($this->instance, $value);
		}
		$this->check();
		return $this->reflection->setValue($value);
	}

	private function check()
	{
		if (!$this->instance AND !$this->reflection->isStatic())
		{
			$c = $this->reflection->getDeclaringClass()->getName();
			$n = $this->reflection->getName();
			throw new Exception("Property $c::$$n is not static.");
		}
	}
}
