<?php

class Supplier extends AppModel {
	public $validate = array(
		'supplier_id' => array(
            'nonEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Supplier ID must be filled',
				'allowEmpty' => false
            ),
            'alphanumeric' => array(
            	'rule' => array('alphanumeric'),
            	'message' => 'Supplier ID is combination letter and number'
            )
        ),
        'supplier_name' => array(
            'nonEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Supplier Name must be filled',
				'allowEmpty' => false
            )
        ),
        'address' => array(
            'nonEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Supplier address must be filled',
				'allowEmpty' => false
            )
        ),
        'phone' => array(
            'nonEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Supplier phone number must be filled',
				'allowEmpty' => false
            ),
            'numeric' => array(
            	'rule' => array('numeric'),
            	'message' => 'Supplier phone number must be filled by number'
            )
        )    
	);
}
