<?php
namespace Saros\Auth\Adapter;
/**
 * This is the common interface that all authentication adapters must implement
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
interface IAdapter
{

	/**
	* Authenticate a request
	*
	* @return Saros_Auth_Result Object containing authentication information
	*
	*/
	public function authenticate();
}