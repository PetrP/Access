<?php

/**
 * @covers AccessClass::__construct
 * @covers AccessAccessorPhp52
 * @covers AccessAccessor
 */
class AccessClass_construct_Test extends TestCase
{
	public function testClass()
	{
		$a = new AccessClass('TestAccessProperty');
		$this->assertAttributeSame(null, 'instance', $a);
		$r = $this->readAttribute($a, 'reflection');
		$this->assertInstanceOf('ReflectionClass', $r);
		$this->assertSame('TestAccessProperty', $r->getName());
	}

	public function testObject()
	{
		$o = new TestAccessProperty;
		$a = new AccessClass($o);
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
		new AccessClass('FooBar');
	}

}
