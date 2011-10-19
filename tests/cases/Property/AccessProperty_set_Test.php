<?php

/**
 * @covers AccessProperty::set
 * @covers AccessProperty::check
 */
class AccessProperty_set_Test extends TestCase
{
	public function testPrivate()
	{
		$o = new TestAccessProperty;
		$a = new AccessProperty($o, 'private');
		$this->assertSame(NULL, $a->set(111));
		$this->assertAttributeSame(111, 'private', $o);
	}

	public function testProtected()
	{
		$o = new TestAccessProperty;
		$a = new AccessProperty($o, 'protected');
		$this->assertSame(NULL, $a->set(222));
		$this->assertAttributeSame(222, 'protected', $o);
	}

	public function testPublic()
	{
		$o = new TestAccessProperty;
		$a = new AccessProperty($o, 'public');
		$this->assertSame(NULL, $a->set(333));
		$this->assertAttributeSame(333, 'public', $o);
	}

	public function testPrivateStatic1()
	{
		$o = new TestAccessProperty;
		$a = new AccessProperty($o, 'privateStatic');
		$this->assertSame(NULL, $a->set(444));
		$this->assertAttributeSame(444, 'privateStatic', 'TestAccessProperty');
		$this->assertSame(NULL, $a->set(4));
	}

	public function testProtectedStatic1()
	{
		$o = new TestAccessProperty;
		$a = new AccessProperty($o, 'protectedStatic');
		$this->assertSame(NULL, $a->set(555));
		$this->assertAttributeSame(555, 'protectedStatic', 'TestAccessProperty');
		$this->assertSame(NULL, $a->set(5));
	}

	public function testPublicStatic1()
	{
		$o = new TestAccessProperty;
		$a = new AccessProperty($o, 'publicStatic');
		$this->assertSame(NULL, $a->set(666));
		$this->assertAttributeSame(666, 'publicStatic', 'TestAccessProperty');
		$this->assertSame(NULL, $a->set(6));
	}

	public function testPrivateStatic2()
	{
		$a = new AccessProperty('TestAccessProperty', 'privateStatic');
		$this->assertSame(NULL, $a->set(444));
		$this->assertAttributeSame(444, 'privateStatic', 'TestAccessProperty');
		$this->assertSame(NULL, $a->set(4));
	}

	public function testProtectedStatic2()
	{
		$a = new AccessProperty('TestAccessProperty', 'protectedStatic');
		$this->assertSame(NULL, $a->set(555));
		$this->assertAttributeSame(555, 'protectedStatic', 'TestAccessProperty');
		$this->assertSame(NULL, $a->set(5));
	}

	public function testPublicStatic2()
	{
		$a = new AccessProperty('TestAccessProperty', 'publicStatic');
		$this->assertSame(NULL, $a->set(666));
		$this->assertAttributeSame(666, 'publicStatic', 'TestAccessProperty');
		$this->assertSame(NULL, $a->set(6));
	}

	public function testNonStatic()
	{
		$a = new AccessProperty('TestAccessProperty', 'private');
		$this->setExpectedException('Exception', 'Property TestAccessProperty::$private is not static.');
		$a->set(111);
	}
}
