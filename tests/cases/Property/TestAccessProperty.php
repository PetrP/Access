<?php

class TestAccessProperty extends TestSmartObject
{
	private $private = 1;
	protected $protected = 2;
	public $public = 3;
	private static $privateStatic = 4;
	protected static $protectedStatic = 5;
	public static $publicStatic = 6;
}

class TestAccessProperty2 extends TestAccessProperty
{

}
