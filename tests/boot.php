<?php

require_once dirname(__FILE__) . '/libs/Nette/loader.php';
require_once dirname(__FILE__) . '/libs/dump.php';
require_once dirname(__FILE__) . '/../src/Init.php';

NetteDebug::get()->enable(false);
NetteDebug::get()->strictMode = true;

date_default_timezone_set('Europe/Prague');

define('TEMP_DIR', dirname(__FILE__) . '/tmp');

$r = new RobotLoader;
$r->setCacheStorage(Environment::getContext()->cacheStorage);
$r->addDirectory(dirname(__FILE__) . '/libs');
$r->addDirectory(dirname(__FILE__) . '/cases');
$r->register();
unset($r, $storage);

if (PHP_VERSION_ID < 50300)
{
	// aby fungovalo @cover v php 52, kde AccessAccessor neni.
	class AccessAccessor {}
}
if (PHP_VERSION_ID > 50302)
{
	// aby fungovalo @cover v php 53, kde AccessAccessorPhp52 neni.
	class AccessAccessorPhp52 {}
}
