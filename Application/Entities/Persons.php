<?php
namespace Application\Entities;

class Persons extends \Spot\Entity
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
        );
    }
}
