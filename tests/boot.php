<?php

require_once __DIR__ . '/libs/Nette/loader.php';
require_once __DIR__ . '/libs/dump.php';
require_once __DIR__ . '/../Access/Init.php';

use Nette\Environment;
use Nette\Loaders\RobotLoader;
use HttpPHPUnit\NetteDebug;

NetteDebug::get()->enable(false);
NetteDebug::get()->strictMode = true;

date_default_timezone_set('Europe/Prague');

Environment::setVariable('tempDir', __DIR__ . '/tmp');

$r = new RobotLoader;
$r->setCacheStorage(Environment::getContext()->cacheStorage);
$r->addDirectory(__DIR__ . '/libs');
$r->addDirectory(__DIR__ . '/cases');
$r->register();
unset($r, $storage);
