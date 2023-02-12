<?php

/**
 * @covers AccessProxy::getInstance
 * @covers AccessAccessorPhp52
 * @covers AccessAccessor
 */
class AccessProxy_getInstance_Test extends TestCase
{

	public function testString()
	{
		$o = new TestAccessMethod;
		$a = new AccessProxy('TestAccessMethod');
		$this->assertSame(null, $a->getInstance());
		$a->asInstance(null);
		$this->assertSame(null, $a->getInstance());
		$a->asInstance($o);
		$this->assertSame($o, $a->getInstance());
	}

	public function testObject()
	{
		$o = new TestAccessMethod;
		$o2 = new TestAccessMethod;
		$a = new AccessProxy($o);
		$this->assertSame($o, $a->getInstance());
		$a->asInstance(null);
		$this->assertSame(null, $a->getInstance());
		$a->asInstance($o2);
		$this->assertSame($o2, $a->getInstance());
	}

	public function testArray()
	{
		$a = new AccessProxy(array('foo'));
		$this->assertSame(array('foo'), $a->getInstance());
		$a->asInstance(array('bar'));
		$this->assertSame(array('bar'), $a->getInstance());
	}

}
