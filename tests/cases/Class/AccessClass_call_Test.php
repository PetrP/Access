<?php

/**
 * @covers AccessClass::__call
 */
class AccessClass_call_Test extends TestCase
{
	public function testPrivate()
	{
		$a = new AccessClass(new TestAccessMethod);
		$this->assertSame(1, $a->_private());
	}

	public function testProtected()
	{
		$a = new AccessClass(new TestAccessMethod);
		$this->assertSame(2, $a->_protected());
	}

	public function testPublic()
	{
		$a = new AccessClass(new TestAccessMethod);
		$this->assertSame(3, $a->_public());
	}

	public function testPrivateStatic1()
	{
		$a = new AccessClass(new TestAccessMethod);
		$this->assertSame(4, $a->privateStatic());
	}

	public function testProtectedStatic1()
	{
		$a = new AccessClass(new TestAccessMethod);
		$this->assertSame(5, $a->protectedStatic());
	}

	public function testPublicStatic1()
	{
		$a = new AccessClass(new TestAccessMethod);
		$this->assertSame(6, $a->publicStatic());
	}

	public function testPrivateStatic2()
	{
		$a = new AccessClass('TestAccessMethod');
		$this->assertSame(4, $a->privateStatic());
	}

	public function testProtectedStatic2()
	{
		$a = new AccessClass('TestAccessMethod');
		$this->assertSame(5, $a->protectedStatic());
	}

	public function testPublicStatic2()
	{
		$a = new AccessClass('TestAccessMethod');
		$this->assertSame(6, $a->publicStatic());
	}

	public function testNonStatic()
	{
		$a = new AccessClass('TestAccessMethod');
		$this->setExpectedException('Exception', 'Method TestAccessMethod::_private() is not static.');
		$a->_private();
	}

	public function testArgs1()
	{
		$a = new AccessClass(new TestAccessMethod);
		$this->assertSame(array(1,2,3), $a->args(1,2,3));
	}

	public function testArgs2()
	{
		$a = new AccessClass(new TestAccessMethod);
		$this->assertSame(array(1,2,3,4), $a->args(1,2,3,4));
	}

	public function testArgsRequered()
	{
		$a = new AccessClass(new TestAccessMethod);
		$this->setExpectedException('PHPUnit_Framework_Error_Warning', 'Missing argument 1 for TestAccessMethod::args()');
		$this->assertSame(6, $a->args());
	}
}
