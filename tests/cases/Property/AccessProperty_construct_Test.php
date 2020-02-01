<?php

/**
 * @covers AccessProperty::__construct
 * @covers AccessBase::__construct
 * @covers AccessAccessorPhp52
 * @covers AccessAccessor
 */
class AccessProperty_construct_Test extends TestCase
{
	public function testClass()
	{
		$a = new AccessProperty('TestAccessProperty', 'private');
		$this->assertAttributeSame(NULL, 'instance', $a);
		$r = $this->readAttribute($a, 'reflection');
		$this->assertInstanceOf('ReflectionProperty', $r);
		$this->assertSame('TestAccessProperty', $r->getDeclaringClass()->getName());
		$this->assertSame('private', $r->getName());
	}

	public function testObject()
	{
		$o = new TestAccessProperty;
		$a = new AccessProperty($o, 'private');
		$this->assertAttributeSame($o, 'instance', $a);
		$r = $this->readAttribute($a, 'reflection');
		$this->assertInstanceOf('ReflectionProperty', $r);
		$this->assertSame('TestAccessProperty', $r->getDeclaringClass()->getName());
		$this->assertSame('private', $r->getName());
	}

	public function testClassOnParent()
	{
		$a = new AccessProperty('TestAccessProperty2', 'private');
		$this->assertAttributeSame(NULL, 'instance', $a);
		$r = $this->readAttribute($a, 'reflection');
		$this->assertInstanceOf('ReflectionProperty', $r);
		$this->assertSame('TestAccessProperty', $r->getDeclaringClass()->getName());
		$this->assertSame('private', $r->getName());
	}

	public function testObjectOnParent()
	{
		$o = new TestAccessProperty2;
		$a = new AccessProperty($o, 'private');
		$this->assertAttributeSame($o, 'instance', $a);
		$r = $this->readAttribute($a, 'reflection');
		$this->assertInstanceOf('ReflectionProperty', $r);
		$this->assertSame('TestAccessProperty', $r->getDeclaringClass()->getName());
		$this->assertSame('private', $r->getName());
	}

	public function testUnexistsClass()
	{
		$this->setExpectedException('ReflectionException', 'Class FooBar does not exist');
		new AccessProperty('FooBar', 'private');
	}

	public function testUnexistsProperty()
	{
		$this->setExpectedException('ReflectionException', 'Property TestAccessProperty::$fooBar does not exist');
		new AccessProperty('TestAccessProperty', 'fooBar');
	}

	public static function dataProviderPhp55finallyBug1()
	{
		return array(
			array('TestAccessProperty2', 'private'),
			array('TestAccessProperty', 'private'),
			array('TestAccessProperty2', 'protected'),
			array('TestAccessProperty2', 'privateStatic'),
			array('TestAccessProperty', 'privateStatic'),
			array('TestAccessProperty2', 'protectedStatic'),
		);
	}

	public static function dataProviderPhp55finallyBug2()
	{
		return array(
			array('TestAccessProperty2', 'unexist'),
			array('unexist', 'private'),
		);
	}

	/**
	 * @dataProvider dataProviderPhp55finallyBug1
	 */
	public function testPhp55finallyBug1($class, $property)
	{
		if (PHP_VERSION_ID < 50500)
		{
			$this->markTestSkipped('missing finally');
		}
		$class = var_export($class, true);
		$property = var_export($property, true);
		$this->setExpectedException('Exception', 'OKOK');
		$php = <<<EOT
			try
			{
				throw new Exception('OKOK');
			}
			finally
			{
				new AccessProperty($class, $property);
			}
EOT;
		eval($php); // eval only so this file is valid for php <= 5.4 where finally does not exist
	}

	/**
	 * @dataProvider dataProviderPhp55finallyBug2
	 */
	public function testPhp55finallyBug2($class, $property)
	{
		if (PHP_VERSION_ID < 50500)
		{
			$this->markTestSkipped('missing finally');
		}
		$this->setExpectedException('Exception', class_exists($class) ? "Property $class::$$property does not exist" : "Class $class does not exist");
		$class = var_export($class, true);
		$property = var_export($property, true);
		$php = <<<EOT
			try
			{
				throw new Exception('should be suppressed');
			}
			finally
			{
				new AccessProperty($class, $property);
			}
EOT;
		eval($php); // eval only so this file is valid for php <= 5.4 where finally does not exist
	}

}
