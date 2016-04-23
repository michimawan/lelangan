<?php
class UsersController extends AppController
{
	public $layout = 'layout';
	public $uses = ['User'];

	public function index()
	{
		$this->set('title', 'List of User');
		$this->paginate = [
            'limit' => 20,
            'order' => ['User.username' => 'asc'],
            'conditions' => ['NOT' => ['User.status' => '0']]
        ];
        $users = $this->paginate('User');
        $this->set(['users' => $users]);
	}

	public function add()
	{
		$this->set('title', 'Add User');
		if($this->request->is('post') || $this->request->is('put')) {
			$this->User->create();
			$this->request->data['User']['created_at'] = '';
			$this->request->data['User']['updated_at'] = '';

			if($this->User->save($this->request->data)) {
				$this->Session->setFlash('Success adding new user', 'flashmessage', ['class' => 'success']);
				return $this->redirect(['action' => 'index']);
			}
			$this->Session->setFlash('Failed to add user', 'flashmessage', ['class' => 'danger']);
		}

        $option = $this->user_get_option_for_add_edit();
        $this->set(['option' => $option]);
	}

	public function delete($username)
	{
		if($this->request->is('post')) {
			if (!$username) {
                $this->Session->setFlash('There is no choosen user', 'flashmessage', ['class' => 'warning']);
            }
            try {
            	$user = $this->get_data_by_username($username);
	            $updatedUser = ['User' => [
	            	'id' => $user['User']['id'],
	            	'status' => 0,
	            	'updated_at' => '']
	            ];

	            if ($this->User->save($updatedUser)) {
	            	$this->Session->setFlash('User entry successfully deleted', 'flashmessage', ['class' => 'success']);
	            }
            } catch (NotFoundException $ex) {
            	$this->Session->setFlash('User not found', 'flashmessage', ['class' => 'warning']);
            }
        }
		$this->redirect(['action'=>'index']);
	}

	public function edit($username = null)
	{
		$this->set('title', 'Edit Profile');
		if($this->request->is("post") || $this->request->is("put")) {
			$this->User->id = $this->request->data['User']['id'];
			$this->request->data['User']['updated_at'] = '';

			if($this->User->save($this->request->data)){
				$this->Session->setFlash('User data has been changed', 'flashmessage', ['class' => 'success']);
            } else {
            	$this->Session->setFlash('User data failed to changed', 'flashmessage', ['class' => 'danger']);
            }
            $this->redirect(['action'=>'index']);
		} else {
			if($username) {
				try {
					$this->request->data = $this->get_data_by_username($username);
				} catch (NotFoundException $ex) {
					$this->Session->setFlash('User not found', 'flashmessage', ['class' => 'warning']);
					$this->redirect(['action'=>'index']);
				}
			} else {
				$this->Session->setFlash('User not found', 'flashmessage', ['class' => 'warning']);
				$this->redirect(['action'=>'index']);
			}
		}
	}

	public function view($username)
	{
		$this->set('title', ucfirst($username).' Profile');
		$user = $this->get_data_by_username($username);

        $this->set(['user' => $user]);
	}

	public function beforeFilter() {
		parent::beforeFilter();
	}

	public function login()
	{
		$this->set('title', 'User Login');
		//if already logged-in, redirect
        if($this->Session->check('Auth.User')){
            $this->redirect(['action' => 'index']);
        }

	    if ($this->request->is('post')) {
	        if ($this->Auth->login()) {
	        	if ($this->Auth->user('locked')) {
					$this->Session->setFlash(__('Username has been locked! Please contact your administrator'));
				} else {
					$this->Session->delete('Auth.redirect');
					$this->Session->write('User', $this->Auth->user());

					return $this->redirect($this->Auth->redirectUrl());
				}

	        }
	        $this->Session->setFlash(__('Username or password is incorrect'), 'flashmessage', ['class' => 'danger']);
	    }
	}

	public function logout()
	{
		return $this->redirect($this->Auth->logout());
	}

	public function isAuthorized($user)
	{
	    if ($this->action === 'add' || $this->action === 'index' ||
            $this->action === 'logout' || $this->action === 'login' ||
            $this->action === 'view') {
	        return true;
	    }

	    if ($this->action === 'delete') {
	    	return parent::isAuthorized($user);
	    }

        if ($this->action === 'edit') {
            $user = $this->get_current_user();

            if($user['role'] == 'admin')
                return true;
            else
                return $user['username'] == $this->params['pass'][0];
        }

	    return parent::isAuthorized($user);
	}

	private function get_data_by_username($username)
	{
		$condition = ["username" => $username];
        $user = $this->User->findByUsernameAndStatus($username, 1);

        if(!$user)
        	throw new NotFoundException ("User not found", 404);

        return $user;
	}

    private function user_get_option_for_add_edit()
    {
        $user = $this->get_current_user();
        if($user['role'] == 'admin')
            return ['admin' => 'Admin', 'staff' => 'Staff'];
        else
            return ['staff' => 'Staff'];
    }

    private function get_current_user()
    {
        return $this->Auth->user();
    }
}
