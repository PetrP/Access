<?php

/**
 * @covers AccessProxy::__call
 * @covers AccessProxy::proxy
 * @covers AccessProxy::unproxy
 * @covers AccessAccessorPhp52
 * @covers AccessAccessor
 */
class AccessProxy_call_Test extends TestCase
{

	public function testPrivate()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$a = new AccessProxy(new TestAccessMethod);
		$this->assertSame(1, $a->_private());
	}

	public function testPrivateOnParent()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$a = new AccessProxy(new TestAccessMethod2);
		$this->assertSame(1, $a->_private());
	}

	public function testProtected()
	{
		$a = new AccessProxy(new TestAccessMethod);
		$this->assertSame(2, $a->_protected());
	}

	public function testProtectedOnParent()
	{
		$a = new AccessProxy(new TestAccessMethod2);
		$this->assertSame(2, $a->_protected());
	}

	public function testPublic()
	{
		$a = new AccessProxy(new TestAccessMethod);
		$this->assertSame(3, $a->_public());
	}

	public function testPublicOnParent()
	{
		$a = new AccessProxy(new TestAccessMethod2);
		$this->assertSame(3, $a->_public());
	}

	public function testPrivateStatic1()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$a = new AccessProxy(new TestAccessMethod);
		$this->assertSame(4, $a->privateStatic());
	}

	public function testPrivateOnParentStatic1()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$a = new AccessProxy(new TestAccessMethod2);
		$this->assertSame(4, $a->privateStatic());
	}

	public function testProtectedStatic1()
	{
		$a = new AccessProxy(new TestAccessMethod);
		$this->assertSame(5, $a->protectedStatic());
	}

	public function testProtectedOnParentStatic1()
	{
		$a = new AccessProxy(new TestAccessMethod2);
		$this->assertSame(5, $a->protectedStatic());
	}

	public function testPublicStatic1()
	{
		$a = new AccessProxy(new TestAccessMethod);
		$this->assertSame(6, $a->publicStatic());
	}

	public function testPublicOnParentStatic1()
	{
		$a = new AccessProxy(new TestAccessMethod2);
		$this->assertSame(6, $a->publicStatic());
	}

	public function testPrivateStatic2()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$a = new AccessProxy('TestAccessMethod');
		$this->assertSame(4, $a->privateStatic());
	}

	public function testPrivateOnParentStatic2()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$a = new AccessProxy('TestAccessMethod2');
		$this->assertSame(4, $a->privateStatic());
	}

	public function testProtectedStatic2()
	{
		$a = new AccessProxy('TestAccessMethod');
		$this->assertSame(5, $a->protectedStatic());
	}

	public function testProtectedOnParentStatic2()
	{
		$a = new AccessProxy('TestAccessMethod2');
		$this->assertSame(5, $a->protectedStatic());
	}

	public function testPublicStatic2()
	{
		$a = new AccessProxy('TestAccessMethod');
		$this->assertSame(6, $a->publicStatic());
	}

	public function testPublicOnParentStatic2()
	{
		$a = new AccessProxy('TestAccessMethod2');
		$this->assertSame(6, $a->publicStatic());
	}

	public function testNonStatic()
	{
		$a = new AccessProxy('TestAccessMethod');
		$this->setExpectedException('Exception', 'Method TestAccessMethod::_private() is not static.');
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$a->_private();
	}

	public function testNonStaticProtected()
	{
		$a = new AccessProxy('TestAccessMethod');
		$this->setExpectedException('Exception', 'Method TestAccessMethod::_protected() is not static.');
		$a->_protected();
	}

	public function testArgs1()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$a = new AccessProxy(new TestAccessMethod);
		$this->assertSame(array(1,2,3), $a->args(1,2,3)->getInstance());
	}

	public function testArgs1Protected()
	{
		$a = new AccessProxy(new TestAccessMethod);
		$this->assertSame(array(1,2,3), $a->argsProtected(1,2,3)->getInstance());
	}

	public function testArgs2()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$a = new AccessProxy(new TestAccessMethod);
		$this->assertSame(array(1,2,3,4), $a->args(1,2,3,4)->getInstance());
	}

	public function testArgs2Protected()
	{
		$a = new AccessProxy(new TestAccessMethod);
		$this->assertSame(array(1,2,3,4), $a->argsProtected(1,2,3,4)->getInstance());
	}

	public function testArgsRequered()
	{
		$a = new AccessProxy(new TestAccessMethod);
		$this->setExpectedException('PHPUnit_Framework_Error_Warning', 'Missing argument 1 for TestAccessMethod::args()');
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$this->assertSame(6, $a->args());
	}

	public function testArgsProtectedRequered()
	{
		$a = new AccessProxy(new TestAccessMethod);
		$this->setExpectedException('PHPUnit_Framework_Error_Warning', 'Missing argument 1 for TestAccessMethod::argsProtected()');
		$this->assertSame(6, $a->argsProtected());
	}

	public function testArray()
	{
		$a = new AccessProxy(array());
		$this->setExpectedException('Exception', "Not possible to call '->foo()' on array.");
		$a->foo();
	}

}
