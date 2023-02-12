<?php

/**
 * @covers AccessClass::asInstance
 * @covers AccessBase::asInstance
 * @covers AccessAccessorPhp52
 * @covers AccessAccessor
 */
class AccessClass_asInstance_Test extends TestCase
{
	public function test1()
	{
		$o1 = new TestAccessMethod;
		$o2 = new TestAccessMethod;
		$a = new AccessClass('TestAccessMethod');
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
		$a = new AccessClass('TestAccessMethod');
		$a->asInstance($o1);
		$a->public = 111;
		$a->asInstance($o2);
		$a->public = 222;
		$this->assertSame(111, $o1->public);
		$this->assertSame(222, $o2->public);
	}

	public function testReturn()
	{
		$a = new AccessClass('TestAccessMethod');
		$this->assertSame($a, $a->asInstance(new TestAccessMethod));
	}

	public function testObject()
	{
		$o = new TestAccessMethod;
		$a = new AccessClass('TestAccessMethod');
		$this->assertAttributeSame(null, 'instance', $a);
		$a->asInstance($o);
		$this->assertAttributeSame($o, 'instance', $a);
	}

	public function testNull()
	{
		$o = new TestAccessMethod;
		$a = new AccessClass($o);
		$this->assertAttributeSame($o, 'instance', $a);
		$a->asInstance(null);
		$this->assertAttributeSame(null, 'instance', $a);
	}

	public function testBad()
	{
		$o = new TestAccessMethod;
		$a = new AccessClass($o);
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
		$a = new AccessClass('TestAccessMethod');
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
}
