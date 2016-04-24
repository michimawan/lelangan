<?php

class Transaction extends AppModel {
    public $belongsTo = [
        'Customer' => [
            'className' => 'Customer',
            'foreignKey' => 'customer_id',
        ],
        'Item' => [
            'className' => 'Item',
            'foreignKey' => 'item_id',
        ]
    ];

    // public $hasMany = [
    //     'Payment' => [
    //         'className' => 'Payment',
    //     ]
    // ]

    public $validate = [
        'bid_price' => [
            'nonEmpty' => [
                'rule' => ['notEmpty'],
                'message' => 'Bidding price must be filled',
                'allowEmpty' => false,
            ]
        ]
    ];
}
