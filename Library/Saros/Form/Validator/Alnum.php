<?php
namespace Saros\Form\Validator;

/**
 * This class validates input that is Alpha Numeric
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
class Alnum extends \Saros\Form\Validator
{
	protected $errorMessages = array(
		"invalid" => "Your string must be entirely alpha numeric",
	);

	public function isValid($value)
	{
		if (ctype_alnum($value))
			return true;

		$this->setError("invalid");
		return false;
	}
}