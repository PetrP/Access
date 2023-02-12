<?php

/**
 * @covers AccessMethod::__construct
 * @covers AccessBase::__construct
 * @covers AccessAccessorPhp52
 * @covers AccessAccessor
 */
class AccessMethod_construct_Test extends TestCase
{
	public function testClass()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$a = new AccessMethod('TestAccessMethod', '_private');
		$this->assertAttributeSame(null, 'instance', $a);
		$r = $this->readAttribute($a, 'reflection');
		$this->assertInstanceOf('ReflectionMethod', $r);
		$this->assertSame('TestAccessMethod', $r->getDeclaringClass()->getName());
		$this->assertSame('_private', $r->getName());
	}

	public function testClassProtected()
	{
		$a = new AccessMethod('TestAccessMethod', '_protected');
		$this->assertAttributeSame(null, 'instance', $a);
		$r = $this->readAttribute($a, 'reflection');
		$this->assertInstanceOf('ReflectionMethod', $r);
		$this->assertSame('TestAccessMethod', $r->getDeclaringClass()->getName());
		$this->assertSame('_protected', $r->getName());
	}

	public function testObject()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$o = new TestAccessMethod;
		$a = new AccessMethod($o, '_private');
		$this->assertAttributeSame($o, 'instance', $a);
		$r = $this->readAttribute($a, 'reflection');
		$this->assertInstanceOf('ReflectionMethod', $r);
		$this->assertSame('TestAccessMethod', $r->getDeclaringClass()->getName());
		$this->assertSame('_private', $r->getName());
	}

	public function testObjectProtected()
	{
		$o = new TestAccessMethod;
		$a = new AccessMethod($o, '_protected');
		$this->assertAttributeSame($o, 'instance', $a);
		$r = $this->readAttribute($a, 'reflection');
		$this->assertInstanceOf('ReflectionMethod', $r);
		$this->assertSame('TestAccessMethod', $r->getDeclaringClass()->getName());
		$this->assertSame('_protected', $r->getName());
	}

	public function testClassOnParent()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$a = new AccessMethod('TestAccessMethod2', '_private');
		$this->assertAttributeSame(null, 'instance', $a);
		$r = $this->readAttribute($a, 'reflection');
		$this->assertInstanceOf('ReflectionMethod', $r);
		$this->assertSame('TestAccessMethod', $r->getDeclaringClass()->getName());
		$this->assertSame('_private', $r->getName());
	}

	public function testClassOnParentProtected()
	{
		$a = new AccessMethod('TestAccessMethod2', '_protected');
		$this->assertAttributeSame(null, 'instance', $a);
		$r = $this->readAttribute($a, 'reflection');
		$this->assertInstanceOf('ReflectionMethod', $r);
		$this->assertSame('TestAccessMethod', $r->getDeclaringClass()->getName());
		$this->assertSame('_protected', $r->getName());
	}

	public function testObjectOnParent()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$o = new TestAccessMethod2;
		$a = new AccessMethod($o, '_private');
		$this->assertAttributeSame($o, 'instance', $a);
		$r = $this->readAttribute($a, 'reflection');
		$this->assertInstanceOf('ReflectionMethod', $r);
		$this->assertSame('TestAccessMethod', $r->getDeclaringClass()->getName());
		$this->assertSame('_private', $r->getName());
	}

	public function testObjectOnParentProtected()
	{
		$o = new TestAccessMethod2;
		$a = new AccessMethod($o, '_protected');
		$this->assertAttributeSame($o, 'instance', $a);
		$r = $this->readAttribute($a, 'reflection');
		$this->assertInstanceOf('ReflectionMethod', $r);
		$this->assertSame('TestAccessMethod', $r->getDeclaringClass()->getName());
		$this->assertSame('_protected', $r->getName());
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
		new AccessMethod('FooBar', '_private');
	}

	public function testUnexistsMethod()
	{
		$this->setExpectedException('ReflectionException', 'Method TestAccessMethod::fooBar() does not exist');
		new AccessMethod('TestAccessMethod', 'fooBar');
	}
}
