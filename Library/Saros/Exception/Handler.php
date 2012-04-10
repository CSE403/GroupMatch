<?php
namespace Saros\Exception;

/**
 * Handles Exceptions
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 *
 * @todo Give error codes to all exceptions.
 */
class Handler
{
	public static function handle(\Exception $e)
	{
		// We aren't going to display any output if there is an exception
		ob_clean();
		require_once("Display.php");

	}
}