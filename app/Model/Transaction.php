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

    public $hasMany = [
        'Payment' => [
            'className' => 'Payment',
        ]
    ];

    public $validate = [
        'item_id' => [
            'nonEmpty' => [
                'rule' => ['notEmpty'],
                'message' => 'Item ID must be filled',
				'allowEmpty' => false
            ],
        ],
        'customer_id' => [
            'nonEmpty' => [
                'rule' => ['notEmpty'],
                'message' => 'Customer ID must be filled',
				'allowEmpty' => false
            ],
        ],
        'transaction_id' => [
            'nonEmpty' => [
                'rule' => ['notEmpty'],
                'message' => 'Transaction ID must be filled',
				'allowEmpty' => false
            ],
            'alphanumeric' => [
                'rule' => ['alphanumeric'],
            	'message' => 'Transaction ID is combination letter and number'
            ]
        ],
        'bid_price' => [
            'nonEmpty' => [
                'rule' => ['notEmpty'],
                'message' => 'Bidding price must be filled',
                'allowEmpty' => false,
            ]
        ]
    ];
}
