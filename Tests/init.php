<?php

/**
 * Our Test Runner
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */

error_reporting(E_ALL);

define("ROOT_PATH",  realpath(dirname(dirname(__FILE__)))."/");

// This is needed to allow us to load fixtures
function autoload($classname)
{
    // Skip PHPUnit files
    //if(false !== strpos($classname, 'PHPUnit_')) {
    //    return false;
    //}
    
    $parts = explode("_",$classname);

	$fileLocation = implode('/',$parts).".php";
    
    //echo $fileLocation;
    /*if (false !== strpos($classname, "Fixture")){
        die(getcwd()."\\".$fileLocation);
        die(var_dump(file_exists($fileLocation)));
        require_once($fileLocation);
    }*/
    
    if (file_exists("Tests/".$fileLocation))
        require_once("Tests/".$fileLocation);
    // We want to check for named libraries
    // It is a named library when $parts[0] matches a folder in Library
    else if(is_dir("Library/".$parts[0]))
        require_once("Library/".$fileLocation);
    else
        // We don't know where this class exists. Maybe there is another autoloader that does
		return false;
}
spl_autoload_register('autoload');


require_once('Library/Saros/Core/AutoLoader.php');
spl_autoload_register(array('Saros\Core\AutoLoader', 'autoload'));

// I don't like calling this here. I'm not quite sure how to solve this
Saros\Session::start();

// Include the spot tests                               
//require_once(ROOT_PATH."Library/Spot/Tests/AllTests.php");
//Spot_Tests::main();
//echo "\n\n";

// Run the Saros Framework tests




?>