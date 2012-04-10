<?php
namespace Saros\Acl;

/**
 * A permission set that contains a set of valid permissions
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
class PermissionSet
{
	protected $permissions = null;

	public function __construct($permissions = array())
	{
		$this->permissions = $this->validatePermission($permissions);
	}

	// Simple passthru method to make sure that a parameter is an array of permissions or a permission set.
	// always returns an array of permissions
	public function validatePermission($permission)
	{
		if (!is_array($permission) && !get_class($permission) == __CLASS__)
			throw new Exception("MergePermissions expects an array or a permission set");

		if (get_class($permission) == __CLASS__)
		{
			$permission = $permission->getPermissions();
		}

		return $permission;
	}

	public function getPermissions()
	{
		return $this->permissions;
	}

	public function can($name, $value)
	{
		if (isset($this->permissions[$name][$value]))
			return $this->permissions[$name][$value];
		else
			return false;
	}

	// This merges two arrays of permissions. Every value in $overriding will over ride a permission
	// value that is defined in $total
	public function merge($overriding)
	{
		$overriding = $this->validatePermission($overriding);

		foreach($overriding as $name=>$values)
		{
			// If this key hasn't been initialized, then do it
			if (!isset($this->permissions[$name]))
			{
				$this->permissions[$name] = array();
			}
			foreach($values as $key=>$value)
			{
				$this->permissions[$name][$key] = $value;
			}
		}
		// @ToDo: Does modifying arrays do it in place by default?
	}
}