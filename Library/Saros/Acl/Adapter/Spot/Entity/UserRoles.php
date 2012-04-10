<?php
namespace Saros\Acl\Adapter\Spot\Entity; 

class Roles extends \Spot\Entity
{
	// table name
	protected $_datasource = "saros_UserRoles";

	// Field list
	public $userId = array("type" => "int");
	public $roleId = array("type" => "int");
}
?>
