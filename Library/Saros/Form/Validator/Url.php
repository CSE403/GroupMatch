<?php
namespace Saros\Form\Validator;

/**
 * This class makes sure a string is a url format
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
class Url extends \Saros\Form\Validator
{
	protected $maxLength;

	protected $errorMessages = array(
		"invalid" => "Your URL is invalid.",
	);

	protected $errorHolders = array();


	public function isValid($value)
	{
		// Regex to match emails
		if(eregi("'|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i'", $value))
			return true;

		$this->setError("invalid");
		return false;
	}
}