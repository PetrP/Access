<?php

class Php52Callback
{

	/** @var array Simulate closure scope in php 5.2 @access private */
	static $vars = array();

	/**
	 * Simulate closure scope in php 5.2
	 * <code>
	 * 	function () use ($foo, $bar) {}
	 * </code>
	 * <code>
	 * 	create_function('', 'extract(Php52Callback::$vars['.Callback::uses(array('foo'=>$foo,'bar'=>$bar)).'], EXTR_REFS);')
	 * </code>
	 * @access private
	 * @see Builder\PhpParser::replaceClosures()
	 * @param array
	 * @return int
	 */
	static function uses($args)
	{
		self::$vars[] = $args;
		return count(self::$vars)-1;
	}

}
