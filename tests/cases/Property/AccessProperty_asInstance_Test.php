<?php

/**
 * @covers AccessProperty::asInstance
 * @covers AccessBase::asInstance
 */
class AccessProperty_asInstance_Test extends TestCase
{
	public function test()
	{
		$o1 = new TestAccessProperty;
		$o2 = new TestAccessProperty;
		$a = new AccessProperty('TestAccessProperty', 'public');
		$a->asInstance($o1);
		$a->set(111);
		$a->asInstance($o2);
		$a->set(222);
		$this->assertSame(111, $o1->public);
		$this->assertSame(222, $o2->public);
	}

	public function testReturn()
	{
		$a = new AccessProperty('TestAccessProperty', 'public');
		$this->assertSame($a, $a->asInstance(new TestAccessProperty));
	}

	public function testObject()
	{
		$o = new TestAccessProperty;
		$a = new AccessProperty('TestAccessProperty', 'public');
		$this->assertAttributeSame(NULL, 'instance', $a);
		$a->asInstance($o);
		$this->assertAttributeSame($o, 'instance', $a);
	}

	public function testNull()
	{
		$o = new TestAccessProperty;
		$a = new AccessProperty($o, 'public');
		$this->assertAttributeSame($o, 'instance', $a);
		$a->asInstance(NULL);
		$this->assertAttributeSame(NULL, 'instance', $a);
	}

	public function testBad()
	{
		$o = new TestAccessProperty;
		$a = new AccessProperty($o, 'public');
		try {
			$a->asInstance(123);
			$this->fail();
		} catch (Exception $e) {}

		$this->assertAttributeSame($o, 'instance', $a);
		$this->setExpectedException('Exception', 'Instance must be object or NULL.');
		throw $e;
	}

	public function testDiferentObject()
	{
		$a = new AccessProperty('TestAccessProperty', 'public');
		try {
			$a->asInstance($this);
			$this->fail();
		} catch (Exception $e) {}

		$this->assertAttributeSame(NULL, 'instance', $a);
		$this->setExpectedException('Exception', 'Must be instance of accessible class.');
		throw $e;
	}
}
