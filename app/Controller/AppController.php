<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $components = array(
	    'DebugKit.Toolbar',
	    'Session',
        'Auth',
	    'Auth' => array(
	        'loginRedirect' => array('controller' => 'users', 'action' => 'index'),
	        'logoutRedirect' => array('controller' => 'users', 'action' => 'login'),
	        'authError' => 'You must login to see this page.',
	        'loginError' => 'Username or Password doesn\'t match',
	        'authorize' => array('Controller')
	    ),
    );
 
	// only allow the login controllers only
	public function beforeFilter() {
	    $this->Auth->allow(array('controllers' => 'users', 'action' => 'login'));
	    $this->Auth->flash = array(
		    'element' => 'flashmessage',
		    'key' => 'auth',
		    'params' => array(
		        'class' => 'danger',
		    )
		);
	}
 
	public function isAuthorized($user) {
    	// Admin can access every action
	    if (isset($user['role']) && $user['role'] === 'admin') {
	        return true;
	    }

	    // Default deny
	    return false;
	}
}
