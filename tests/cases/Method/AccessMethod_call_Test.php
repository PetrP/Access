<?php

/**
 * @covers AccessMethod::call
 */
class AccessMethod_call_Test extends TestCase
{
	public function test()
	{
		$a = new AccessMethod(new TestAccessMethod, '_private');
		$this->assertSame(1, $a->call());
	}

	public function testArgs()
	{
		$a = new AccessMethod(new TestAccessMethod, 'args');
		$this->assertSame(array(1, 2, 3), $a->call(1, 2, 3));
	}
}
