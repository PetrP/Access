<?php

/**
 * @covers ::Access
 */
class Access_Test extends TestCase
{

	public function testClass()
	{
		$a = Access('TestAccessProperty');
		$this->assertInstanceOf('AccessClass', $a);
		$this->assertAttributeSame(NULL, 'instance', $a);
		$this->assertSame('TestAccessProperty', $this->readAttribute($a, 'reflection')->getName());
	}

	public function testObject()
	{
		$o = new TestAccessProperty;
		$a = Access($o);
		$this->assertInstanceOf('AccessClass', $a);
		$this->assertAttributeSame($o, 'instance', $a);
		$this->assertSame('TestAccessProperty', $this->readAttribute($a, 'reflection')->getName());
	}

	public function testClassProperty()
	{
		$a = Access('TestAccessProperty', '$private');
		$this->assertInstanceOf('AccessProperty', $a);
		$this->assertAttributeSame(NULL, 'instance', $a);
		$this->assertSame('TestAccessProperty', $this->readAttribute($a, 'reflection')->getDeclaringClass()->getName());
		$this->assertSame('private', $this->readAttribute($a, 'reflection')->getName());
	}

	public function testObjectProperty()
	{
		$o = new TestAccessProperty;
		$a = Access($o, '$private');
		$this->assertInstanceOf('AccessProperty', $a);
		$this->assertAttributeSame($o, 'instance', $a);
		$this->assertSame('TestAccessProperty', $this->readAttribute($a, 'reflection')->getDeclaringClass()->getName());
		$this->assertSame('private', $this->readAttribute($a, 'reflection')->getName());
	}

	public function testClassMethod()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$a = Access('TestAccessMethod', '_private');
		$this->assertInstanceOf('AccessMethod', $a);
		$this->assertAttributeSame(NULL, 'instance', $a);
		$this->assertSame('TestAccessMethod', $this->readAttribute($a, 'reflection')->getDeclaringClass()->getName());
		$this->assertSame('_private', $this->readAttribute($a, 'reflection')->getName());
	}

	public function testClassMethodProtected()
	{
		$a = Access('TestAccessMethod', '_protected');
		$this->assertInstanceOf('AccessMethod', $a);
		$this->assertAttributeSame(NULL, 'instance', $a);
		$this->assertSame('TestAccessMethod', $this->readAttribute($a, 'reflection')->getDeclaringClass()->getName());
		$this->assertSame('_protected', $this->readAttribute($a, 'reflection')->getName());
	}

	public function testObjectMethod()
	{
		$this->expectedExceptionBeforePhpVersion(50300, 'Exception', 'AccessMethod needs PHP 5.3.2 or newer to call private method.');
		$o = new TestAccessMethod;
		$a = Access($o, '_private');
		$this->assertInstanceOf('AccessMethod', $a);
		$this->assertAttributeSame($o, 'instance', $a);
		$this->assertSame('TestAccessMethod', $this->readAttribute($a, 'reflection')->getDeclaringClass()->getName());
		$this->assertSame('_private', $this->readAttribute($a, 'reflection')->getName());
	}

	public function testObjectMethodProtected()
	{
		$o = new TestAccessMethod;
		$a = Access($o, '_protected');
		$this->assertInstanceOf('AccessMethod', $a);
		$this->assertAttributeSame($o, 'instance', $a);
		$this->assertSame('TestAccessMethod', $this->readAttribute($a, 'reflection')->getDeclaringClass()->getName());
		$this->assertSame('_protected', $this->readAttribute($a, 'reflection')->getName());
	}
}
