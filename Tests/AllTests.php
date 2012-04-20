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
        \PHPUnit_TextUI_TestRunner::run(self::suite());//, $parameters);

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
            
            //echo $path."\n\n";
            
            // Replace all of the \ with _
            //$className = str_replace('\\', "_", $path);
            
            // Take off the extension
            $className = substr($path, 0, -4);

            echo $path."\n";
            echo $className."\n\n";
            
            require_once($path);
            $obj = new $className;
                     
            $suite->addTestSuite($obj);
        }                      
        
        return $suite;
    }
}