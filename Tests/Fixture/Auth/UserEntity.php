<?php
/**
 * Blog Mapper
 *
 * @package Spot
 * @link http://spot.os.ly
 * @link http://github.com/actridge/Spot
 */
class Fixture_Auth_UserEntity extends Spot_Entity_Abstract
{
		// table name
	protected $_datasource = "saros_users";

	// Field list
	public $id = array("type" => "int", "primary" => true, "serial" => true);
	public $username = array("type" => "string");
	public $password = array("type" => "string");
	public $salt = array("type" => "string");
	public $email = array("type" => "string");
	public $active = array("type" => "int");
}