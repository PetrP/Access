<?php

use Nette\Object;

abstract class AccessBase extends Object
{

	/** @var ReflectionClass|ReflectionMethod|ReflectionProperty */
	protected $reflection;

	/** @var object|NULL */
	protected $instance;


	/**
	 * @param object|string object or class name
	 * @param ReflectionClass|ReflectionMethod|ReflectionProperty
	 */
	public function __construct($object, Reflector $r)
	{
		$this->reflection = $r;
		if (is_object($object))
		{
			$this->instance = $object;
		}
	}

	/**
	 * @param object|NULL
	 * @return AccessBase $this
	 */
	public function asInstance($object)
	{
		if (is_object($object))
		{
			if ($this->reflection instanceof ReflectionClass)
			{
				$class = $this->reflection->getName();
			}
			else
			{
				$class = $this->reflection->getDeclaringClass()->getName();
			}
			if (!($object instanceof $class))
			{
				throw new Exception('Must be instance of accessible class.');
			}
		}
		else if ($object !== NULL)
		{
			throw new Exception('Instance must be object or NULL.');
		}
		$this->instance = $object;
		return $this;
	}
}
