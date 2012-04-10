<?php
namespace Saros\Auth\Adapter\Spot;
/**
* This is the Spot adapter that supports an identifier, credential, and salt column
* in the mapper. This thereby supports user-by-user salts
*
 * The password and the salt are combined and sha1'd
 *
 * sha1(credential+salt)
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
class Hash extends Plain
{

	private $saltCol;

	/**
	*
	* @param Spot_Mapper_Abstract $mapper
	* @param mixed $identifierCol
	* @param mixed $credentialCol
	* @param mixed $saltCol
	* @return Application_Classes_Auth_Adapter_Spot
	*/
	public function __construct(\Spot\Mapper $mapper, $entityName, $identifierCol, $credentialCol, $saltCol)
	{
		parent::__construct($mapper, $entityName, $identifierCol, $credentialCol);

		if (!$mapper->fieldExists($entityName, $saltCol))
			throw new \Saros\Auth\Exception("Salt column of '".$saltCol."' is not defined in entity.");

		$this->saltCol = $saltCol;
	}

	public function validateUser(\Spot\Entity $user)
	{
		$salt = $user->{$this->saltCol};

		// Combine the salt and credential and sha1 it. Check against credentialCol
		if($user->{$this->credentialCol} == sha1($salt.$this->credential))
			$status = \Saros\Auth\Result::SUCCESS;
		else
			$status = \Saros\Auth\Result::FAILURE;

		return $status;
	}
}

