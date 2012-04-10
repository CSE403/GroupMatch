<?php
namespace Saros\Acl\Adapter\Spot\Entity; 

class Roles extends \Spot\Entity\Tree\Mptt
{
		// table name
	protected $_datasource = "saros_Roles";

	// Field list
	public $rolename = array("type" => "string");
}
?>
