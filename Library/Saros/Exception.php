<?php
namespace Saros;

/**
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
class Exception extends \Exception
{
	protected $previous;

	// Redefine the exception so message isn't optional
    public function __construct($message, $code = 0, Exception $previous = null)
    {
    	if ($previous)
        	$this->previous = $previous;

        // make sure everything is assigned properly
        parent::__construct($message, $code);
    }
}
