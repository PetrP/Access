<?php

/**
 * @covers AccessProperty::set
 * @covers AccessProperty::check
 * @covers AccessAccessorPhp52
 * @covers AccessAccessor
 */
class AccessProperty_set_Test extends TestCase
{
	public function testPrivate()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessProperty needs PHP 5.3.0 or newer to write to private property.');
		$o = new TestAccessProperty;
		$a = new AccessProperty($o, 'private');
		$this->assertSame($a, $a->set(111));
		$this->assertAttributeSame(111, 'private', $o);
	}

	public function testPrivateOnParent()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessProperty needs PHP 5.3.0 or newer to write to private property.');
		$o = new TestAccessProperty2;
		$a = new AccessProperty($o, 'private');
		$this->assertSame($a, $a->set(111));
		$this->assertAttributeSame(111, 'private', $o);
	}

	public function testProtected()
	{
		$o = new TestAccessProperty;
		$a = new AccessProperty($o, 'protected');
		$this->assertSame($a, $a->set(222));
		$this->assertAttributeSame(222, 'protected', $o);
	}

	public function testProtectedOnParent()
	{
		$o = new TestAccessProperty2;
		$a = new AccessProperty($o, 'protected');
		$this->assertSame($a, $a->set(222));
		$this->assertAttributeSame(222, 'protected', $o);
	}

	public function testPublic()
	{
		$o = new TestAccessProperty;
		$a = new AccessProperty($o, 'public');
		$this->assertSame($a, $a->set(333));
		$this->assertAttributeSame(333, 'public', $o);
	}

	public function testPublicOnParent()
	{
		$o = new TestAccessProperty2;
		$a = new AccessProperty($o, 'public');
		$this->assertSame($a, $a->set(333));
		$this->assertAttributeSame(333, 'public', $o);
	}

	public function testPrivateStatic1()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessProperty needs PHP 5.3.0 or newer to access static private property.');
		$o = new TestAccessProperty;
		$a = new AccessProperty($o, 'privateStatic');
		$this->assertSame($a, $a->set(444));
		$this->assertAttributeSame(444, 'privateStatic', 'TestAccessProperty');
		$this->assertSame($a, $a->set(4));
	}

	public function testPrivateOnParentStatic1()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessProperty needs PHP 5.3.0 or newer to access static private property.');
		$o = new TestAccessProperty2;
		$a = new AccessProperty($o, 'privateStatic');
		$this->assertSame($a, $a->set(444));
		$this->assertAttributeSame(444, 'privateStatic', 'TestAccessProperty');
		$this->assertSame($a, $a->set(4));
	}

	public function testProtectedStatic1()
	{
		$o = new TestAccessProperty;
		$a = new AccessProperty($o, 'protectedStatic');
		$this->assertSame($a, $a->set(555));
		$this->assertAttributeSame(555, 'protectedStatic', 'TestAccessProperty');
		$this->assertSame($a, $a->set(5));
	}

	public function testProtectedOnParentStatic1()
	{
		$o = new TestAccessProperty2;
		$a = new AccessProperty($o, 'protectedStatic');
		$this->assertSame($a, $a->set(555));
		$this->assertAttributeSame(555, 'protectedStatic', 'TestAccessProperty');
		$this->assertSame($a, $a->set(5));
	}

	public function testPublicStatic1()
	{
		$o = new TestAccessProperty;
		$a = new AccessProperty($o, 'publicStatic');
		$this->assertSame($a, $a->set(666));
		$this->assertAttributeSame(666, 'publicStatic', 'TestAccessProperty');
		$this->assertSame($a, $a->set(6));
	}

	public function testPublicOnParentStatic1()
	{
		$o = new TestAccessProperty2;
		$a = new AccessProperty($o, 'publicStatic');
		$this->assertSame($a, $a->set(666));
		$this->assertAttributeSame(666, 'publicStatic', 'TestAccessProperty');
		$this->assertSame($a, $a->set(6));
	}

	public function testPrivateStatic2()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessProperty needs PHP 5.3.0 or newer to access static private property.');
		$a = new AccessProperty('TestAccessProperty', 'privateStatic');
		$this->assertSame($a, $a->set(444));
		$this->assertAttributeSame(444, 'privateStatic', 'TestAccessProperty');
		$this->assertSame($a, $a->set(4));
	}

	public function testPrivateOnParentStatic2()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessProperty needs PHP 5.3.0 or newer to access static private property.');
		$a = new AccessProperty('TestAccessProperty2', 'privateStatic');
		$this->assertSame($a, $a->set(444));
		$this->assertAttributeSame(444, 'privateStatic', 'TestAccessProperty');
		$this->assertSame($a, $a->set(4));
	}

	public function testProtectedStatic2()
	{
		$a = new AccessProperty('TestAccessProperty', 'protectedStatic');
		$this->assertSame($a, $a->set(555));
		$this->assertAttributeSame(555, 'protectedStatic', 'TestAccessProperty');
		$this->assertSame($a, $a->set(5));
	}

	public function testProtectedOnParentStatic2()
	{
		$a = new AccessProperty('TestAccessProperty2', 'protectedStatic');
		$this->assertSame($a, $a->set(555));
		$this->assertAttributeSame(555, 'protectedStatic', 'TestAccessProperty');
		$this->assertSame($a, $a->set(5));
	}

	public function testPublicStatic2()
	{
		$a = new AccessProperty('TestAccessProperty', 'publicStatic');
		$this->assertSame($a, $a->set(666));
		$this->assertAttributeSame(666, 'publicStatic', 'TestAccessProperty');
		$this->assertSame($a, $a->set(6));
	}

	public function testPublicOnParentStatic2()
	{
		$a = new AccessProperty('TestAccessProperty2', 'publicStatic');
		$this->assertSame($a, $a->set(666));
		$this->assertAttributeSame(666, 'publicStatic', 'TestAccessProperty');
		$this->assertSame($a, $a->set(6));
	}

	public function testReturn()
	{
		$a = new AccessProperty(new TestAccessProperty, 'public');
		$this->assertSame($a, $a->set(666));
	}

	public function testNonStatic()
	{
		$a = new AccessProperty('TestAccessProperty', 'private');
		$this->setExpectedException('Exception', 'Property TestAccessProperty::$private is not static.');
		$a->set(111);
	}

	public function testNonStaticProtected()
	{
		$a = new AccessProperty('TestAccessProperty', 'protected');
		$this->setExpectedException('Exception', 'Property TestAccessProperty::$protected is not static.');
		$a->set(111);
	}
}
