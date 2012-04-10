<?php
namespace Saros\Acl\Adapter\Spot\Entity;

class RolePermissions extends \Spot\Entity
{
	// table name
	protected $_datasource = "saros_RolePermissions";

	// Field list
	public $roleId = array("type" => "int");
	public $resource = array("type" => "string");
	public $opValue = array("type" => "text");
}
?>
