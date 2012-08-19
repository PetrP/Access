<?php

/**
 * @covers AccessProperty::get
 * @covers AccessProperty::check
 * @covers AccessAccessorPhp52
 * @covers AccessAccessor
 */
class AccessProperty_get_Test extends TestCase
{
	public function testPrivate()
	{
		$a = new AccessProperty(new TestAccessProperty, 'private');
		$this->assertSame(1, $a->get());
	}

	public function testPrivateOnParent()
	{
		$a = new AccessProperty(new TestAccessProperty2, 'private');
		$this->assertSame(1, $a->get());
	}

	public function testProtected()
	{
		$a = new AccessProperty(new TestAccessProperty, 'protected');
		$this->assertSame(2, $a->get());
	}

	public function testPublic()
	{
		$a = new AccessProperty(new TestAccessProperty, 'public');
		$this->assertSame(3, $a->get());
	}

	public function testPrivateStatic1()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessProperty needs PHP 5.3.0 or newer to access static private property.');
		$a = new AccessProperty(new TestAccessProperty, 'privateStatic');
		$this->assertSame(4, $a->get());
	}

	public function testPrivateOnParentStatic1()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessProperty needs PHP 5.3.0 or newer to access static private property.');
		$a = new AccessProperty(new TestAccessProperty2, 'privateStatic');
		$this->assertSame(4, $a->get());
	}

	public function testProtectedStatic1()
	{
		$a = new AccessProperty(new TestAccessProperty, 'protectedStatic');
		$this->assertSame(5, $a->get());
	}

	public function testProtectedOnParentStatic1()
	{
		$a = new AccessProperty(new TestAccessProperty2, 'protectedStatic');
		$this->assertSame(5, $a->get());
	}

	public function testPublicStatic1()
	{
		$a = new AccessProperty(new TestAccessProperty, 'publicStatic');
		$this->assertSame(6, $a->get());
	}

	public function testPublicOnParentStatic1()
	{
		$a = new AccessProperty(new TestAccessProperty2, 'publicStatic');
		$this->assertSame(6, $a->get());
	}

	public function testPrivateStatic2()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessProperty needs PHP 5.3.0 or newer to access static private property.');
		$a = new AccessProperty('TestAccessProperty', 'privateStatic');
		$this->assertSame(4, $a->get());
	}

	public function testPrivateOnParentStatic2()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessProperty needs PHP 5.3.0 or newer to access static private property.');
		$a = new AccessProperty('TestAccessProperty2', 'privateStatic');
		$this->assertSame(4, $a->get());
	}

	public function testProtectedStatic2()
	{
		$a = new AccessProperty('TestAccessProperty', 'protectedStatic');
		$this->assertSame(5, $a->get());
	}

	public function testProtectedOnParentStatic2()
	{
		$a = new AccessProperty('TestAccessProperty2', 'protectedStatic');
		$this->assertSame(5, $a->get());
	}

	public function testPublicStatic2()
	{
		$a = new AccessProperty('TestAccessProperty', 'publicStatic');
		$this->assertSame(6, $a->get());
	}

	public function testPublicOnParentStatic2()
	{
		$a = new AccessProperty('TestAccessProperty2', 'publicStatic');
		$this->assertSame(6, $a->get());
	}

	public function testNonStatic()
	{
		$a = new AccessProperty('TestAccessProperty', 'private');
		$this->setExpectedException('Exception', 'Property TestAccessProperty::$private is not static.');
		$a->get();
	}

	public function testRepeatable()
	{
		$o = new TestAccessProperty;
		$a = new AccessProperty($o, 'public');
		$this->assertSame(3, $a->get());
		$o->public = 333;
		$this->assertSame(333, $a->get());
	}
}
