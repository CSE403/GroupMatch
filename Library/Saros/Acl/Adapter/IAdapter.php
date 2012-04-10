<?php
namespace Saros\Acl\Adapter;

/**
 * This is the common interface that all ACL adapters must implement
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
interface IAdapter
{

	/**
	* Add a user to a role.
	*
	* @param mixed $identifier The unique Identifier for the user
	* @param string $roleName The name of the role to add the user to
	*
	* @throws Saros_Acl_Exception if the user is already in the given role
	*/
  	public function addUserToRole($identifier, $roleName);

  	/**
  	* Remove a user from a role
  	*
  	* @param mixed $identifier The unique identifier for the user
  	* @param string $roleName The name of the role to add the user to
  	*/
	public function removeUserFromRole($identifier, $roleName);

	/**
	* Creates a role
	*
	* @param string $roleName The name of the role to create
	* @throws Saros_Acl_Exception if a role already exists with $roleName
	*/
	public function createRole($roleName);

	/**
	* Delete a role
	*
	* @param string $roleName The name of the role to delete
	* @throws Saros_Acl_Exception if no role exists with $roleName
	*/
	public function deleteRole($roleName);

	/**
	* Add a role as a child of another role
	*
	* @param string $roleName The role to add as a child
	* @param string $parent The parent role
	*
	* @todo What would this do if $roleName already has a parent
	*
	* @throws Saros_Acl_Exception if no role exists with $roleName
	* @throws Saros_Acl_Exception if no role exists with $parent
	*/
	public function addRoleToRole($roleName, $parent);

	/**
	* Returns all users who are in the role $roleName and it's parents
	*
	* @param string $roleName The name of the role look for users in
	* @returns array(mixed) List of unique identifiers for the users in the role $roleName
	*
	* @throws Saros_Acl_Exception if no role exists with $roleName
	*/
	public function findUsersInRole($roleName);

	/**
	* Gets a list of all the existing roles
	*
	* @returns array(string) List of the names of existing roles
	*/
	public function getAllRoles();

	/**
	* Checks whether a role exists
	*
	* @param string $roleName The name of the role to look for
	* @returns bool True if the role exists, false otherwise
	*/
	public function roleExists($roleName);

	/**
	* Get the role names that the user is in
	*
	* @param mixed $identifier The unique identifier for the user
	* @returns array(string) A list of roles that the user is in
	*/
	public function getRolesForUser($identifier);

	/**
	* Check whether a user is in a role
	*
	* @param mixed $identifier The unique identifier for the user
	* @param string $roleName The name of the role
	* @returns true if the user is in the role specified by $roleName. If $checkChildren
	* 			is true, then it will also check if the user is in any of the children
	*			roles of $roleName
	* @returns false otherwise
	*
	* @throws Saros_Acl_Exception if no role exists with $rolename
	*/
	public function isUserInRole($identifier, $roleName, $checkChildren = false);

	/**
	* Get the permissions defined for a role
	*
	* @param search $roleName The name of the role to get permissions on
	* @returns Saros_Acl_PermissionSet Set of the permissions on the role
	*
	* @throws Saros_Acl_Exception if no role exists with $roleName
	*/
	public function getPermsForRole($roleName);

	/**
	* Get the permissions defined on a user
	*
	* @param mixed $identifier The unique identifer for the user
	* @returns Saros_Acl_PermissionSet Set of permissions on the user
	*/
	public function getPermsForUser($identifier);

	/**
	* Calculate the permissions for a role by including the parents
	* of $roleName
	*
	* @param string $roleName The role to calculate permissions for.
	* @returns Saros_Acl_PermissionSet Set of permissions for the role
	*
	* @throws Saros_Acl_Exception if no role exists with $roleName
	*/
	public function calculatePermsForRole($roleName);


	/**
	* Calculate the full set of permissions for a user by calculating
	* permissions on all of the user's roles and adding the permissions
	* defined explicitly on the user
	*
	* @param mixed $identifier The identifier of the user
	* @returns Saros_Acl_PermissionSet Set of permissions for the user
	*/
	public function calculatePermsForUser($identifier);
}
?>
