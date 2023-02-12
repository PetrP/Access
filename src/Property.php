<?php
/**
 * Access
 * @link http://github.com/PetrP/Access
 * @author Petr Procházka (petr@petrp.cz)
 * @license "New" BSD License
 */

/**
 * Access to property.
 *
 * <code>
 * $a = Access(new Object, '$propertyName');
 * $a->set(123);
 * $a->get(123);
 * </code>
 *
 * <code>
 * $a = Access('Object', '$propertyName');
 * $a->asInstance(new Object);
 * </code>
 */
class AccessProperty extends AccessBase
{

	/** @var AccessAccessor */
	private $access;

	/**
	 * @param object|string object or class name
	 * @param string property name
	 */
	public function __construct($object, $property)
	{
		$r = NULL;
		$class = is_object($object) ? get_class($object) : $object;
		$autoload = (PHP_VERSION_ID < 50500 AND PHP_VERSION_ID >= 50600); // avoiding autoload for php 5.5 finally bug #67047
		if (
			class_exists($class, $autoload) OR
			(function_exists('trait_exists') AND trait_exists($class, $autoload))
		) // avoiding try-catch on ReflectionClass for php 5.5 finally bug #66608
		{
			do
			{
				$rc = new ReflectionClass($class);
				if ($rc->hasProperty($property)) // avoiding try-catch on ReflectionProperty for php 5.5 finally bug #66608
				{
					try
					{
						$r = new ReflectionProperty($class, $property);
						break;
					}
					catch (ReflectionException $e)
					{
						// hasProperty is not correct for private properties in php 5.2 / 5.3 bug #49719
						// but it is fixed in in 5.5 so try-catch is not problem for finally bug
					}
				}
			}
			while ($class = get_parent_class($class));
		}
		if ($r === NULL)
		{
			$r = new ReflectionProperty($object, $property);
		}
		parent::__construct($object, $r);
		$ac = PHP_VERSION_ID < 50300 ? 'AccessAccessorPhp52' : 'AccessAccessor';
		$accessor = new $ac;
		$this->access = (object) array(
			'get' => $accessor->accessPropertyGet($this->reflection),
			'set' => null, // lazy error
			'accessor' => $accessor,
		);
	}

	/** @return mixed */
	public function get()
	{
		$this->check();
		return call_user_func($this->access->get, $this->instance);
	}

	/**
	 * @param mixed
	 * @return AccessProperty $this
	 */
	public function set($value)
	{
		$this->check();
		if ($this->access->set === null)
		{
			$this->access->set = $this->access->accessor->accessPropertySet($this->reflection);
			unset($this->access->accessor);
		}
		call_user_func($this->access->set, $this->instance, $value);
		return $this;
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
