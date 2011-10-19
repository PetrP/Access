<?php

/**
 * @covers AccessMethod::asInstance
 * @covers AccessBase::asInstance
 */
class AccessMethod_asInstance_Test extends TestCase
{
	public function test()
	{
		$o1 = new TestAccessMethod;
		$o2 = new TestAccessMethod;
		$a = new AccessMethod('TestAccessMethod', 'setProperty');
		$a->asInstance($o1);
		$a->call(111);
		$a->asInstance($o2);
		$a->call(222);
		$this->assertSame(111, $o1->public);
		$this->assertSame(222, $o2->public);
	}

	public function testReturn()
	{
		$a = new AccessMethod('TestAccessMethod', 'setProperty');
		$this->assertSame($a, $a->asInstance(new TestAccessMethod));
	}

	public function testObject()
	{
		$o = new TestAccessMethod;
		$a = new AccessMethod('TestAccessMethod', 'setProperty');
		$this->assertAttributeSame(NULL, 'instance', $a);
		$a->asInstance($o);
		$this->assertAttributeSame($o, 'instance', $a);
	}

	public function testNull()
	{
		$o = new TestAccessMethod;
		$a = new AccessMethod($o, 'setProperty');
		$this->assertAttributeSame($o, 'instance', $a);
		$a->asInstance(NULL);
		$this->assertAttributeSame(NULL, 'instance', $a);
	}

	public function testBad()
	{
		$o = new TestAccessMethod;
		$a = new AccessMethod($o, 'setProperty');
		try {
			$a->asInstance(123);
			$this->fail();
		} catch (Exception $e) {}

		$this->assertAttributeSame($o, 'instance', $a);
		$this->setExpectedException('Exception', 'Instance must be object or NULL.');
		throw $e;
	}
}
