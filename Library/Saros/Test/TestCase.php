<?php
namespace Saros\Test;

class TestCase extends \PHPUnit_Framework_TestCase
{
	protected $object;
	/**
	* This can be overridden if needed, but overriding
	* methods should ALWAYS call parent::setUp();
	*
	*/
	public function setUp()
	{
		// We are assuming that every test that inherits from this
		// will be testing a class that is the name of the test but with
		// Test_ removed
		$className = get_class($this);
		$className = "Saros".substr($className, 4);
		$this->object = new $className();
	}
}