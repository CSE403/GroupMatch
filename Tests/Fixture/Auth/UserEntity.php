<?php
namespace Fixture\Auth;
/**
 * Blog Mapper
 *
 * @package Spot
 * @link http://spot.os.ly
 * @link http://github.com/actridge/Spot
 */
class UserEntity extends \Spot\Entity
{
		// table name
	protected static $_datasource = "saros_users";

    public static function fields()
    {
        return array(
            'id' => array('type' => 'int', 'primary' => true, 'serial' => true),
            'username' => array('type' => 'string'),
            'password' => array('type' => 'string'),
            'salt' => array('type' => 'string'),
            'email' => array('type' => 'string'),
            'active' => array('type' => 'int'),
        );
    }
}