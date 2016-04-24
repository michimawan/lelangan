<?php

class Payment extends AppModel {
    public $belongsTo = [
        'Transaction' => [
            'className' => 'Transaction',
            'foreignKey' => 'transaction_id',
        ],
        'Customer' => [
            'className' => 'Customer',
            'foreignKey' => 'customer_id',
        ],
    ];

    public $validate = [
        'pay' => [
            'nonEmpty' => [
                'rule' => ['notEmpty'],
                'message' => 'Transaction ID must be filled',
				'allowEmpty' => false
            ],
            'numeric' => [
            	'rule' => ['numeric'],
            	'message' => 'Item Buy Price must be filled by number'
            ]
        ]
    ];
}
