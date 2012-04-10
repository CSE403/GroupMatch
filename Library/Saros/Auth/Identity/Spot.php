<?php
namespace Saros\Auth\Identity;

/**
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
class Spot implements IIdentity
{
	private $mapper;
	private $user;

	public function __construct(\Spot\Mapper $mapper, \Spot\Entity $user)
	{
		$this->mapper = $mapper;
		$this->user = $user;
        
	}
	public function getIdentifier()
	{
		return $this->mapper->primaryKey($this->user);
	}

	public function __get($key)
	{                      
		return $this->user->$key;
	}
}

