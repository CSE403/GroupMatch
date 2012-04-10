<?php
// Mock Acl adapter class that contains only permissions directly on the user
// Aka, the user is in no roles, but has one permission directly on them
abstract class Fixture_Acl_Adapter_Abstract implements Saros_Acl_RoleManager_Interface
{

	public function addUserToRole($identifier, $roleName){
		
	}
	public function removeUserFromRole($identifier, $roleName);

	public function createRole($roleName);
	public function deleteRole($roleName);
	public function addRoleToRole($roleName, $newParent);

	// Returns all users who are in the role $roleName and it's parents
	public function findUsersInRole($roleName);

	public function getAllRoles();
	public function roleExists($roleName);

	// Get the heirarchy from root to node of $roleName. This must include $roleName as the last element in the array
	public function getRolePath($roleName);

	// Get the role names that the user is in
	public function getRolesForUser($identifier);

	// Get all of the users that are directly in $roleName
	public function getUsersInRole($roleName);

	// return true if the user is in any role or subrole of $roleName
	public function isUserInRole($identifier, $roleName);

	// return true if $roleName is in getRolesForUser
	public function isUserInExactRole($identifier, $roleName);
}