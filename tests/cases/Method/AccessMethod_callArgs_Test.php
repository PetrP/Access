<?php

/**
 * @covers AccessMethod::callArgs
 * @covers AccessAccessorPhp52
 * @covers AccessAccessor
 */
class AccessMethod_callArgs_Test extends TestCase
{
	public function testPrivate()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$a = new AccessMethod(new TestAccessMethod, '_private');
		$this->assertSame(1, $a->callArgs());
	}

	public function testPrivateOnParent()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$a = new AccessMethod(new TestAccessMethod2, '_private');
		$this->assertSame(1, $a->callArgs());
	}

	public function testProtected()
	{
		$a = new AccessMethod(new TestAccessMethod, '_protected');
		$this->assertSame(2, $a->callArgs());
	}

	public function testProtectedOnParent()
	{
		$a = new AccessMethod(new TestAccessMethod2, '_protected');
		$this->assertSame(2, $a->callArgs());
	}

	public function testPublic()
	{
		$a = new AccessMethod(new TestAccessMethod, '_public');
		$this->assertSame(3, $a->callArgs());
	}

	public function testPublicOnParent()
	{
		$a = new AccessMethod(new TestAccessMethod2, '_public');
		$this->assertSame(3, $a->callArgs());
	}

	public function testPrivateStatic1()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$a = new AccessMethod(new TestAccessMethod, 'privateStatic');
		$this->assertSame(4, $a->callArgs());
	}

	public function testPrivateOnParentStatic1()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$a = new AccessMethod(new TestAccessMethod2, 'privateStatic');
		$this->assertSame(4, $a->callArgs());
	}

	public function testProtectedStatic1()
	{
		$a = new AccessMethod(new TestAccessMethod, 'protectedStatic');
		$this->assertSame(5, $a->callArgs());
	}

	public function testProtectedOnParentStatic1()
	{
		$a = new AccessMethod(new TestAccessMethod2, 'protectedStatic');
		$this->assertSame(5, $a->callArgs());
	}

	public function testPublicStatic1()
	{
		$a = new AccessMethod(new TestAccessMethod, 'publicStatic');
		$this->assertSame(6, $a->callArgs());
	}

	public function testPublicOnParentStatic1()
	{
		$a = new AccessMethod(new TestAccessMethod2, 'publicStatic');
		$this->assertSame(6, $a->callArgs());
	}

	public function testPrivateStatic2()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$a = new AccessMethod('TestAccessMethod', 'privateStatic');
		$this->assertSame(4, $a->callArgs());
	}

	public function testPrivateOnParentStatic2()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$a = new AccessMethod('TestAccessMethod2', 'privateStatic');
		$this->assertSame(4, $a->callArgs());
	}

	public function testProtectedStatic2()
	{
		$a = new AccessMethod('TestAccessMethod', 'protectedStatic');
		$this->assertSame(5, $a->callArgs());
	}

	public function testProtectedOnParentStatic2()
	{
		$a = new AccessMethod('TestAccessMethod2', 'protectedStatic');
		$this->assertSame(5, $a->callArgs());
	}

	public function testPublicStatic2()
	{
		$a = new AccessMethod('TestAccessMethod', 'publicStatic');
		$this->assertSame(6, $a->callArgs());
	}

	public function testPublicOnParentStatic2()
	{
		$a = new AccessMethod('TestAccessMethod2', 'publicStatic');
		$this->assertSame(6, $a->callArgs());
	}

	public function testNonStatic()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$a = new AccessMethod('TestAccessMethod', '_private');
		$this->setExpectedException('Exception', 'Method TestAccessMethod::_private() is not static.');
		$a->callArgs();
	}

	public function testNonStaticProtected()
	{
		$a = new AccessMethod('TestAccessMethod', '_protected');
		$this->setExpectedException('Exception', 'Method TestAccessMethod::_protected() is not static.');
		$a->callArgs();
	}

	public function testArgs1()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$a = new AccessMethod(new TestAccessMethod, 'args');
		$this->assertSame(array(1,2,3), $a->callArgs(array(1,2,3)));
	}

	public function testArgsProtected1()
	{
		$a = new AccessMethod(new TestAccessMethod, 'argsProtected');
		$this->assertSame(array(1,2,3), $a->callArgs(array(1,2,3)));
	}

	public function testArgs2()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$a = new AccessMethod(new TestAccessMethod, 'args');
		$this->assertSame(array(1,2,3,4), $a->callArgs(array(1,2,3,4)));
	}

	public function testArgsProtected2()
	{
		$a = new AccessMethod(new TestAccessMethod, 'argsProtected');
		$this->assertSame(array(1,2,3,4), $a->callArgs(array(1,2,3,4)));
	}

	public function testArgsRequered()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$a = new AccessMethod(new TestAccessMethod, 'args');
		$this->setExpectedException('PHPUnit_Framework_Error_Warning', 'Missing argument 1 for TestAccessMethod::args()');
		$this->assertSame(6, $a->callArgs());
	}

	public function testArgsProtectedRequered()
	{
		$a = new AccessMethod(new TestAccessMethod, 'argsProtected');
		$this->setExpectedException('PHPUnit_Framework_Error_Warning', 'Missing argument 1 for TestAccessMethod::argsProtected()');
		$this->assertSame(6, $a->callArgs());
	}
}
