<?php
namespace Saros\Form\Validator;

/**
 * This class makes sure a string is less than a certain length
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
class MaxLength extends \Saros\Form\Validator
{
	protected $maxLength;

	protected $errorMessages = array(
		"tooLong" => "Your string must be at most {::max::} characters",
	);

	protected $errorHolders = array(
		"max"	=> "maxLength"
	);

	function __construct($options)
	{
		if (!isset($options[0]))
			throw new Exception("You must set a Max Length on the Validator");

		$this->maxLength = $options[0];
	}

	public function isValid($value)
	{
		if (strlen($value) <= $this->maxLength)
			return true;

		$this->setError("tooLong");
		return false;
	}
}