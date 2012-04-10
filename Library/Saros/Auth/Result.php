<?php
namespace Saros\Auth;

/**
 * Auth Result Object
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
class Result
{
	// If the authentication was a success
	const SUCCESS = 1;
	// If the user with the given identity is unknown
	const UNKNOWN_USER = 0;
	// If there is more than one user with the given identity
	const AMBIGUOUS_ID = -1;
	// Any failure
	const FAILURE = -2;
	// Some failure for an unkown reason
	const UNKNOWN_FAILURE = -3;

	protected $resultCode;
	protected $identity;

	public function __construct($code, \Saros\Auth\Identity\IIdentity $identity = null)
	{
		//if ($code <= self::UNKNOWN_FAILURE)
			//$code = self::FAILURE;

		$this->resultCode = $code;
		$this->identity = $identity;
	}

	public function getCode()
	{
		return $this->resultCode;
	}

	public function getIdentity()
	{
		return $this->identity;
	}

	public function isSuccess()
	{
		return $this->resultCode == self::SUCCESS;
	}
}
