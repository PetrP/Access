<?php

require_once dirname(__FILE__) . '/libs/Nette/loader.php';
require_once dirname(__FILE__) . '/libs/HttpPHPUnit/init.php';

function run()
{
	$http = new HttpPHPUnit;

	require_once dirname(__FILE__) . '/boot.php';

	$c = $http->coverage(dirname(__FILE__) . '/../Access', dirname(__FILE__) . '/report');
	if (PHP_VERSION_ID < 50300)
	{
		$c->filter()->removeFileFromWhitelist(dirname(__FILE__) . '/../Access/Accessor.php');
	}
	else
	{
		$c->filter()->removeFileFromWhitelist(dirname(__FILE__) . '/../Access/AccessorPhp52.php');
	}

	$http->run(dirname(__FILE__) . '/cases');
}
callback('run')->invoke();
