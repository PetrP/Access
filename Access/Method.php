<?php
/**
 * Access
 * @link http://github.com/PetrP/Access
 * @author Petr Procházka (petr@petrp.cz)
 * @license "New" BSD License
 */

/**
 * Access to method.
 *
 * <code>
 * $a = Access(new Object, 'methodName');
 * $a->call();
 * $a->call(1, 2, 3);
 * </code>
 *
 * <code>
 * $a = Access('Object', 'methodName');
 * $a->asInstance(new Object);
 * </code>
 */
class AccessMethod extends AccessBase
{

	/**
	 * @param object|string object or class name
	 * @param string method name
	 */
	public function __construct($object, $method)
	{
		if (PHP_VERSION_ID < 50302)
		{
			throw new Exception('AccessMethod needs PHP 5.3.2 or newer.');
		}
		parent::__construct($object, new ReflectionMethod($object, $method));
		$this->reflection->setAccessible(true);
	}

	/**
	 * @param mixed $params,...
	 * @return mixed
	 */
	public function call()
	{
		return $this->callArgs(func_get_args());
	}

	/**
	 * @param array
	 * @return mixed
	 */
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
