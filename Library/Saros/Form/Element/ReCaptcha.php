<?php
namespace Saros\Form\Element;

/**
 * A Recaptcha Form Element
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
class ReCaptcha extends \Saros\Form\Element
{
	// Recaptcha object
	protected $captcha;

	protected $errorMessages = array(
		"incorrect-captcha-sol" => "The CAPTCHA solution was incorrect.",
		"captcha-error"			=> "An error occured with the captcha."
	);

	public function __construct()
	{
		$this->recaptcha = new \Saros\Captcha\ReCaptcha();
		$this->name = "recaptcha_response_field";
	}

	// We can't set a name on captchas
	public function setName()
	{
	}

	public function setPublicKey($key)
	{
		$this->recaptcha->setPublicKey($key);
		return $this;
	}
	public function setPrivateKey($key)
	{
		$this->recaptcha->setPrivateKey($key);
		return $this;
	}

	public function addValidator()
	{
		throw new Exception("You cannot add validators to ReCaptcha elements.");
	}

	/*
		Validate the value of the element
	*/
	public function validate()
	{
		//var_dump($this->getValue());
		if ($this->getValue() && isset($_POST["recaptcha_challenge_field"]))
		{
			$resp = $this->recaptcha->checkAnswer(
			$_SERVER["REMOTE_ADDR"],
			$_POST["recaptcha_challenge_field"],
			$this->getValue());

			if ($resp->isValid)
				return true;
			else
			{
				// We have an error code
				if (array_key_exists($resp->error, $this->errorMessages))
					$key = $resp->error;
				else
					$key = "captcha-error";

				$this->errors[] = $this->errorMessages[$key];
			}

		}

		return false;
	}

	public function render()
	{
		echo $this->recaptcha->getHtml();
	}
}