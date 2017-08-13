<?php

/**
 * @covers AccessProxy::__set
 * @covers AccessProxy::proxy
 * @covers AccessProxy::unproxy
 * @covers AccessAccessorPhp52
 * @covers AccessAccessor
 */
class AccessProxy_set_Test extends TestCase
{

	public function testPrivate()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessProperty needs PHP 5.3.0 or newer to write to private property.');
		$o = new TestAccessProperty;
		$a = new AccessProxy($o);
		$a->private = 111;
		$this->assertAttributeSame(111, 'private', $o);
	}

	public function testPrivateOnParent()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessProperty needs PHP 5.3.0 or newer to write to private property.');
		$o = new TestAccessProperty2;
		$a = new AccessProxy($o);
		$a->private = 111;
		$this->assertAttributeSame(111, 'private', $o);
	}

	public function testProtected()
	{
		$o = new TestAccessProperty;
		$a = new AccessProxy($o);
		$a->protected = 222;
		$this->assertAttributeSame(222, 'protected', $o);
	}

	public function testProtectedOnParent()
	{
		$o = new TestAccessProperty2;
		$a = new AccessProxy($o);
		$a->protected = 222;
		$this->assertAttributeSame(222, 'protected', $o);
	}

	public function testPublic()
	{
		$o = new TestAccessProperty;
		$a = new AccessProxy($o);
		$a->public = 333;
		$this->assertAttributeSame(333, 'public', $o);
	}

	public function testPublicOnParent()
	{
		$o = new TestAccessProperty2;
		$a = new AccessProxy($o);
		$a->public = 333;
		$this->assertAttributeSame(333, 'public', $o);
	}

	public function testPrivateStatic1()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'static private property');
		$o = new TestAccessProperty;
		$a = new AccessProxy($o);
		$a->privateStatic = 444;
		$this->assertAttributeSame(444, 'privateStatic', 'TestAccessProperty');
		$a->privateStatic = 4;
	}

	public function testPrivateOnParentStatic1()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'static private property');
		$o = new TestAccessProperty2;
		$a = new AccessProxy($o);
		$a->privateStatic = 444;
		$this->assertAttributeSame(444, 'privateStatic', 'TestAccessProperty');
		$a->privateStatic = 4;
	}

	public function testProtectedStatic1()
	{
		$o = new TestAccessProperty;
		$a = new AccessProxy($o);
		$a->protectedStatic = 555;
		$this->assertAttributeSame(555, 'protectedStatic', 'TestAccessProperty');
		$a->protectedStatic = 5;
	}

	public function testProtectedOnParentStatic1()
	{
		$o = new TestAccessProperty2;
		$a = new AccessProxy($o);
		$a->protectedStatic = 555;
		$this->assertAttributeSame(555, 'protectedStatic', 'TestAccessProperty');
		$a->protectedStatic = 5;
	}

	public function testPublicStatic1()
	{
		$o = new TestAccessProperty;
		$a = new AccessProxy($o);
		$a->publicStatic = 666;
		$this->assertAttributeSame(666, 'publicStatic', 'TestAccessProperty');
		$a->publicStatic = 6;
	}

	public function testPublicOnParentStatic1()
	{
		$o = new TestAccessProperty2;
		$a = new AccessProxy($o);
		$a->publicStatic = 666;
		$this->assertAttributeSame(666, 'publicStatic', 'TestAccessProperty');
		$a->publicStatic = 6;
	}

	public function testPrivateStatic2()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'static private property');
		$a = new AccessProxy('TestAccessProperty');
		$a->privateStatic = 444;
		$this->assertAttributeSame(444, 'privateStatic', 'TestAccessProperty');
		$a->privateStatic = 4;
	}

	public function testPrivateOnParentStatic2()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'static private property');
		$a = new AccessProxy('TestAccessProperty2');
		$a->privateStatic = 444;
		$this->assertAttributeSame(444, 'privateStatic', 'TestAccessProperty');
		$a->privateStatic = 4;
	}

	public function testProtectedStatic2()
	{
		$a = new AccessProxy('TestAccessProperty');
		$a->protectedStatic = 555;
		$this->assertAttributeSame(555, 'protectedStatic', 'TestAccessProperty');
		$a->protectedStatic = 5;
	}

	public function testProtectedOnParentStatic2()
	{
		$a = new AccessProxy('TestAccessProperty2');
		$a->protectedStatic = 555;
		$this->assertAttributeSame(555, 'protectedStatic', 'TestAccessProperty');
		$a->protectedStatic = 5;
	}

	public function testPublicStatic2()
	{
		$a = new AccessProxy('TestAccessProperty');
		$a->publicStatic = 666;
		$this->assertAttributeSame(666, 'publicStatic', 'TestAccessProperty');
		$a->publicStatic = 6;
	}

	public function testPublicOnParentStatic2()
	{
		$a = new AccessProxy('TestAccessProperty2');
		$a->publicStatic = 666;
		$this->assertAttributeSame(666, 'publicStatic', 'TestAccessProperty');
		$a->publicStatic = 6;
	}

	public function testNonStatic()
	{
		$a = new AccessProxy('TestAccessProperty');
		$this->setExpectedException('Exception', 'Property TestAccessProperty::$private is not static.');
		$a->private = 111;
	}

	public function testNonStaticProtected()
	{
		$a = new AccessProxy('TestAccessProperty');
		$this->setExpectedException('Exception', 'Property TestAccessProperty::$protected is not static.');
		$a->protected = 111;
	}

	public function testArray()
	{
		$a = new AccessProxy(array());
		$this->setExpectedException('Exception', "Not possible to set property '->foo' on array.");
		$a->foo = 1;
	}

}
