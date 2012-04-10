<?php
namespace Saros\Auth\Identity;
/**
 * This is the interface all Identity adapters must implement
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
interface IIdentity
{
	/**
	* Get the unique identifier for the identity
	*
	* @return mixed The resulting identity from storage
	*/
	public function getIdentifier();

	// Get the value of the key from the identity
	public function __get($key);
}