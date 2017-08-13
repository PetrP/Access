<?php

/**
 * @covers AccessProxy::__get
 * @covers AccessProxy::proxy
 * @covers AccessProxy::unproxy
 * @covers AccessAccessorPhp52
 * @covers AccessAccessor
 */
class AccessProxy_get_Test extends TestCase
{

	public function testPrivate()
	{
		$a = new AccessProxy(new TestAccessProperty);
		$this->assertSame(1, $a->private);
	}

	public function testPrivateOnParent()
	{
		$a = new AccessProxy(new TestAccessProperty2);
		$this->assertSame(1, $a->private);
	}

	public function testProtected()
	{
		$a = new AccessProxy(new TestAccessProperty);
		$this->assertSame(2, $a->protected);
	}

	public function testPublic()
	{
		$a = new AccessProxy(new TestAccessProperty);
		$this->assertSame(3, $a->public);
	}

	public function testPrivateStatic1()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessProperty needs PHP 5.3.0 or newer to access static private property.');
		$a = new AccessProxy(new TestAccessProperty);
		$this->assertSame(4, $a->privateStatic);
	}

	public function testPrivateOnParentStatic1()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessProperty needs PHP 5.3.0 or newer to access static private property.');
		$a = new AccessProxy(new TestAccessProperty2);
		$this->assertSame(4, $a->privateStatic);
	}

	public function testProtectedStatic1()
	{
		$a = new AccessProxy(new TestAccessProperty);
		$this->assertSame(5, $a->protectedStatic);
	}

	public function testProtectedOnParentStatic1()
	{
		$a = new AccessProxy(new TestAccessProperty2);
		$this->assertSame(5, $a->protectedStatic);
	}

	public function testPublicStatic1()
	{
		$a = new AccessProxy(new TestAccessProperty);
		$this->assertSame(6, $a->publicStatic);
	}

	public function testPublicOnParentStatic1()
	{
		$a = new AccessProxy(new TestAccessProperty2);
		$this->assertSame(6, $a->publicStatic);
	}

	public function testPrivateStatic2()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessProperty needs PHP 5.3.0 or newer to access static private property.');
		$a = new AccessProxy('TestAccessProperty');
		$this->assertSame(4, $a->privateStatic);
	}

	public function testPrivateOnParentStatic2()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessProperty needs PHP 5.3.0 or newer to access static private property.');
		$a = new AccessProxy('TestAccessProperty2');
		$this->assertSame(4, $a->privateStatic);
	}

	public function testProtectedStatic2()
	{
		$a = new AccessProxy('TestAccessProperty');
		$this->assertSame(5, $a->protectedStatic);
	}

	public function testProtectedOnParentStatic2()
	{
		$a = new AccessProxy('TestAccessProperty2');
		$this->assertSame(5, $a->protectedStatic);
	}

	public function testPublicStatic2()
	{
		$a = new AccessProxy('TestAccessProperty');
		$this->assertSame(6, $a->publicStatic);
	}

	public function testPublicOnParentStatic2()
	{
		$a = new AccessProxy('TestAccessProperty2');
		$this->assertSame(6, $a->publicStatic);
	}

	public function testNonStatic()
	{
		$a = new AccessProxy('TestAccessProperty');
		$this->setExpectedException('Exception', 'Property TestAccessProperty::$private is not static.');
		$a->private;
	}

	public function testNonStaticProtected()
	{
		$a = new AccessProxy('TestAccessProperty');
		$this->setExpectedException('Exception', 'Property TestAccessProperty::$protected is not static.');
		$a->protected;
	}

	public function testRepeatable()
	{
		$o = new TestAccessProperty;
		$a = new AccessProxy($o);
		$this->assertSame(3, $a->public);
		$o->public = 333;
		$this->assertSame(333, $a->public);
	}

	public function testArray()
	{
		$a = new AccessProxy(array());
		$this->setExpectedException('Exception', "Not possible to read property '->foo' on array.");
		$a->foo;
	}

}
