<?php

class Item extends AppModel {
	public $validate = array(
		'item_id' => array(
            'nonEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Item ID must be filled',
				'allowEmpty' => false
            ),
            'alphanumeric' => array(
            	'rule' => array('alphanumeric'),
            	'message' => 'Item ID is combination letter and number'
            )
        ),
        'item_name' => array(
            'nonEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Item Name must be filled',
				'allowEmpty' => false
            )
        ),
        'base_price' => array(
            'nonEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Item Buy Price must be filled',
				'allowEmpty' => false
            ),
            'numeric' => array(
            	'rule' => array('numeric'),
            	'message' => 'Item Buy Price must be filled by number'
            )
        ),
        'stock' => array(
            'nonEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Stock must be filled',
				'allowEmpty' => false
            ),
            'numeric' => array(
            	'rule' => array('numeric'),
            	'message' => 'Stock must be filled by number'
            )
        ),
	);
}
