<?php
namespace Application\Entities;

class Poll extends \Spot\Entity
{
    protected static $_datasource = 'polls';

    public static function fields()
    {
        return array(
            'id' => array('type' => 'int', 'primary' => true, 'serial' => true),
            'userId' => array('type' => 'int'),
            'question' => array('type' => 'string'),
        );
    }
    
    public static function relations()
    {
        return array(
        );
    }
}
