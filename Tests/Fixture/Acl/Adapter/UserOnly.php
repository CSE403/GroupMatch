<?php
// Mock Acl adapter class that contains only permissions directly on the user
// Aka, the user is in no roles, but has one permission directly on them
class Fixture_Acl_Adapter_UserOnly implements Saros_Acl_RoleManager_Interface
{
	public function getUserPermissions($identifier)
	{
		$result = array();
		$values = array();
		$values["View"] = true;
		$result["Admin"] = $values;

		return $result;
	}
	public function getRolesForUser($identifier)
	{
		return array();
	}
	public function getRolePath($roleId)
	{
		return array();
	}
	public function getRolePermissions($roleId)
	{
		return array();
	}

	// Calculate the full set of permissions for a user
	public function calculatePermissions($identifier)
	{
		$rolesPermissions = $this->getUserRolesPermissions($identifier);

		$permissions = new Saros_Acl_PermissionSet($rolesPermissions);

		// This will contain all of the permissions the user has been specified
		$userPermissions = $this->getUserPermissions($identifier);

		$permissions->merge($userPermissions);

		// Right now if we get two different answers from different chains, then the result is not gaurenteed.
		// Aka: Dont have ambiguous ACL trees
		//$this->permissions = $this->mergePermissions($rolesPermissions, $userPermissions);

		return $permissions;
	}

	protected function getUserPermissions($identifier)
	{
		return new Saros_Acl_PermissionSet($this->adapter->getUserPermissions($identifier));
	}

	protected function getUserRolesPermissions($identifier)
	{
		// These are all of the permissions specified to the user by roles
		$rolesPermissions = new Saros_Acl_PermissionSet();

		// Get the permissions on the chains of roles the user is in
		$roles = $this->adapter->getUsersRoles($identifier);

		// Go through each role the user is in
		foreach($roles as $role)
		{
			// This is the overall result for the heirarchy of the current role
			// Something like
			// [article1] =>
			//				[view] => [true]
			//				[edit] => [true]
			//				[delete] => [true]
			$rolesAccess = new Saros_Acl_PermissionSet();

			// get an array of roles that leads to to $role
			$parents = $this->adapter->getHierarchy($role);

			// Go through each role in the chain, starting at the root
  			foreach($parents as $parent)
  			{
  				// For each node closer to the role the user is in
  				// get the permission
  				$rolePermissions = $this->adapter->getRolePermissions($parent);

  				// And merge those permissions into the permissions for this chain
  				$rolesAccess->merge($rolePermissions);
			}
			// Merge the permissions for this chain into the permissions for the overall roles
			$rolesPermissions->merge($rolesAccess);
		}

		return $rolesPermissions;
	}
}