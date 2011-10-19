<?php

if (PHP_VERSION_ID < 50302)
{
	throw new Exception('Access needs PHP 5.3.2 or newer.');
}

require_once __DIR__ . '/Base.php';
require_once __DIR__ . '/Class.php';
require_once __DIR__ . '/Method.php';
require_once __DIR__ . '/Property.php';

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
