<?php
namespace Application\Entities;

class User extends \Spot\Entity
{
	protected static $_datasource = 'users';

    public static function fields()
    {
        return array(
            'id' => array('type' => 'int', 'primary' => true, 'serial' => true),
            'username' => array('type' => 'string'),
            'password' => array('type' => 'string'),
        );
    }
    
    public static function relations()
    {
        return array(
            'polls' => array(
                'type' => 'HasMany',
                'entity' => '\Application\Entities\Poll',
                'where' => array('userId' => ':entity.id'),
                'order' => array('id' => 'ASC')
            )
        );
    }
}
