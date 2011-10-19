<?php

class TestAccessMethod extends Nette\Object
{
	private function _private()
	{
		return 1;
	}
	protected function _protected()
	{
		return 2;
	}
	public function _public()
	{
		return 3;
	}
	private static function privateStatic()
	{
		return 4;
	}
	protected static function protectedStatic()
	{
		return 5;
	}
	public static function publicStatic()
	{
		return 6;
	}

	private function args($a, $b, $c)
	{
		return func_get_args();
	}

	public $public;
	private function setProperty($p)
	{
		$this->public = $p;
	}
}
