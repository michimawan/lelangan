<?php

class User extends AppModel {
	public $validate = array(
		'username' => array(
            'nonEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Username must be filled',
				'allowEmpty' => false
            ),
            'alphanumeric' => array(
            	'rule' => array('alphanumeric'),
            	'message' => 'Username is combination letter and number'
            )
        ),
        'display_name' => array(
            'nonEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Name must be filled',
				'allowEmpty' => false
            )
        ),
        'password' => array(
            'nonEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Password must be filled',
				'allowEmpty' => false
            )
        ),
	);

    /**
     * Before Save
     * @param array $options
     * @return boolean
     */
    public function beforeSave($options = array())
    {
        // hash our password
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }

        // if we get a new password, hash it
        if (isset($this->data[$this->alias]['password_update']) && !empty($this->data[$this->alias]['password_update'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password_update']);
        }
        // fallback to our parent
        return parent::beforeSave($options);
    }
}
