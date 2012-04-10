<?php
namespace Saros\Acl\Adapter\Spot\Entity; 

class UserPermissions extends \Spot\Entity
{
	// table name
	protected $_datasource = "saros_UserPermissions";

	// Field list
	public $userId = array("type" => "int");
	public $resource = array("type" => "string");
	public $opValue = array("type" => "text");
}
?>
