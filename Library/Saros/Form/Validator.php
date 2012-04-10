<?php
namespace Saros\Form;

/**
 * This is the parent class for all Validators
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
abstract class Validator
{
	protected $errorMessages = array();

	protected $errorHolders = array();

	protected $errors = array();

	protected function setError($key)
	{
		$string = $this->errorMessages[$key];
		foreach($this->errorHolders as $holder => $value)
		{
			echo "Var: ".$this->$value;
			$string = str_replace("{::".$holder."::}", $this->$value, $string);
		}

		$this->errors[] = $string;
	}

	public function getErrors()
	{
		return $this->errors;
	}
}