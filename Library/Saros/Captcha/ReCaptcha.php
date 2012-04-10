<?php
namespace Saros\Captcha;

/**
 * This class creates a recaptcha interface
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
class ReCaptcha
{
	private $publicKey;
	private $privateKey;

	/**
	 * The reCAPTCHA server URL's
	 */
	private $apiServer = "http://api.recaptcha.net";
	private $apiSecureServer = "https://api-secure.recaptcha.net";
	private $verifyServer = "api-verify.recaptcha.net";

	public function setPublicKey($key)
	{
		$this->publicKey = $key;
	}
	public function setPrivateKey($key)
	{
		$this->privateKey = $key;
	}

	/**
	 * Encodes the given data into a query string format
	 * @param $data - array of string elements to be encoded
	 * @return string - encoded request
	 */
	public function qsencode($data)
	{
		$req = "";
		foreach ( $data as $key => $value )
		$req .= $key . '=' . urlencode( stripslashes($value) ) . '&';

		// Cut the last '&'
		$req = substr($req, 0, strlen($req)-1);
		return $req;
	}

	/**
	 * Submits an HTTP POST to a reCAPTCHA server
	 * @param string $host
	 * @param string $path
	 * @param array $data
	 * @param int port
	 * @return array response
	 */
	function httpPost($host, $path, $data, $port = 80)
	{

		$req = $this->qsencode($data);

		$httpRequest  = "POST ".$path." HTTP/1.0\r\n";
		$httpRequest .= "Host: ".$host."\r\n";
		$httpRequest .= "Content-Type: application/x-www-form-urlencoded;\r\n";
		$httpRequest .= "Content-Length: " . strlen($req) . "\r\n";
		$httpRequest .= "User-Agent: reCAPTCHA/PHP\r\n";
		$httpRequest .= "\r\n";
		$httpRequest .= $req;

		$response = '';
		if( false == ( $fs = @fsockopen($host, $port, $errno, $errstr, 10) ) ) {
			die ('Could not open socket');
		}

		fwrite($fs, $httpRequest);

		while ( !feof($fs) )
		$response .= fgets($fs, 1160); // One TCP-IP packet
		fclose($fs);
		$response = explode("\r\n\r\n", $response, 2);

		return $response;
	}
	/**
	 * Gets the challenge HTML (javascript and non-javascript version).
	 * This is called from the browser, and the resulting reCAPTCHA HTML widget
	 * is embedded within the HTML form it was called from.
	 * @param string $error The error given by reCAPTCHA (optional, default is null)
	 * @param boolean $useSsl Should the request be made over ssl? (optional, default is false)

	 * @return string - The HTML to be embedded in the user's form.
	 */

	function getHtml ($error = null, $useSsl = false)
	{
		if ($this->publicKey == null || $this->publicKey == '')
		{
			throw new Exception("To use reCAPTCHA you must get an API key from <a href='http://recaptcha.net/api/getkey'>http://recaptcha.net/api/getkey</a>");
		}

		if ($useSsl)
		{
			$server = $this->apiSecureServer;
		}
		else
		{
			$server = $this->apiServer;
		}

		$errorPart = "";
		if ($error)
		{
			$errorPart = "&amp;error=" . $error;
		}
		return '<script type="text/javascript" src="'. $server . '/challenge?k=' . $this->publicKey . $errorPart . '"></script>

		<noscript>
	  		<iframe src="'. $server . '/noscript?k=' . $this->publicKey . $errorPart . '" height="300" width="500" frameborder="0"></iframe><br/>
	  		<textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
	  		<input type="hidden" name="recaptcha_response_field" value="manual_challenge"/>
		</noscript>';
	}

	/**
	* Calls an HTTP POST function to verify if the user's guess was correct
	* @param string $remoteip
	* @param string $challenge
	* @param string $response
	* @param array $extra_params an array of extra variables to post to the server
	* @return ReCaptchaResponse
	*/
	function checkAnswer ($remoteip, $challenge, $response, $extra_params = array())
	{
		if ($this->privateKey == null || $this->privateKey == '') {
			throw new Exception("To use reCAPTCHA you must get an API key from <a href='http://recaptcha.net/api/getkey'>http://recaptcha.net/api/getkey</a>");
		}

		if ($remoteip == null || $remoteip == '') {
			die ("For security reasons, you must pass the remote ip to reCAPTCHA");
		}

		//discard spam submissions
		if ($challenge == null || strlen($challenge) == 0 || $response == null || strlen($response) == 0) {
			$recaptcha_response = new ReCaptchaResponse();
			$recaptcha_response->is_valid = false;
			$recaptcha_response->error = 'incorrect-captcha-sol';
			return $recaptcha_response;
		}

		$response = $this->httpPost(
		$this->verifyServer, "/verify",
		array (
		'privatekey' => $this->privateKey,
		'remoteip' => $remoteip,
		'challenge' => $challenge,
		'response' => $response
		)
		+ $extra_params
		);

		$answers = explode ("\n", $response[1]);
		$recaptchaResponse = new ReCaptchaResponse();

		if (trim ($answers [0]) == 'true') {
			$recaptchaResponse->isValid = true;
		}
		else {
			$recaptchaResponse->isValid = false;
			$recaptchaResponse->error = $answers [1];
		}
		return $recaptchaResponse;

	}
	/**
	 * gets a URL where the user can sign up for reCAPTCHA. If your application
	 * has a configuration page where you enter a key, you should provide a link
	 * using this function.
	 * @param string $domain The domain where the page is hosted
	 * @param string $appname The name of your application
	 */
	function getSignupUrl ($domain = null, $appname = null)
	{
		return "http://recaptcha.net/api/getkey?" .  $this->qsencode (array ('domain' => $domain, 'app' => $appname));
	}

	function aesPad($val)
	{
		$blockSize = 16;
		$numPad = $blockSize - (strlen ($val) % $blockSize);
		return str_pad($val, strlen ($val) + $numPad, chr($numPad));
	}

	/* Mailhide related code */

	function aesEncrypt($val,$ky) {
		if (!function_exists ("mcrypt_encrypt")) {
			throw new Exception("To use reCAPTCHA Mailhide, you need to have the mcrypt php module installed.");
		}
		$mode = MCRYPT_MODE_CBC;
		$enc = MCRYPT_RIJNDAEL_128;
		$val = $this->aesPad($val);
		return mcrypt_encrypt($enc, $ky, $val, $mode, "\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0");
	}


	function mailhideUrlbase64 ($x) {
		return strtr(base64_encode ($x), '+/', '-_');
	}

	/* gets the reCAPTCHA Mailhide url for a given email */
	function mailhideUrl($email)
	{
		if ($this->publicKey == '' || $this->publicKey == null || $this->privateKey == "" || $this->privateKey == null) {
			throw new Exception("To use reCAPTCHA Mailhide, you have to sign up for a public and private key, " .
			"you can do so at <a href='http://mailhide.recaptcha.net/apikey'>http://mailhide.recaptcha.net/apikey</a>");
		}


		$ky = pack('H*', $privkey);
		$cryptmail = $this->aesEncrypt ($email, $ky);

		return "http://mailhide.recaptcha.net/d?k=" . $this->publicKey . "&c=" . $this->mailhideUrlbase64 ($cryptmail);
	}

	/**
	 * gets the parts of the email to expose to the user.
	 * eg, given johndoe@example,com return ["john", "example.com"].
	 * the email is then displayed as john...@example.com
	 */
	function mailhideEmailParts ($email)
	{
		$arr = preg_split("/@/", $email );

		if (strlen ($arr[0]) <= 4) {
			$arr[0] = substr ($arr[0], 0, 1);
		} else if (strlen ($arr[0]) <= 6) {
			$arr[0] = substr ($arr[0], 0, 3);
		} else {
			$arr[0] = substr ($arr[0], 0, 4);
		}
		return $arr;
	}

	/**
	 * Gets html to display an email address given a public an private key.
	 * to get a key, go to:
	 *
	 * http://mailhide.recaptcha.net/apikey
	 */
	function mailhideHtml($email)
	{
		$emailParts = $this->mailhideEmailParts ($email);
		$url = $this->mailhideUrl ($email);

		return htmlentities($emailParts[0]) . "<a href='" . htmlentities ($url) .
		"' onclick=\"window.open('" . htmlentities ($url) . "', '', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=500,height=300'); return false;\" title=\"Reveal this e-mail address\">...</a>@" . htmlentities ($emailParts [1]);

	}
}