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

	/**
	 * @param object|string object or class name
	 * @param string property name
	 */
	public function __construct($object, $property)
	{
		if (PHP_VERSION_ID < 50300)
		{
			throw new Exception('AccessProperty needs PHP 5.3.0 or newer.');
		}

		try {
			$r = new ReflectionProperty($object, $property);
		} catch (ReflectionException $e) {
			$class = $object;
			while ($class = get_parent_class($class))
			{
				try {
					$r = new ReflectionProperty($class, $property);
					break;
				} catch (ReflectionException $ee) {}
			}
			if (!isset($r)) throw $e;
		}
		parent::__construct($object, $r);
		$this->reflection->setAccessible(true);
	}

	/** @return mixed */
	public function get()
	{
		if ($this->instance)
		{
			return $this->reflection->getValue($this->instance);
		}
		$this->check();
		return $this->reflection->getValue();
	}

	/**
	 * @param mixed
	 * @return AccessProperty $this
	 */
	public function set($value)
	{
		if ($this->instance)
		{
			$this->reflection->setValue($this->instance, $value);
		}
		else
		{
			$this->check();
			$this->reflection->setValue($value);
		}
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
