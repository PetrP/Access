<?php

require_once __DIR__ . '/libs/Nette/loader.php';
require_once __DIR__ . '/libs/HttpPHPUnit/init.php';

callback(function () {

	$http = new HttpPHPUnit;

	require_once __DIR__ . '/boot.php';

	$http->coverage(__DIR__ . '/../Access', __DIR__ . '/report');

	$http->run(__DIR__ . '/cases');

})->invoke();
