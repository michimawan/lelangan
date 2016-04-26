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
        'customer_id' => [
            'nonEmpty' => [
                'rule' => ['notEmpty'],
                'message' => 'Transaction ID must be filled',
				'allowEmpty' => false
            ],
            'numeric' => [
            	'rule' => ['numeric'],
            	'message' => 'Customer ID must be filled by number'
            ]
        ],
        'pay' => [
            'nonEmpty' => [
                'rule' => ['notEmpty'],
                'message' => 'Payment must be filled',
				'allowEmpty' => false
            ],
            'numeric' => [
            	'rule' => ['numeric'],
            	'message' => 'Payment must be filled by number'
            ]
        ]
    ];
}
