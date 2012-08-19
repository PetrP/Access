<?php

require_once dirname(__FILE__) . '/libs/Nette/loader.php';
require_once dirname(__FILE__) . '/libs/HttpPHPUnit/init.php';

function run()
{
	$http = new HttpPHPUnit;

	require_once dirname(__FILE__) . '/boot.php';

	$http->coverage(dirname(__FILE__) . '/../Access', dirname(__FILE__) . '/report');

	$http->run(dirname(__FILE__) . '/cases');
}
callback('run')->invoke();
