<?php
/**
 * Access
 * @link http://github.com/PetrP/Access
 * @author Petr Procházka (petr@petrp.cz)
 * @license "New" BSD License
 */

/**
 * Accessor for PHP 5.2.
 *
 * Not supported:
 * 	- Final classes.
 * 	- Private methods.
 * 	- Read private static property.
 * 	- Write private property.
 *
 * No limitation when extension runkit or classkit is provided.
 * @see https://pecl.php.net/package/classkit
 * @see https://pecl.php.net/package/runkit
 * @see https://pecl.php.net/package/runkit7
 *
 * @see AccessAccessor
 */
class AccessAccessorPhp52
{

	/** @var array className => helperClassName */
	private static $helperClasses = array();

	/** @var array @access private */
	static $callbackUses = array();

	public static function hasExtensionSupport()
	{
		if (extension_loaded('runkit') && version_compare(RUNKIT_VERSION, '1.0.1', '>='))
		{
			return 'runkit1';
		}
		else if (extension_loaded('runkit7'))
		{
			return 'runkit7';
		}
		else if (extension_loaded('classkit'))
		{
			return 'classkit';
		}
		else if (extension_loaded('runkit')) // prefer classkit because versions 1.0.0-dev and 0.9 are broken in php 5.2
		{
			return 'runkit0';
		}
		return null;
	}

	/**
	 * @param ReflectionMethod
	 * @return callable(object|NULL $instance, array $args)
	 */
	public static function accessMethod(ReflectionMethod $method)
	{
		if (PHP_VERSION_ID >= 50302 OR $method->isPublic())
		{
			if (PHP_VERSION_ID >= 50302)
			{
				$method->setAccessible(true);
			}
			return self::callback('$instance, array $args', '
				return call_user_func_array(array($method, "invoke"), array_merge(array($instance), $args));
			', array('method' => $method));
		}
		else
		{
			return self::callback('$instance, array $args', '
				return call_user_func($helperCallback, $instance, $instance ? $instance : $className, $methodName, $args);
			', array(
				'helperCallback' => self::getHelperCallback($method, 'invoke'),
				'className' => $method->getDeclaringClass()->getName(),
				'methodName' => $method->getName(),
			));
		}
	}

	/**
	 * @param ReflectionProperty
	 * @return callable(object|NULL $instance)
	 */
	public static function accessPropertyGet(ReflectionProperty $property, $isStatic = false)
	{
		if (PHP_VERSION_ID >= 50300 OR $property->isPublic())
		{
			if (PHP_VERSION_ID >= 50300)
			{
				$property->setAccessible(true);
			}
			return self::callback('$instance', '
				if ($instance)
				{
					return $property->getValue($instance);
				}
				return $property->getValue();
			', array('property' => $property));
		}
		else if ($isStatic === false AND $property->isPrivate() AND !$property->isStatic())
		{
			return self::callback('$instance', '
				if ($instance)
				{
					$array = (array) $instance;
					return $array["\0{$className}\0{$propertyName}"];
				}
				return call_user_func(AccessAccessorPhp52::accessPropertyGet($property, true), $instance);
			', array(
				'className' => $property->getDeclaringClass()->getName(),
				'propertyName' => $property->getName(),
				'property' => $property,
			));
		}
		else
		{
			return self::callback('$instance', '
				return call_user_func($helperCallback, $instance, $isStatic ? NULL : $instance, $propertyName);
			', array(
				'isStatic' => $property->isStatic(),
				'helperCallback' => self::getHelperCallback($property, 'get'),
				'propertyName' => $property->getName(),
			));
		}
	}

	/**
	 * @param ReflectionProperty
	 * @return callable(object|NULL $instance, mixed $value)
	 */
	public static function accessPropertySet(ReflectionProperty $property)
	{
		if (PHP_VERSION_ID >= 50300 OR $property->isPublic())
		{
			if (PHP_VERSION_ID >= 50300)
			{
				$property->setAccessible(true);
			}
			return self::callback('$instance, $value', '
				if ($instance)
				{
					$property->setValue($instance, $value);
				}
				else
				{
					$property->setValue($value);
				}
			', array('property' => $property));
		}
		else
		{
			return self::callback('$instance, $value', '
				return call_user_func($helperCallback, $instance, $isStatic ? NULL : $instance, $propertyName, $value);
			', array(
				'isStatic' => $property->isStatic(),
				'helperCallback' => self::getHelperCallback($property, 'set'),
				'propertyName' => $property->getName(),
			));
		}
	}

	/**
	 * Dynamically creates helper subclass.
	 *
	 * @param ReflectionProperty|ReflectionMethod
	 * @param string
	 * @return string helper class name
	 */
	private static function getHelperCallback(Reflector $what, $action)
	{
		$hasExtension = self::hasExtensionSupport();
		$needExtension = false;

		if ($what instanceof ReflectionMethod AND $what->isPrivate())
		{
			if (!$hasExtension) throw new Exception('AccessMethod needs PHP 5.3.2 or newer to call private method.');
			$needExtension = true;
		}
		if ($what instanceof ReflectionProperty AND $action === 'get' AND $what->isPrivate() AND $what->isStatic())
		{
			if (!$hasExtension) throw new Exception("AccessProperty needs PHP 5.3.0 or newer to access static private property.");
			$needExtension = true;
		}
		if ($what instanceof ReflectionProperty AND $action === 'set' AND $what->isPrivate())
		{
			if (!$hasExtension) throw new Exception("AccessProperty needs PHP 5.3.0 or newer to write to private property.");
			$needExtension = true;
		}

		$class = $what->getDeclaringClass();

		if ($class->isFinal())
		{
			if (!$hasExtension) throw new Exception('Access needs PHP 5.3 to work with final classes.');
			$needExtension = true;
		}

		list($helperClass, $prefix) = self::getHelperClass($class, $needExtension ? $hasExtension : NULL);
		$helperMethod = "{$prefix}{$action}";
		if ($needExtension AND ($hasExtension === 'runkit0' OR $hasExtension === 'classkit')) // does not support static methods
		{
			return self::callback('$instance, $p1, $p2, $p3 = null', "
				if (\$instance) \$instance->$helperMethod(\$instance, \$p1, \$p2, \$p3);
				return @$helperClass::$helperMethod(\$instance, \$p1, \$p2, \$p3); // @ - Non-static method should not be called statically
			");
		}
		return array($helperClass, $helperMethod);
	}

	private static function getHelperClass(ReflectionClass $class, $extension)
	{
		$className = $class->getName();
		$cache = & self::$helperClasses[$className][$extension ? 1 : 0];
		if ($cache === NULL)
		{
			$prefix = '__AccessAccessor_php52__' . md5(lcg_value());
			$impl = array(
				array('invoke', '$instance, $object, $method, $arguments', 'return call_user_func_array(array($object, $method), $arguments);'),
				array('get', '$instance, $object, $property', "
					if (\$object) return \$object->{\$property};
					return {$className}::\${\$property};
				"),
				array('set', '$instance, $object, $property, $value', "
					if (\$object) \$object->{\$property} = \$value;
					else {$className}::\${\$property} = \$value;
				"),
			);
			if ($extension)
			{
				foreach ($impl as $list)
				{
					list($methodName, $methodParameters, $methodBody) = $list;
					$methodName = "{$prefix}{$methodName}";
					if ($extension === 'runkit1')
					{
						$res = runkit_method_add($className, $methodName, $methodParameters, $methodBody, RUNKIT_ACC_STATIC | RUNKIT_ACC_STATIC);
					}
					else if ($extension === 'runkit0')
					{
						$res = runkit_method_add($className, $methodName, $methodParameters, $methodBody, RUNKIT_ACC_STATIC);
					}
					else if ($extension === 'classkit')
					{
						$res = classkit_method_add($className, $methodName, $methodParameters, $methodBody, CLASSKIT_ACC_PUBLIC);
					}
					else if ($extension === 'runkit7')
					{
						$res = runkit7_method_add($className, $methodName, $methodParameters, $methodBody, RUNKIT7_ACC_STATIC | RUNKIT7_ACC_STATIC);
					}
					if (!$res || !method_exists($className, $methodName)) throw new Exception('runkit/classkit error');
				}
				$cache = array($className, $prefix);
			}
			else
			{
				$helperClassName = str_replace('\\', '__', $className) . $prefix;
				$code = "abstract class {$helperClassName} extends {$className} {";
				foreach ($impl as $list)
				{
					list($methodName, $methodParameters, $methodBody) = $list;
					$code .= "\nstatic function {$prefix}{$methodName}({$methodParameters}) {\n{$methodBody}\n}\n";
				}
				$code .= "}";
				eval($code);
				$cache = array($helperClassName, $prefix);
			}
		}
		return $cache;
	}

	/**
	 * PHP 5.2 pseudo closure with `use` statement support.
	 *
	 * @param string `$a, $b`
	 * @param string php code
	 * @param array variableName => mixed
	 * @return callable
	 */
	private static function callback($parameters, $body, array $uses = array())
	{
		self::$callbackUses[] = $uses;
		return create_function($parameters, '
			extract(AccessAccessorPhp52::$callbackUses[' . (count(self::$callbackUses) - 1) . '], EXTR_REFS);
		' . $body);
	}

}
