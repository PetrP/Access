<?php
/**
 * Access
 * @link http://github.com/PetrP/Access
 * @author Petr Procházka (petr@petrp.cz)
 * @license "New" BSD License
 */

require_once __DIR__ . '/Base.php';
require_once __DIR__ . '/Class.php';
require_once __DIR__ . '/Method.php';
require_once __DIR__ . '/Property.php';

/**
 * Access to method, property or whole class.
 *
 * Method:
 * <code>
 * $a = Access(new Object, 'methodName');
 * $a->call();
 * $a->call(1, 2, 3);
 * </code>
 *
 * Property (prefixed with dollar sign):
 * <code>
 * $a = Access(new Object, '$propertyName');
 * $a->set(123);
 * $a->get(123);
 * </code>
 *
 * Whole class
 * <code>
 * $a = Access(new Object);
 *
 * $a->method();
 * $a->method(1, 2, 3);
 *
 * $a->property = 123;
 * $a->property;
 * </code>
 *
 * @param object|string object or class name
 * @param string|NULL $property or method
 * @return AccessMethod|AccessProperty|AccessClass
 */
function Access($object, $what = NULL)
{
	if ($what === NULL)
	{
		return new AccessClass($object);
	}
	else if ($what{0} === '$')
	{
		return new AccessProperty($object, substr($what, 1));
	}
	else
	{
		return new AccessMethod($object, $what);
	}
}
