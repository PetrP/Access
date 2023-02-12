<?php

require_once dirname(__FILE__) . '/../vendor/autoload.php';
require_once dirname(__FILE__) . '/../src/Init.php';

/** @tracySkipLocation */
function dd($var)
{
	Tracy\Debugger::barDump(func_num_args() === 1 ? $var : func_get_args());
	return $var;
}

$configurator = class_exists('Nette\Bootstrap\Configurator') ? new Nette\Bootstrap\Configurator : new Nette\Configurator;
$configurator->enableDebugger();
$configurator->setTempDirectory( __DIR__ . '/tmp');
$configurator->createRobotLoader()
	->addDirectory(__DIR__ . '/cases')
	->register()
;

date_default_timezone_set('Europe/Prague');

define('TEMP_DIR', dirname(__FILE__) . '/tmp');

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
