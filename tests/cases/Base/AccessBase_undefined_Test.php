<?php

/**
 * @covers AccessBase::__call
 * @covers AccessBase::__callStatic
 * @covers AccessBase::__get
 * @covers AccessBase::__set
 * @covers AccessBase::__isset
 * @covers AccessBase::__unset
 */
class AccessBase_undefined_Test extends TestCase
{
	private $a;

	protected function setUp()
	{
		$this->a = new AccessProperty('TestAccessProperty', 'private');
	}

	public function testCall()
	{
		$this->setExpectedException('Exception', 'Call to undefined method AccessProperty::name().');
		$this->a->__call('name', array());
	}

	public function testCallStatic()
	{
		$this->checkPhpVersion(50300, '__callStatic');
		$class = PHP_VERSION_ID < 50300 ? 'AccessBase' : 'AccessProperty'; // no get_called_class
		$this->setExpectedException('Exception', "Call undefined static method {$class}::name().");
		$this->a->__callStatic('name', array());
	}

	public function testGet()
	{
		$this->setExpectedException('Exception', 'Cannot read undeclared property AccessProperty::$name.');
		$this->a->__get('name');
	}

	public function testSet()
	{
		$this->setExpectedException('Exception', 'Cannot write to undeclared property AccessProperty::$name.');
		$this->a->__set('name', NULL);
	}

	public function testIsset()
	{
		$this->setExpectedException('Exception', 'Cannot check existence of property AccessProperty::$name.');
		$this->a->__isset('name');
	}

	public function testUnset()
	{
		$this->setExpectedException('Exception', 'Cannot unset property AccessProperty::$name.');
		$this->a->__unset('name');
	}
}
