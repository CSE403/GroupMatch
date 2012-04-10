<?php
/**
 * Tests for Saros_Core_Registry
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
class Test_Core_Registry extends Saros_Test_TestCase
{
	protected $backupGlobals = false;

	//protected $registry = null;

	/**
	 * Setup/fixtures for each test
	 */
	//public function setUp()	{
		//$this->registry = new Saros_Core_Registry();
	//}
	public function tearDown() {}

	/**
     * @expectedException Saros_Core_Exception
     */
	public function testNonExistentKeyThrows()
	{
		$this->object->hello;
	}

	public function testImplementsArrayAccess()
	{
		$this->assertTrue($this->object instanceof ArrayAccess);
	}

	public function testMagicFunctionSetGet()
	{
		$var = "hello";
		$this->object->var = $var;
		$this->assertEquals($var, $this->object->var);

		$this->assertEquals($var, $this->object["var"]);
	}

	public function testIterable()
	{
		$this->object->var = "hello";
		$this->object->var2 = "hello2";

		foreach($this->object as $key=>$value)
		{
			if ($key == "var")
				$this->assertEquals("hello", $value);
			elseif($key == "var2")
				$this->assertEquals("hello2", $value);
			else
				$this->fail();
		}
	}

}
