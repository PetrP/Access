<?php

/**
 * @covers AccessProxy::offsetExists
 * @covers AccessProxy::offsetGet
 * @covers AccessProxy::offsetSet
 * @covers AccessProxy::offsetUnset
 * @covers AccessProxy::proxy
 * @covers AccessProxy::unproxy
 * @covers AccessProxy::propagate
 * @covers AccessAccessorPhp52
 * @covers AccessAccessor
 */
class AccessProxy_array_Test extends TestCase
{

	public function testArray()
	{
		$a = new AccessProxy(array());
		$a['foo'] = $this;
		$this->assertSame(true, isset($a['foo']));
		$this->assertInstanceOf('AccessProxy', $a['foo']);
		$this->assertSame($this, $a['foo']->getInstance());
		$this->assertSame(array('foo' => $this), $a->getInstance());

		unset($a['foo']);
		$this->assertSame(false, isset($a['foo']));
		$this->assertSame(array(), $a->getInstance());

		$a['foo'] = array();
		$a['foo']['bar'] = array();
		$a['foo']['bar'][] = $this;
		$a['foo']['bar'][1] = $this;
		$a['foo']['bar'][] = $this;
		$this->assertSame(array('foo' => array('bar' => array($this, $this, $this))), $a->getInstance());
		$this->assertInstanceOf('AccessProxy', $a['foo']);
		$this->assertInstanceOf('AccessProxy', $a['foo']['bar']);
		$this->assertInstanceOf('AccessProxy', $a['foo']['bar'][0]);
		$this->assertInstanceOf('AccessProxy', $a['foo']['bar'][1]);
		$this->assertInstanceOf('AccessProxy', $a['foo']['bar'][2]);
		$this->assertSame(array('bar' => array($this, $this, $this)), $a['foo']->getInstance());
		$this->assertSame($this, $a['foo']['bar'][0]->getInstance());
	}

	public function testArrayAccess()
	{
		$o = new ArrayObject;
		$a = new AccessProxy($o);
		$a['foo'] = $this;
		$this->assertSame(true, isset($a['foo']));
		$this->assertInstanceOf('AccessProxy', $a['foo']);
		$this->assertSame($this, $a['foo']->getInstance());
		$this->assertSame($o, $a->getInstance());

		unset($a['foo']);
		$this->assertSame(false, isset($a['foo']));
		$this->assertSame($o, $a->getInstance());
	}

}
