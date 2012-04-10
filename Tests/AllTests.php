<?php
/**
 * All tests to be run
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */

class Tests_AllTests
{
    public static function main()
    {
    	//$parameters = array('verbose' => true);
        PHPUnit_TextUI_TestRunner::run(self::suite());//, $parameters);

    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Test Suite');

        $it = new RecursiveIteratorIterator(
        		new RecursiveDirectoryIterator(dirname(__FILE__) . '/Test'));

        for ($it->rewind(); $it->valid(); $it->next())
        {
            // Something like: Test\Application\Modules\Main\Controllers\Index.php
            $path =  "Test\\".$it->getInnerIterator()->getSubPathname();

            // Replace all of the \ with _
            $className = str_replace('\\', "_", $path);
            // Take off the extension
            $className = substr($className, 0, -4);

            require_once($path);
            $suite->addTestSuite($className);

        }

        return $suite;
    }
}