<?php
namespace Application\Entities;

class Person extends \Spot\Entity
{
    protected static $_datasource = 'persons';

    public static function fields()
    {
        return array(
            'id' => array('type' => 'int', 'primary' => true, 'serial' => true),
            'pollId' => array('type' => 'int'),
            'name' => array('type' => 'string'),
        );
    }
    
    public static function relations()
    {
        return array(
            'answers' => array(
                'type' => 'HasMany',
                'entity' => '\Application\Entities\Answer',
                'where' => array('personId' => ':entity.id'),
                'order' => array('id' => 'ASC')
            )
        );
    }
}
