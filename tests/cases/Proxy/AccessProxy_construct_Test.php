<?php

/**
 * @covers AccessProxy::__construct
 * @covers AccessProxy::unproxy
 * @covers AccessAccessorPhp52
 * @covers AccessAccessor
 */
class AccessProxy_construct_Test extends TestCase
{

	public function testClass()
	{
		$a = new AccessProxy('TestAccessProperty');
		$this->assertAttributeSame(null, 'instance', $a);
		$r = $this->readAttribute($a, 'reflection');
		$this->assertInstanceOf('ReflectionClass', $r);
		$this->assertSame('TestAccessProperty', $r->getName());
	}

	public function testObject()
	{
		$o = new TestAccessProperty;
		$a = new AccessProxy($o);
		$this->assertAttributeSame($o, 'instance', $a);
		$r = $this->readAttribute($a, 'reflection');
		$this->assertInstanceOf('ReflectionClass', $r);
		$this->assertSame('TestAccessProperty', $r->getName());
	}

	public function testUnexistsClass()
	{
		if (PHP_VERSION_ID >= 80000)
		{
			$this->setExpectedException('ReflectionException', 'Class "FooBar" does not exist');
		}
		else
		{
			$this->setExpectedException('ReflectionException', 'Class FooBar does not exist');
		}
		new AccessProxy('FooBar');
	}

	public function testArray()
	{
		$a = new AccessProxy(array());
		$this->assertAttributeSame(array(), 'instance', $a);
	}

	public function testBad()
	{
		$this->setExpectedException('Exception', 'Instance must be array or object or class name.');
		new AccessProxy(123);
	}

}
