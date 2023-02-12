<?php

if (!function_exists('trait_exists') || !trait_exists('Nette\SmartObject')) // nette <= 2.3
{
	abstract class TestCaseSmartObject extends PHPUnit_Framework_TestCase {}
	if (class_exists('Nette\LegacyObject'))
	{
		abstract class TestSmartObject extends Nette\LegacyObject {}
	}
	else
	{
		abstract class TestSmartObject {}
	}
}
else
{
	eval('abstract class TestCaseSmartObject extends PHPUnit_Framework_TestCase { use Nette\SmartObject; }');
	eval('abstract class TestSmartObject { use Nette\SmartObject; }');
}

abstract class TestCase extends TestCaseSmartObject
{

	private $markAsSkippedInTearDown = false;

	/** @deprecated */
	public function setExpectedException($exception, $message = '', $code = null)
	{
		if (method_exists('PHPUnit_Framework_TestCase', 'setExpectedException'))
		{
			return parent::setExpectedException($exception, $message, $code);
		}
		$this->expectException($exception);
		if ($message !== null && $message !== '')
		{
			$this->expectExceptionMessage($message);
		}
		if ($code !== null)
		{
			$this->expectExceptionCode($code);
		}
	}

	public function checkPhpVersion($version, $message = null)
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

	protected function prepareTemplate(Text_Template $template)
	{
		$template->setVar(array('constants' => ''));
	}

}
