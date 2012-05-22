<?php
/**
 * This class sets up the neccessary files and objects.
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
// Lets turn on error reporting
error_reporting(E_ALL|E_STRICT);

define("ROOT_PATH",  realpath(dirname(__FILE__))."/");

// Autoload all of the classes that are not included

require_once('Library/Saros/Core/AutoLoader.php');
spl_autoload_register(array('Saros\Core\AutoLoader', 'autoload'));

/**
* This is an attempt to load files
* relative to where this index file resides
* it should be skipped if the Core_Autoloader works
* but, is needed if this resides outside of library root
*
* TODO: Change this to use namespaces
*/
function autoload($classname)
{                  
	$filename = str_replace("_","/",$classname).".php";
	if(file_exists($filename))
	{
		require_once($filename);
	}
}

spl_autoload_register('autoload');
// Expect that autoloader is working now
set_exception_handler(array('Saros\Exception\Handler', 'handle'));

// error handler function
function myErrorHandler($errno, $errstr, $errfile, $errline)
{
    if (!(error_reporting() & $errno)) {
        // This error code is not included in error_reporting
        return;
    }

    switch ($errno) {
    case E_USER_ERROR:
        echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
        echo "  Fatal error on line $errline in file $errfile";
        echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
        echo "Aborting...<br />\n";
        exit(1);
        break;

    case E_USER_WARNING:
        echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
        break;

    case E_USER_NOTICE:
        echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
        break;

    default:
        echo "[$errno] $errstr on line $errline in file $errfile<br />\n";
        break;
    }

    /* Don't execute PHP internal error handler */
    return true;
}

set_error_handler("myErrorHandler");


/*
Create an output buffer. This is being used
so that we can at any point clear all output.
For example; our exception handler
does not display anything other than the exception
message.
*/
ob_start();

// Create a new registry of variables
$registry = new \Saros\Core\Registry();

// Load up the core set of utilities
$registry->utils = new \Saros\Core\Utilities();

// Create a new registry object to be used for configuration
$registry->config  = new \Saros\Core\Registry();

// Load the router
$registry->router = new \Saros\Core\Router();

$registry->display = \Saros\Display::getInstance($registry);

// Get the current route
$registry->router->parseRoute();

// We want to setup our application
\Application\Setup::doSetup($registry);

// Calls the module's setup file
$registry->router->setupModule();
       
// Creates an instance of the class that will be
// Called to generate our page
$registry->router->createInstance($registry);

/**
 * Sets the view. This can be changed
 * at any time before the class is run
 */
$registry->router->getInstance()->setView($registry->display);
       
// Run the controller
$registry->router->run();
            
// Display our page
$registry->display->parse();
