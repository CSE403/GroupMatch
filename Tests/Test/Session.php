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
class Test_Session extends PHPUnit_Framework_TestCase
{
	protected $backupGlobals = false;

	public function tearDown() {}

	public static function tearDownAfterClass()
	{
		session_destroy();
	}
	/**
	*test get, set
	* iterable, count
	*
	* set a var in one, its updated in the other
	*
	* can't start twice
	*/
    public function testVarExists()
    {
		$sess1 = new Saros_Session("testSet");
		$sess1->name = "foo";

		$this->assertSame("foo", $sess1->name);
    }

    public function testSameInTwoInstances()
    {
		$sess1 = new Saros_Session("testMultiple", true);
		$sess1->name = "foo";

		$sess2 = new Saros_Session("testMultiple", true);
		$this->assertSame("foo", $sess2->name);

		$this->assertSame("foo", $sess2['name']);
    }

    /**
     * @expectedException Saros_Session_Exception
     */
	public function testSameNamespaceThrows()
	{
		$sess1 = new Saros_Session("name");
		$sess2 = new Saros_Session("name");
	}

}


