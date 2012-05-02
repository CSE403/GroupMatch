<?php
namespace Application\Entities;

class Answers extends \Spot\Entity
{
    protected static $_datasource = 'answers';

    public static function fields()
    {
        return array(
            'id' => array('type' => 'int', 'primary' => true, 'serial' => true),
            'personId' => array('type' => 'int'),
            'optionId' => array('type' => 'int'),
            'priority' => array('type' => 'int'),
        );
    }
    
    public static function relations()
    {
        return array(
        );
    }
}
