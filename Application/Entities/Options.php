<?php
namespace Application\Entities;

class Options extends \Spot\Entity
{
    protected static $_datasource = 'options';

    public static function fields()
    {
        return array(
            'id' => array('type' => 'int', 'primary' => true, 'serial' => true),
            'pollId' => array('type' => 'int'),
            'name' => array('type' => 'string'),
            'maxSize' => array('type' => 'int'),
        );
    }
    
    public static function relations()
    {
        return array(
        );
    }
}
