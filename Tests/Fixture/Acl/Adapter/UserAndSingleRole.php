<?php
class Fixture_Acl_Adapter_UserAndSingleRole implements Saros_Acl_RoleManager_Interface
{
	public function getUserPermissions()
	{
		$result = array();
		$values = array();
			$values["View"] = true;
		$result["Admin"] = $values;

		$article = array();
			$article["View"] = false;
		$result["Article1"] = $article;

		return $result;
	}
	public function getUsersRoles()
	{
		return array(1);
	}
	public function getHierarchy($roleId)
	{
		return array(1);
	}
	public function getRolePermissions($roleId)
	{
		if ($roleId == 1)
		{
			$result = array();
				$values = array();
				$values["View"] = true;
				$values["Edit"] = true;
			$result["Article1"] = $values;

			return $result;
		}

		return array();
	}


	public function addRole($roleName) {}
	public function addRoleToRole($roleName, $newParent) {}
	public function addUserToRole($user, $roleName) {}
	public function deleteRole($roleName) {}
}