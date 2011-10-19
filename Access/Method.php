<?php

class AccessMethod extends AccessBase
{
	public function __construct($object, $method)
	{
		parent::__construct($object, new ReflectionMethod($object, $method));
		$this->reflection->setAccessible(true);
	}

	public function call()
	{
		return $this->callArgs(func_get_args());
	}

	public function callArgs(array $args = array())
	{
		if (!$this->instance AND !$this->reflection->isStatic())
		{
			$c = $this->reflection->getDeclaringClass()->getName();
			$n = $this->reflection->getName();
			throw new Exception("Method $c::$n() is not static.");
		}
		return call_user_func_array(array($this->reflection, 'invoke'), array_merge(array($this->instance), $args));
	}
}
