<?php

/**
 * @covers AccessMethod::call
 * @covers AccessAccessorPhp52
 * @covers AccessAccessor
 */
class AccessMethod_call_Test extends TestCase
{
	public function testPrivate()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$a = new AccessMethod(new TestAccessMethod, '_private');
		$this->assertSame(1, $a->call());
	}

	public function testProtected()
	{
		$a = new AccessMethod(new TestAccessMethod, '_protected');
		$this->assertSame(2, $a->call());
	}

	public function testPublic()
	{
		$a = new AccessMethod(new TestAccessMethod, '_public');
		$this->assertSame(3, $a->call());
	}

	public function testArgs()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$a = new AccessMethod(new TestAccessMethod, 'args');
		$this->assertSame(array(1, 2, 3), $a->call(1, 2, 3));
	}

	public function testArgsProtected()
	{
		$a = new AccessMethod(new TestAccessMethod, 'argsProtected');
		$this->assertSame(array(1, 2, 3), $a->call(1, 2, 3));
	}
}
