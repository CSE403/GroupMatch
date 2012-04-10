<?php
class Fixture_Acl_Adapter_MultiRole implements Saros_Acl_RoleManager_Interface
{
	public function getUserPermissions()
	{
		return array();
	}
	public function getUsersRoles()
	{
		return array(1,2);
	}
	public function getHierarchy($roleId)
	{
		if ($roleId == 1)
			return array(1);
		elseif($roleId == 2)
			return array(2);
	}
	public function getRolePermissions($roleId)
	{
		if ($roleId == 1)
		{
			$result = array();
				$values = array();
				$values["View"] = true;
			$result["Article1"] = $values;

			return $result;
		}
		elseif($roleId == 2)
		{
			$result = array();
				$values = array();
				$values["Edit"] = true;
			$result["Article1"] = $values;

				$values2 = array();
				$values2["Own"] = true;
			$result["Site"] = $values2;

			return $result;
		}
	}


	public function addRole($roleName) {}
	public function addRoleToRole($roleName, $newParent) {}
	public function addUserToRole($user, $roleName) {}
	public function deleteRole($roleName) {}
}
