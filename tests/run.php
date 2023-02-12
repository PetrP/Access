<?php

function run()
{
	require_once dirname(__FILE__) . '/boot.php';

	$http = new HttpPHPUnit;

	$c = $http->coverage(dirname(__FILE__) . '/../src', dirname(__FILE__) . '/report');
	if (PHP_VERSION_ID < 50300)
	{
		$c->filter()->removeFileFromWhitelist(dirname(__FILE__) . '/../src/Accessor.php');
	}
	else
	{
		$c->filter()->removeFileFromWhitelist(dirname(__FILE__) . '/../src/AccessorPhp52.php');
	}

	$http->run(dirname(__FILE__) . '/cases');
}
call_user_func('run');
