<?php

require_once dirname(__FILE__) . '/Main/Main.php';

set_time_limit(0);
ini_set('memory_limit', '1G');
if (extension_loaded('xdebug')) xdebug_disable();

/** bc */
class HttpPHPUnit extends Main
{

}
