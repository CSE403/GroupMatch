<?php
namespace Application\Entities;

class Option extends \Spot\Entity
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
            'answers' => array(
                'type' => 'HasMany',
                'entity' => '\Application\Entities\Answer',
                'where' => array('optionId' => ':entity.id'),
                'order' => array('id' => 'ASC')
            )
        );
    }
}
