<?php
namespace Saros\Auth\Storage;

/**
 * This is the interface all storage adapters must implement
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
interface IStorage
{
	/**
	* Get the identity from storage
	*
	* @throws Saros_Auth_Storage_Exception if the identity cannot be fetched
	* @return Saros_Auth_Identity_Interface The resulting identity from storage
	*/
	public function getIdentity();

	/**
	* Returns whether an identity is stored in storage
	*
	* @throws Saros_Auth_Storage_Exception if storage cannot be read
	* @return bool True if the storage contains an identity, false otherwise
	*/
	public function hasIdentity();

	/**
	* Write an identity to the storage adapter
	*
	* @param mixed $id The identity to write to storage
	* @throws Saros_Auth_Storage_Exception if the storage cannot be written to
	*/
	public function writeIdentity($id);

	/**
	* Empty the storage
	*
	* @throws Saros_Auth_Storage_Exception if storage cannot be cleared
	*/
	public function clearIdentity();

}