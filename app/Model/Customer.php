<?php

class Customer extends AppModel {
    public $belongsTo = [
        'Group' => [
            'className' => 'Group',
            'foreignKey' => 'group_id'
        ],
    ];

	public $validate = array(
        'name' => array(
            'nonEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Customer Name must be filled',
				'allowEmpty' => false
            )
        ),
        'address' => array(
            'nonEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Customer Address must be filled',
				'allowEmpty' => false
            ),
        ),
        'phone' => array(
            'nonEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Customer phone number must be filled',
				'allowEmpty' => false
            ),
            'numeric' => array(
            	'rule' => array('numeric'),
            	'message' => 'Customer phone number must be number'
            )
        ),
	);
}
