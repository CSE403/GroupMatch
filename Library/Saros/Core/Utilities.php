<?php
namespace Saros\Core;

/**
 * This class contains miscellaneous utilities
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
class Utilities
{
	/**
	 * Make a valid link to a controller. Ex:
	 * makeLink("index","view","4","bottom");
	 * to possibly jump to the bottom of page 4 in the index
	 *
	 * @param string $controller Controller
	 * @param mixed	$arguments Set of arguments to use to make the links
	 */
	function makeLink($arguments)
	{
		$args = func_get_args();

		$middle="";

		// If we are not using UrlRewriting
		if (isset($GLOBALS['registry']->config["rewriting"]) &&
			!$GLOBALS['registry']->config["rewriting"])
			$middle = "?act=";
        
        return $GLOBALS['registry']->config["siteUrl"].$middle.implode("/", $args);
	}
}