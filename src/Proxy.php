<?php
/**
 * Access
 * @link http://github.com/PetrP/Access
 * @author Petr Procházka (petr@petrp.cz)
 * @license "New" BSD License
 */


class AccessProxy extends AccessClass implements ArrayAccess
{

	private $propagate;

	/**
	 * @param array|object|string
	 */
	public function __construct($object)
	{
		$object = $this->unproxy($object);
		if (is_object($object) OR is_string($object))
		{
			parent::__construct($object);
		}
		else if (is_array($object))
		{
			$this->instance = $object;
		}
		else
		{
			throw new Exception('Instance must be array or object or class name.');
		}
	}

	/**
	 * @param string
	 * @param array
	 * @return mixed
	 */
	public function __call($name, $args)
	{
		if (is_array($this->instance))
		{
			throw new Exception("Not possible to call '->$name()' on array.");
		}
		return $this->proxy(parent::__call($name, $this->unproxy($args)));
	}

	/**
	 * @param string
	 * @return mixed
	 */
	public function & __get($name)
	{
		if (is_array($this->instance))
		{
			throw new Exception("Not possible to read property '->$name' on array.");
		}
		$tmp = parent::__get($name);
		$tmp = $this->proxy($tmp, $name);
		return $tmp;
	}

	/**
	 * @param string
	 * @param mixed
	 * @return void
	 */
	public function __set($name, $value)
	{
		if (is_array($this->instance))
		{
			throw new Exception("Not possible to set property '->$name' on array.");
		}
		parent::__set($name, $this->unproxy($value));
	}

	/**
	 * @param mixed
	 * @return bool
	 */
	public function offsetExists($offset)
	{
		if (is_array($this->instance))
		{
			return isset($this->instance[$offset]);
		}
		return $this->__call(__FUNCTION__, func_get_args());
	}

	/**
	 * @param mixed
	 * @return AccessProxy|mixed
	 */
	public function offsetGet($offset)
	{
		if (is_array($this->instance))
		{
			return $this->proxy($this->instance[$offset], $offset);
		}
		return $this->__call(__FUNCTION__, func_get_args());
	}

	/**
	 * @param mixed
	 * @param mixed
	 * @return void
	 */
	public function offsetSet($offset, $value)
	{
		if (is_array($this->instance))
		{
			if ($offset === NULL AND ($this->instance === array() OR array_keys($this->instance) === range(0, count($this->instance) - 1)))
			{
				$offset = count($this->instance);
			}
			$this->instance[$offset] = $this->unproxy($value);
			$this->propagate();
			return;
		}
		return $this->__call(__FUNCTION__, func_get_args());
	}

	/**
	 * @param mixed
	 * @return void
	 */
	public function offsetUnset($offset)
	{
		if (is_array($this->instance))
		{
			unset($this->instance[$offset]);
			$this->propagate();
			return;
		}
		return $this->__call(__FUNCTION__, func_get_args());
	}

	/**
	 * @param mixed
	 * @param mixed
	 * @return AccessProxy
	 */
	private function proxy($value, $keyOrProperty = NULL)
	{
		if ($value === NULL OR is_scalar($value) OR is_resource($value) OR $value instanceof Generator)
		{
			return $value;
		}
		else if (is_object($value) OR is_array($value))
		{
			$proxy = new self($value);
			if (is_array($value) AND func_num_args() > 1)
			{
				$proxy->propagate = array($this, $keyOrProperty);
			}
			return $proxy;
		}
		throw new Exception('Unsupported type ' . gettype($value));
	}

	/**
	 * @param AccessProxy|mixed
	 * @return mixed
	 */
	private function unproxy($value)
	{
		if ($value instanceof self)
		{
			return $value->instance;
		}
		return $value;
	}

	private function propagate()
	{
		if (list($proxy, $keyOrProperty) = $this->propagate)
		{
			$proxy->{is_array($proxy->instance) ? 'offsetSet' : '__set'}($keyOrProperty, $this);
		}
	}

	/**
	 * @param object|array|null
	 */
	public function asInstance($object)
	{
		if (!is_array($this->instance))
		{
			parent::asInstance($object);
		}
		else if (is_array($object))
		{
			$this->instance = $object;
		}
		else
		{
			throw new Exception('Instance must be array.');
		}
		return $this;
	}

	/**
	 * @return object|array|null
	 */
	public function getInstance()
	{
		return $this->instance;
	}

}
