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
            'description' => array('type' => 'string'),
        );
    }
    
    public static function relations()
    {
        return array(
            'options' => array(
                'type' => 'HasMany',
                'entity' => '\Application\Entities\Option',
                'where' => array('pollId' => ':entity.id'),
                'order' => array('id' => 'ASC')
            )
        );
        
        return array(
            'participants' => array(
                'type' => 'HasMany',
                'entity' => '\Application\Entities\Person',
                'where' => array('pollId' => ':entity.id'),
                'order' => array('id' => 'ASC')
            )
        );
    }
}
