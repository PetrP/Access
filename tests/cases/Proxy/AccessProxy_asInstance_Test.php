<?php

/**
 * @covers AccessProxy::asInstance
 * @covers AccessAccessorPhp52
 * @covers AccessAccessor
 */
class AccessProxy_asInstance_Test extends TestCase
{

	public function test1()
	{
		$o1 = new TestAccessMethod;
		$o2 = new TestAccessMethod;
		$a = new AccessProxy('TestAccessMethod');
		$a->asInstance($o1);
		$a->setProperty(111);
		$a->asInstance($o2);
		$a->setProperty(222);
		$this->assertSame(111, $o1->public);
		$this->assertSame(222, $o2->public);
	}

	public function test2()
	{
		$o1 = new TestAccessMethod;
		$o2 = new TestAccessMethod;
		$a = new AccessProxy('TestAccessMethod');
		$a->asInstance($o1);
		$a->public = 111;
		$a->asInstance($o2);
		$a->public = 222;
		$this->assertSame(111, $o1->public);
		$this->assertSame(222, $o2->public);
	}

	public function testReturn()
	{
		$a = new AccessProxy('TestAccessMethod');
		$this->assertSame($a, $a->asInstance(new TestAccessMethod));
	}

	public function testObject()
	{
		$o = new TestAccessMethod;
		$a = new AccessProxy('TestAccessMethod');
		$this->assertAttributeSame(null, 'instance', $a);
		$a->asInstance($o);
		$this->assertAttributeSame($o, 'instance', $a);
	}

	public function testNull()
	{
		$o = new TestAccessMethod;
		$a = new AccessProxy($o);
		$this->assertAttributeSame($o, 'instance', $a);
		$a->asInstance(null);
		$this->assertAttributeSame(null, 'instance', $a);
	}

	public function testBad()
	{
		$o = new TestAccessMethod;
		$a = new AccessProxy($o);
		try
		{
			$a->asInstance(123);
			$this->fail();
		}
		catch (Exception $e) {}

		$this->assertAttributeSame($o, 'instance', $a);
		$this->setExpectedException('Exception', 'Instance must be object or null.');
		throw $e;
	}

	public function testDiferentObject()
	{
		$a = new AccessProxy('TestAccessMethod');
		try
		{
			$a->asInstance($this);
			$this->fail();
		}
		catch (Exception $e) {}

		$this->assertAttributeSame(null, 'instance', $a);
		$this->setExpectedException('Exception', 'Must be instance of accessible class.');
		throw $e;
	}

	public function testArray()
	{
		$a = new AccessProxy(array('foo'));
		$this->assertAttributeSame(array('foo'), 'instance', $a);
		$r = $a->asInstance(array('bar'));
		$this->assertSame($r, $a);
		$this->assertAttributeSame(array('bar'), 'instance', $a);
	}

	public function testArrayBad1()
	{
		$a = new AccessProxy(array());
		try
		{
			$a->asInstance($this);
			$this->fail();
		}
		catch (Exception $e) {}

		$this->assertAttributeSame(array(), 'instance', $a);
		$this->setExpectedException('Exception', 'Instance must be array');
		throw $e;
	}

	public function testArrayBad2()
	{
		$a = new AccessProxy($this);
		try
		{
			$a->asInstance(array());
			$this->fail();
		}
		catch (Exception $e) {}

		$this->assertAttributeSame($this, 'instance', $a);
		$this->setExpectedException('Exception', 'Instance must be object or null.');
		throw $e;
	}

}
