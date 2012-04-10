<?php
namespace Saros\Form\Validator;

/**
 * This class validates input that is only printable chars.
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
class Visible extends \Saros\Form\Validator
{
	protected $errorMessages = array(
		"invalid" => "Your string must be only visible characters.",
	);

	public function isValid($value)
	{
		if (ctype_print($value))
			return true;

		$this->setError("invalid");
		return false;
	}
}