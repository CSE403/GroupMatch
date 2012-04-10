<?php
class Fixture_Acl_Adapter_InheritedRole implements Saros_Acl_RoleManager_Interface
{
	public function getUserPermissions()
	{
		return array();
	}
	public function getUsersRoles()
	{
		return array(1);
	}
	public function getRolePath($roleId)
	{
		return array(2,1);
	}
	public function getRolePermissions($roleId)
	{
		$result = array();

		if ($roleId == 2)
		{
			$values = array();
			$values["View"] = true;
			$result["Site"] = $values;

			$values2 = array();
			$values2["View"] = true;
			$values2["Edit"] = true;
			$result["Article1"] = $values2;

			$values3 = array();
			$values3["View"] = true;
			$result["Admin"] = $values3;
		}
		elseif ($roleId == 1)
		{
			$values = array();
			$values["View"] = false;
			$result["Admin"] = $values;

			$values2 = array();
			$values2["Delete"] = true;
			$result["Article1"] = $values2;
		}

		return $result;
	}

	public function addRole($roleName) {}
	public function addRoleToRole($roleName, $newParent) {}
	public function addUserToRole($user, $roleName) {}
	public function deleteRole($roleName) {}
}