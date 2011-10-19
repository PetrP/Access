<?php

/**
 * @covers AccessMethod::callArgs
 */
class AccessMethod_callArgs_Test extends TestCase
{
	public function testPrivate()
	{
		$a = new AccessMethod(new TestAccessMethod, '_private');
		$this->assertSame(1, $a->callArgs());
	}

	public function testProtected()
	{
		$a = new AccessMethod(new TestAccessMethod, '_protected');
		$this->assertSame(2, $a->callArgs());
	}

	public function testPublic()
	{
		$a = new AccessMethod(new TestAccessMethod, '_public');
		$this->assertSame(3, $a->callArgs());
	}

	public function testPrivateStatic1()
	{
		$a = new AccessMethod(new TestAccessMethod, 'privateStatic');
		$this->assertSame(4, $a->callArgs());
	}

	public function testProtectedStatic1()
	{
		$a = new AccessMethod(new TestAccessMethod, 'protectedStatic');
		$this->assertSame(5, $a->callArgs());
	}

	public function testPublicStatic1()
	{
		$a = new AccessMethod(new TestAccessMethod, 'publicStatic');
		$this->assertSame(6, $a->callArgs());
	}

	public function testPrivateStatic2()
	{
		$a = new AccessMethod('TestAccessMethod', 'privateStatic');
		$this->assertSame(4, $a->callArgs());
	}

	public function testProtectedStatic2()
	{
		$a = new AccessMethod('TestAccessMethod', 'protectedStatic');
		$this->assertSame(5, $a->callArgs());
	}

	public function testPublicStatic2()
	{
		$a = new AccessMethod('TestAccessMethod', 'publicStatic');
		$this->assertSame(6, $a->callArgs());
	}

	public function testNonStatic()
	{
		$a = new AccessMethod('TestAccessMethod', '_private');
		$this->setExpectedException('Exception', 'Method TestAccessMethod::_private() is not static.');
		$a->callArgs();
	}

	public function testArgs1()
	{
		$a = new AccessMethod(new TestAccessMethod, 'args');
		$this->assertSame(array(1,2,3), $a->callArgs(array(1,2,3)));
	}

	public function testArgs2()
	{
		$a = new AccessMethod(new TestAccessMethod, 'args');
		$this->assertSame(array(1,2,3,4), $a->callArgs(array(1,2,3,4)));
	}

	public function testArgsRequered()
	{
		$a = new AccessMethod(new TestAccessMethod, 'args');
		$this->setExpectedException('PHPUnit_Framework_Error_Warning', 'Missing argument 1 for TestAccessMethod::args()');
		$this->assertSame(6, $a->callArgs());
	}
}
