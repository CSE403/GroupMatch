<?php
namespace Saros\Form\Validator;

/**
 * This class makes sure a string is greater than a certain length
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
class MinLength extends \Saros\Form\Validator
{
	protected $minLength;

	protected $errorMessages = array(
		"tooShort" => "Your string must be at least {::min::} characters",
	);

	protected $errorHolders = array(
		"min"	=> "minLength"
	);

	function __construct($options)
	{
		if (!isset($options[0]))
			throw new Exception("You must set a Min Length on the Validator");

		$this->minLength = $options[0];
	}

	public function isValid($value)
	{
		if (strlen($value) >= $this->minLength)
			return true;

		$this->setError("tooShort");
		return false;
	}
}