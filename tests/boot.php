<?php

require_once dirname(__FILE__) . '/libs/Nette/loader.php';
require_once dirname(__FILE__) . '/libs/dump.php';
require_once dirname(__FILE__) . '/../Access/Init.php';

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
