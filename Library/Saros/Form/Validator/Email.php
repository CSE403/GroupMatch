<?php
namespace Saros\Form\Validator;

/**
 * This class validates input that are email format
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
class Email extends \Saros\Form\Validator
{
	protected $maxLength;

	protected $errorMessages = array(
		"invalid" => "Your email is invalid.",
	);

	protected $errorHolders = array();


	public function isValid($value)
	{
		// Regex to match emails
		if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $value))
			return true;

		$this->setError("invalid");
		return false;
	}
}

