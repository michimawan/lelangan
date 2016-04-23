<?php

class Group extends AppModel {
    public $hasMany = [
        'Customer' => [
            'className' => 'Customer',
            'conditions' => ['Customer.status' => 1],
            'foreignKey' => 'group_id'
        ],
    ];
}
