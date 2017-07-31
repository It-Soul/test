<?php
    return array(
        'banned' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'Banned',
            'bizRule' => null,
            'data' => null
        ),
        'user' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'User',
            'bizRule' => null,
            'data' => null
        ),
        'manager' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'Manager',
            'children' => array(
                'user', // унаследуемся от гостя
            ),
            'bizRule' => null,
            'data' => null
        ),
        'courier' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'Courier',
            'children' => array(
                'manager',          // позволим модератору всё, что позволено пользователю
            ),
            'bizRule' => null,
            'data' => null
        ),
        'administrator' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'Administrator',
            'children' => array(
                'courier',         // позволим админу всё, что позволено модератору
            ),
            'bizRule' => null,
            'data' => null
        ),
    );