<?php

class Product extends AppModel {
	public $validate = array(
		'product_id' => array(
            'nonEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Product ID must be filled',
				'allowEmpty' => false
            ),
            'alphanumeric' => array(
            	'rule' => array('alphanumeric'),
            	'message' => 'Product ID is combination letter and number'
            )
        ),
        'product_name' => array(
            'nonEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Product Name must be filled',
				'allowEmpty' => false
            )
        ),
        'price_buy' => array(
            'nonEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Product Buy Price must be filled',
				'allowEmpty' => false
            ),
            'numeric' => array(
            	'rule' => array('numeric'),
            	'message' => 'Product Buy Price must be filled by number'
            )
        ),
        'price_sell' => array(
            'nonEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Product Sell Price must be filled',
				'allowEmpty' => false
            ),
            'numeric' => array(
            	'rule' => array('numeric'),
            	'message' => 'Product Sell Price must be filled by number'
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
