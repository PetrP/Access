<?php

use Nette\Object;

abstract class AccessBase extends Object
{
	protected $reflection;
	protected $instance;

	public function __construct($object, Reflector $r)
	{
		$this->reflection = $r;
		if (is_object($object))
		{
			$this->instance = $object;
		}
	}

	public function asInstance($object)
	{
		if (!is_object($object) AND $object !== NULL)
		{
			throw new Exception('Instance must be object or NULL.');
		}
		$this->instance = $object;
		return $this;
	}
}
