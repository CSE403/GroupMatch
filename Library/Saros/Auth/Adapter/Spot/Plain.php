<?php
namespace Saros\Auth\Adapter\Spot;

/**
 * This is the Auth adapter for Spot Compatible Databases
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 *
 */
class Plain implements \Saros\Auth\Adapter\IAdapter
{
	/**
	* The Spot_Adapter that is being used for storage
	*
	* @var Spot_Adapter
	*/
	protected $adapter;

	/**
	* The mapper to run the finders on
	*
	* @var Spot_Mapper
	*/
	protected $mapper;

	/**
	* The name of the entity that is being used for authentication
	* information
	*
	* @var string
	*/
	protected $entityName;

	/**
	* The name of the column that contains the username field
	* in the auth mapper
	*
	* @var string
	*/
	protected $identifierCol;

	/**
	* The name of the column that contains the password field
	* in the auth mapper
	*
	* @var string
	*/
	protected $credentialCol;


	protected $identifier;
	protected $credential;

	protected $setCred = false;

	/**
	* Create a new Spot Auth adapter
	*
	* @param string $entityName The name of the entity type to use
	* @param string $identifierCol The column to use as the identity (username)
	* @param string $credentialCol The column that contains a credential (password)
	*
	* @throws Saros_Auth_Exception if $identifierCol is not defined in $mapper
	* @throws Saros_Auth_Exception if $credentialCol is not defined in $mapper
	*
	* @return Saros_Auth_Adapter_Spot
	*/
	public function __construct($mapper, $entityName, $identifierCol, $credentialCol)
	{
		$this->mapper = $mapper;
		$this->entityName = $entityName;

		if (!$mapper->fieldExists($entityName, $identifierCol))
			throw new \Saros\Auth\Exception("Identifier column of '".$identifierCol."' is not defined in mapper.");

		if (!$mapper->fieldExists($entityName, $credentialCol))
			throw new \Saros\Auth\Exception("Credential column of '".$credentialCol."' is not defined in mapper.");

		$this->identifierCol = $identifierCol;
		$this->credentialCol = $credentialCol;
	}

	/**
	* Set the identifier and credential to authenticate
	*
	* @param mixed $identifier The identifier to authenticate
	* @param mixed $credential The credential to authenticate
	*/
	public function setCredential($identifier, $credential)
	{
		// Mark that we have run this function
		$this->setCred = true;

		$this->identifier = $identifier;
		$this->credential = $credential;
	}

	/**
	* Authenticate the request
	*
	* @throws Saros_Auth_Exception if setCredential hasn't been called
	* @return Saros_Auth_Result the result of the authentication
	*
	* @see Saros_Auth_Result
	*/
	public function authenticate()
	{
		if (!$this->setCred)
			throw new \Saros\Auth\Exception("You must call setCredential before you can authenticate");

		// Get all the users with the identifier of $this->identifier.
		$user = $this->mapper->all($this->entityName, array(
													$this->identifierCol => $this->identifier
													))->execute();

		/**
		* @todo figure out which we need.
		* @todo Documentation needs to mention that we should ALWAYS compare based on the consts of Saros_Auth_Result
		*/
		if (!$user || count($user) == 0)
			$status = \Saros\Auth\Result::UNKNOWN_USER;
		// If there is more than one user, its a problem
		elseif (count($user) > 1)
			$status = \Saros\Auth\Result::AMBIGUOUS_ID;
		else
		{
			// We have exactly one user
			// We need to get the salt
			assert(count($user) == 1);
			$user = $user->first();

			$status = $this->validateUser($user);

		}

		$identity = new \Saros\Auth\Identity\Spot($this->mapper, $user);

		return new \Saros\Auth\Result($status, $identity);
	}

	/**
	* Authenticate a single user entity
	*
	* @param Spot_Entity $user to authenticate
	* @return int a Saros_Auth_Result status flag representing the authentication attempt;
	*
	* @see Saros_Auth_Result
	*/
	public function validateUser(Spot\Entity $user)
	{
		// Combine the salt and credential and sha1 it. Check against credentialCol
		if($user->{$this->credentialCol} == $this->credential)
			$status = \Saros\Auth\Result::SUCCESS;
		else
			$status = \Saros\Auth\Result::FAILURE;

		return $status;
	}
}

