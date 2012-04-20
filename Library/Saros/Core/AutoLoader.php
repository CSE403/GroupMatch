<?php
namespace Saros\Core;

/**
* This class is responsible for helping to load all missing classes
*
* @copyright Eli White & SaroSoftware 2010
* @license http://www.gnu.org/licenses/gpl.html GNU GPL
*
* @package SarosFramework
* @author Eli White
* @link http://sarosoftware.com
* @link http://github.com/TheSavior/Saros-Framework
*/
class AutoLoader
{
    /**
    * Convert a class name to the expected file location
    * of that class
    *
    * @param string $classname The name of the class to convert
    */
    public static function class2File($classname)
    {
        // Replace all of the underscores with slashes to find the path
        $fileLocation = str_replace("\\","/", str_replace("_", "/", $classname)).".php";
        return $fileLocation;
    }

    /**
    * Attempt to include the file that contains the class
    * specified by $classname. Attempts to support named libraries
    * that follow the Saros naming convention.
    *
    * @param string $classname The name of the class to find.
    *
    */
    public static function autoload($classname)
    {
        // Skip PHPUnit files
        if(false !== strpos($classname, 'PHPUnit_')) {
            return false;
        }
        
        // Convert the class name to an array of parts
        $parts = explode("\\",$classname);

        // Convert that classname to a filename
        $fileName = self::class2File($classname);

        /*
        This is the root of the framework, this is disgusting
        but it is the best way to go 4 directories up.
        We are currently at /Library/Saros/Core/AutoLoader.php
        the first dirname gets us to
        /Library/Saros/Core
        next: /Library/Saros
        next: /Library
        last:

        We need to get to the root relative to our FULL file path (__file__)
        because we might be included from outside the root, and via an include_path
        */
        $frameworkRoot = dirname(dirname(dirname(dirname(__FILE__))))."/";

        if (file_exists($frameworkRoot.$fileName)) {
            require_once($frameworkRoot.$fileName);
        }

        else if(is_dir($frameworkRoot."Library/".$parts[0]))
        {
            // We want to check for named libraries
            // It is a named library when $parts[0] matches a folder in Library
            require_once($frameworkRoot."Library/".$fileName);
        }
        else
        {
           

            // We don't know where this class exists. Maybe there is another autoloader that does
            return false;

        }
    }
}