<?php

/**
 * @covers AccessClass::__set
 */
class AccessClass_set_Test extends TestCase
{
	public function testPrivate()
	{
		$o = new TestAccessProperty;
		$a = new AccessClass($o);
		$a->private = 111;
		$this->assertAttributeSame(111, 'private', $o);
	}

	public function testPrivateOnParent()
	{
		$o = new TestAccessProperty2;
		$a = new AccessClass($o);
		$a->private = 111;
		$this->assertAttributeSame(111, 'private', $o);
	}

	public function testProtected()
	{
		$o = new TestAccessProperty;
		$a = new AccessClass($o);
		$a->protected = 222;
		$this->assertAttributeSame(222, 'protected', $o);
	}

	public function testPublic()
	{
		$o = new TestAccessProperty;
		$a = new AccessClass($o);
		$a->public = 333;
		$this->assertAttributeSame(333, 'public', $o);
	}

	public function testPrivateStatic1()
	{
		$o = new TestAccessProperty;
		$a = new AccessClass($o);
		$a->privateStatic = 444;
		$this->assertAttributeSame(444, 'privateStatic', 'TestAccessProperty');
		$a->privateStatic = 4;
	}

	public function testPrivateOnParentStatic1()
	{
		$o = new TestAccessProperty2;
		$a = new AccessClass($o);
		$a->privateStatic = 444;
		$this->assertAttributeSame(444, 'privateStatic', 'TestAccessProperty');
		$a->privateStatic = 4;
	}

	public function testProtectedStatic1()
	{
		$o = new TestAccessProperty;
		$a = new AccessClass($o);
		$a->protectedStatic = 555;
		$this->assertAttributeSame(555, 'protectedStatic', 'TestAccessProperty');
		$a->protectedStatic = 5;
	}

	public function testPublicStatic1()
	{
		$o = new TestAccessProperty;
		$a = new AccessClass($o);
		$a->publicStatic = 666;
		$this->assertAttributeSame(666, 'publicStatic', 'TestAccessProperty');
		$a->publicStatic = 6;
	}

	public function testPrivateStatic2()
	{
		$a = new AccessClass('TestAccessProperty');
		$a->privateStatic = 444;
		$this->assertAttributeSame(444, 'privateStatic', 'TestAccessProperty');
		$a->privateStatic = 4;
	}

	public function testPrivateOnParentStatic2()
	{
		$a = new AccessClass('TestAccessProperty2');
		$a->privateStatic = 444;
		$this->assertAttributeSame(444, 'privateStatic', 'TestAccessProperty');
		$a->privateStatic = 4;
	}

	public function testProtectedStatic2()
	{
		$a = new AccessClass('TestAccessProperty');
		$a->protectedStatic = 555;
		$this->assertAttributeSame(555, 'protectedStatic', 'TestAccessProperty');
		$a->protectedStatic = 5;
	}

	public function testPublicStatic2()
	{
		$a = new AccessClass('TestAccessProperty');
		$a->publicStatic = 666;
		$this->assertAttributeSame(666, 'publicStatic', 'TestAccessProperty');
		$a->publicStatic = 6;
	}

	public function testNonStatic()
	{
		$a = new AccessClass('TestAccessProperty');
		$this->setExpectedException('Exception', 'Property TestAccessProperty::$private is not static.');
		$a->private = 111;
	}
}
