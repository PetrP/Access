<?php

/**
 * @covers AccessMethod::call
 * @covers AccessAccessor
 */
class AccessMethod_call_Test extends TestCase
{
	public function testPrivate()
	{
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
		$a = new AccessMethod(new TestAccessMethod, 'args');
		$this->assertSame(array(1, 2, 3), $a->call(1, 2, 3));
	}

	public function testArgsProtected()
	{
		$a = new AccessMethod(new TestAccessMethod, 'argsProtected');
		$this->assertSame(array(1, 2, 3), $a->call(1, 2, 3));
	}
}
