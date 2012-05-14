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
            'guid' => array('type' => 'string'),
            'isUnique' => array('type' => 'string'),
        );
        // unique is either true or false, but Spot doesn't seem to work right now with ints
    }
    
    public static function relations()
    {
        return array(
            'options' => array(
                'type' => 'HasMany',
                'entity' => '\Application\Entities\Option',
                'where' => array('pollId' => ':entity.id'),
                'order' => array('id' => 'ASC')
            ),
            'participants' => array(
                'type' => 'HasMany',
                'entity' => '\Application\Entities\Person',
                'where' => array('pollId' => ':entity.id'),
                'order' => array('id' => 'ASC')
            )
        );
    }
}
