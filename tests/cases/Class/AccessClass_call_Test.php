<?php

/**
 * @covers AccessClass::__call
 * @covers AccessAccessorPhp52
 * @covers AccessAccessor
 */
class AccessClass_call_Test extends TestCase
{
	public function testPrivate()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$a = new AccessClass(new TestAccessMethod);
		$this->assertSame(1, $a->_private());
	}

	public function testPrivateOnParent()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$a = new AccessClass(new TestAccessMethod2);
		$this->assertSame(1, $a->_private());
	}

	public function testProtected()
	{
		$a = new AccessClass(new TestAccessMethod);
		$this->assertSame(2, $a->_protected());
	}

	public function testProtectedOnParent()
	{
		$a = new AccessClass(new TestAccessMethod2);
		$this->assertSame(2, $a->_protected());
	}

	public function testPublic()
	{
		$a = new AccessClass(new TestAccessMethod);
		$this->assertSame(3, $a->_public());
	}

	public function testPublicOnParent()
	{
		$a = new AccessClass(new TestAccessMethod2);
		$this->assertSame(3, $a->_public());
	}

	public function testPrivateStatic1()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$a = new AccessClass(new TestAccessMethod);
		$this->assertSame(4, $a->privateStatic());
	}

	public function testPrivateOnParentStatic1()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$a = new AccessClass(new TestAccessMethod2);
		$this->assertSame(4, $a->privateStatic());
	}

	public function testProtectedStatic1()
	{
		$a = new AccessClass(new TestAccessMethod);
		$this->assertSame(5, $a->protectedStatic());
	}

	public function testProtectedOnParentStatic1()
	{
		$a = new AccessClass(new TestAccessMethod2);
		$this->assertSame(5, $a->protectedStatic());
	}

	public function testPublicStatic1()
	{
		$a = new AccessClass(new TestAccessMethod);
		$this->assertSame(6, $a->publicStatic());
	}

	public function testPublicOnParentStatic1()
	{
		$a = new AccessClass(new TestAccessMethod2);
		$this->assertSame(6, $a->publicStatic());
	}

	public function testPrivateStatic2()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$a = new AccessClass('TestAccessMethod');
		$this->assertSame(4, $a->privateStatic());
	}

	public function testPrivateOnParentStatic2()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$a = new AccessClass('TestAccessMethod2');
		$this->assertSame(4, $a->privateStatic());
	}

	public function testProtectedStatic2()
	{
		$a = new AccessClass('TestAccessMethod');
		$this->assertSame(5, $a->protectedStatic());
	}

	public function testProtectedOnParentStatic2()
	{
		$a = new AccessClass('TestAccessMethod2');
		$this->assertSame(5, $a->protectedStatic());
	}

	public function testPublicStatic2()
	{
		$a = new AccessClass('TestAccessMethod');
		$this->assertSame(6, $a->publicStatic());
	}

	public function testPublicOnParentStatic2()
	{
		$a = new AccessClass('TestAccessMethod2');
		$this->assertSame(6, $a->publicStatic());
	}

	public function testNonStatic()
	{
		$a = new AccessClass('TestAccessMethod');
		$this->setExpectedException('Exception', 'Method TestAccessMethod::_private() is not static.');
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$a->_private();
	}

	public function testNonStaticProtected()
	{
		$a = new AccessClass('TestAccessMethod');
		$this->setExpectedException('Exception', 'Method TestAccessMethod::_protected() is not static.');
		$a->_protected();
	}

	public function testArgs1()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$a = new AccessClass(new TestAccessMethod);
		$this->assertSame(array(1,2,3), $a->args(1,2,3));
	}

	public function testArgs1Protected()
	{
		$a = new AccessClass(new TestAccessMethod);
		$this->assertSame(array(1,2,3), $a->argsProtected(1,2,3));
	}

	public function testArgs2()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$a = new AccessClass(new TestAccessMethod);
		$this->assertSame(array(1,2,3,4), $a->args(1,2,3,4));
	}

	public function testArgs2Protected()
	{
		$a = new AccessClass(new TestAccessMethod);
		$this->assertSame(array(1,2,3,4), $a->argsProtected(1,2,3,4));
	}

	public function testArgsRequered()
	{
		$a = new AccessClass(new TestAccessMethod);
		if (PHP_VERSION_ID >= 70100)
		{
			$this->setExpectedException('ArgumentCountError', 'Too few arguments to function TestAccessMethod::args(), 0 passed and exactly 3 expected');
		}
		else
		{
			$this->setExpectedException('PHPUnit_Framework_Error_Warning', 'Missing argument 1 for TestAccessMethod::args()');
		}
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$this->assertSame(6, $a->args());
	}

	public function testArgsProtectedRequered()
	{
		$a = new AccessClass(new TestAccessMethod);
		if (PHP_VERSION_ID >= 70100)
		{
			$this->setExpectedException('ArgumentCountError', 'Too few arguments to function TestAccessMethod::argsProtected(), 0 passed and exactly 3 expected');
		}
		else
		{
			$this->setExpectedException('PHPUnit_Framework_Error_Warning', 'Missing argument 1 for TestAccessMethod::argsProtected()');
		}
		$this->assertSame(6, $a->argsProtected());
	}
}
