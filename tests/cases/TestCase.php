<?php

abstract class TestCase extends PHPUnit_Framework_TestCase
{

	private $markAsSkippedInTearDown = false;

	public function checkPhpVersion($version, $message = NULL)
	{
		if (PHP_VERSION_ID < $version && !AccessAccessorPhp52::hasExtensionSupport())
		{
			$this->markTestSkipped("PHP < {$version}" . ($message ? ": {$message}" : ''));
		}
	}

	public function expectedExceptionBeforePhpVersion($version, $exceptionName, $exceptionMessage = '', $exceptionCode = 0)
	{
		if (PHP_VERSION_ID < $version && !AccessAccessorPhp52::hasExtensionSupport())
		{
			$this->setExpectedException($exceptionName, $exceptionMessage, $exceptionCode);
			$this->markAsSkippedInTearDown = "PHP < {$version}" . ($exceptionMessage ? ": {$exceptionMessage}" : '');
		}
	}

	protected function tearDown()
	{
		parent::tearDown();
		if ($this->markAsSkippedInTearDown)
		{
			$this->markTestSkipped($this->markAsSkippedInTearDown);
		}
	}

	public function __call($name, $args)
	{
		return ObjectMixin::call($this, $name, $args);
	}

	public static function __callStatic($name, $args)
	{
		return ObjectMixin::callStatic(get_called_class(), $name, $args);
	}

	public function &__get($name)
	{
		return ObjectMixin::get($this, $name);
	}

	public function __set($name, $value)
	{
		return ObjectMixin::set($this, $name, $value);
	}

	public function __isset($name)
	{
		return ObjectMixin::has($this, $name);
	}

	public function __unset($name)
	{
		ObjectMixin::remove($this, $name);
	}

	protected function prepareTemplate(Text_Template $template)
	{
		$template->setVar(array('constants' => ''));
	}

}
