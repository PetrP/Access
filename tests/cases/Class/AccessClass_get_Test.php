<?php

/**
 * @covers AccessClass::__get
 */
class AccessClass_get_Test extends TestCase
{
	public function testPrivate()
	{
		$a = new AccessClass(new TestAccessProperty);
		$this->assertSame(1, $a->private);
	}

	public function testProtected()
	{
		$a = new AccessClass(new TestAccessProperty);
		$this->assertSame(2, $a->protected);
	}

	public function testPublic()
	{
		$a = new AccessClass(new TestAccessProperty);
		$this->assertSame(3, $a->public);
	}

	public function testPrivateStatic1()
	{
		$a = new AccessClass(new TestAccessProperty);
		$this->assertSame(4, $a->privateStatic);
	}

	public function testProtectedStatic1()
	{
		$a = new AccessClass(new TestAccessProperty);
		$this->assertSame(5, $a->protectedStatic);
	}

	public function testPublicStatic1()
	{
		$a = new AccessClass(new TestAccessProperty);
		$this->assertSame(6, $a->publicStatic);
	}

	public function testPrivateStatic2()
	{
		$a = new AccessClass('TestAccessProperty');
		$this->assertSame(4, $a->privateStatic);
	}

	public function testProtectedStatic2()
	{
		$a = new AccessClass('TestAccessProperty');
		$this->assertSame(5, $a->protectedStatic);
	}

	public function testPublicStatic2()
	{
		$a = new AccessClass('TestAccessProperty');
		$this->assertSame(6, $a->publicStatic);
	}

	public function testNonStatic()
	{
		$a = new AccessClass('TestAccessProperty');
		$this->setExpectedException('Exception', 'Property TestAccessProperty::$private is not static.');
		$a->private;
	}

	public function testRepeatable()
	{
		$o = new TestAccessProperty;
		$a = new AccessClass($o);
		$this->assertSame(3, $a->public);
		$o->public = 333;
		$this->assertSame(333, $a->public);
	}
}
