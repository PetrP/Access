<?php

/**
 * @covers AccessProperty::__construct
 * @covers AccessBase::__construct
 * @covers AccessAccessorPhp52
 * @covers AccessAccessor
 */
class AccessProperty_construct_Test extends TestCase
{
	public function testClass()
	{
		$a = new AccessProperty('TestAccessProperty', 'private');
		$this->assertAttributeSame(NULL, 'instance', $a);
		$r = $this->readAttribute($a, 'reflection');
		$this->assertInstanceOf('ReflectionProperty', $r);
		$this->assertSame('TestAccessProperty', $r->getDeclaringClass()->getName());
		$this->assertSame('private', $r->getName());
	}

	public function testObject()
	{
		$o = new TestAccessProperty;
		$a = new AccessProperty($o, 'private');
		$this->assertAttributeSame($o, 'instance', $a);
		$r = $this->readAttribute($a, 'reflection');
		$this->assertInstanceOf('ReflectionProperty', $r);
		$this->assertSame('TestAccessProperty', $r->getDeclaringClass()->getName());
		$this->assertSame('private', $r->getName());
	}

	public function testClassOnParent()
	{
		$a = new AccessProperty('TestAccessProperty2', 'private');
		$this->assertAttributeSame(NULL, 'instance', $a);
		$r = $this->readAttribute($a, 'reflection');
		$this->assertInstanceOf('ReflectionProperty', $r);
		$this->assertSame('TestAccessProperty', $r->getDeclaringClass()->getName());
		$this->assertSame('private', $r->getName());
	}

	public function testObjectOnParent()
	{
		$o = new TestAccessProperty2;
		$a = new AccessProperty($o, 'private');
		$this->assertAttributeSame($o, 'instance', $a);
		$r = $this->readAttribute($a, 'reflection');
		$this->assertInstanceOf('ReflectionProperty', $r);
		$this->assertSame('TestAccessProperty', $r->getDeclaringClass()->getName());
		$this->assertSame('private', $r->getName());
	}

	public function testUnexistsClass()
	{
		$this->setExpectedException('ReflectionException', 'Class FooBar does not exist');
		new AccessProperty('FooBar', 'private');
	}

	public function testUnexistsProperty()
	{
		$this->setExpectedException('ReflectionException', 'Property TestAccessProperty::$fooBar does not exist');
		new AccessProperty('TestAccessProperty', 'fooBar');
	}
}
