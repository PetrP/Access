<?php

/**
 * @covers AccessMethod::__construct
 * @covers AccessBase::__construct
 */
class AccessMethod_construct_Test extends TestCase
{
	public function testClass()
	{
		$a = new AccessMethod('TestAccessMethod', '_private');
		$this->assertAttributeSame(NULL, 'instance', $a);
		$r = $this->readAttribute($a, 'reflection');
		$this->assertInstanceOf('ReflectionMethod', $r);
		$this->assertSame('TestAccessMethod', $r->getDeclaringClass()->getName());
		$this->assertSame('_private', $r->getName());
	}

	public function testObject()
	{
		$o = new TestAccessMethod;
		$a = new AccessMethod($o, '_private');
		$this->assertAttributeSame($o, 'instance', $a);
		$r = $this->readAttribute($a, 'reflection');
		$this->assertInstanceOf('ReflectionMethod', $r);
		$this->assertSame('TestAccessMethod', $r->getDeclaringClass()->getName());
		$this->assertSame('_private', $r->getName());
	}

	public function testUnexistsClass()
	{
		$this->setExpectedException('ReflectionException', 'Class FooBar does not exist');
		new AccessMethod('FooBar', '_private');
	}

	public function testUnexistsMethod()
	{
		$this->setExpectedException('ReflectionException', 'Method TestAccessMethod::fooBar() does not exist');
		new AccessMethod('TestAccessMethod', 'fooBar');
	}
}
