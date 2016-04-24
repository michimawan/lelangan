<?php
App::import('Lib', 'IdGenerator');

class CustomersController extends AppController
{
	public $layout = 'layout';
	public $uses = ['Customer'];

	public function index()
	{
		$this->set('title', 'List of Customer');
		$this->paginate = [
            'limit' => 20,
            'order' => ['Customer.id' => 'asc' ],
            'conditions' => ['NOT' => ['Customer.status' => '0']],
            'recursive' => 0
        ];
        $customers = $this->paginate('Customer');
        $this->set(['customers' => $customers]);
	}

	public function add()
	{
		$this->set('title', 'Add Customer');
		if($this->request->is('post') || $this->request->is('put')) {
			$this->Customer->create();
			$this->request->data['Customer']['created_at'] = '';
			$this->request->data['Customer']['updated_at'] = '';
			if($this->Customer->save($this->request->data)) {
				$this->Session->setFlash('Success adding new customer', 'flashmessage', ['class' => 'success']);
				return $this->redirect(['action' => 'index']);
			}
			$this->Session->setFlash('Failed to add customer');
		}

        $groups = $this->Customer->Group->find('list');
        $this->set(['groups' => $groups]);
	}

	public function delete($id = null)
	{
		if($this->request->is('post')) {
			if (!$id) {
                $this->Session->setFlash('No customer choosen', 'flashmessage', ['class' => 'warning']);
            }
            try {
                $customer = $this->Customer->findById($id);
	            $this->Customer->id = $customer['Customer']['id'];
	            if ($this->Customer->saveField('status', 0)) {
	            	$this->Session->setFlash('Customer data has been deleted', 'flashmessage', ['class' => 'success']);
	            }
            } catch (NotFoundException $ex) {
            	$this->Session->setFlash('Customer not found', 'flashmessage', ['class' => 'warning']);
            }
        }
		$this->redirect(['action'=>'index']);
	}

	public function edit($id = null)
	{
		$this->set('title', 'Edit customer Data');
		if($this->request->is('post') || $this->request->is('put')) {
			$this->Customer->id = $this->request->data['Customer']['id'];
			if($this->Customer->save($this->request->data)){
				$this->Session->setFlash('customer data has been changed', 'flashmessage', ['class' => 'success']);
            } else {
            	$this->Session->setFlash('customer data has not changed', 'flashmessage', ['class' => 'warning']);
            }
            $this->redirect(['action'=>'index']);
		} else {
			if($id) {
				try {
                    $this->request->data = $this->Customer->findById($id);
                    $groups = $this->Customer->Group->find('list');
                    $this->set(['groups' => $groups]);
				} catch (NotFoundException $ex) {
					$this->Session->setFlash('Customer not found', 'flashmessage', ['class' => 'warning']);
					$this->redirect(['action'=>'index']);
				}
			} else {
				$this->Session->setFlash('Customer not found', 'flashmessage', ['class' => 'warning']);
				$this->redirect(['action'=>'index']);
			}
		}
	}

	public function isAuthorized($user)
	{
        if ($this->action === 'add' || $this->action === 'index' ||
            $this->action === 'edit' || $this->action === 'delete') {
	        return true;
	    }

	    return parent::isAuthorized($user);
	}

    public function get_customer()
    {
        $this->autoRender = false;
        if($this->request->is('ajax')){
            $term = $this->params['url']['term'];

            $customers = $this->Customer->find('all', [
                'fields' => ['Customer.id', 'Customer.name'],
                'conditions' => [
                    'Customer.name LIKE' => '%'.$term.'%',
                    'Customer.status' => 1
                ]
            ]);
            if($customers){
                echo json_encode($customers);
            } else {
                echo "no";
            }
        } else {
            $this->redirect(array('action' => 'index'));
        }
    }
}
