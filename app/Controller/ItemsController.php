<?php
App::import('Lib', 'IdGenerator');

class ItemsController extends AppController
{
	public $layout = 'layout';
	public $uses = ['Item'];

	public function index()
	{
		$this->set('title', 'List of Item');
		$this->paginate = [
            'limit' => 20,
            'order' => ['Item.item_id' => 'asc' ],
            'conditions' => ['NOT' => ['Item.status' => '0']]
        ];
        $items = $this->paginate('Item');
        $this->set(['items' => $items]);
	}

	public function add()
	{
		$this->set('title', 'Add Item');
		if($this->request->is('post') || $this->request->is('put')) {
			$this->Item->create();
			$this->request->data['Item']['item_id'] = $this->generate_item_id();
			$this->request->data['Item']['created_at'] = '';
			$this->request->data['Item']['updated_at'] = '';
			if($this->Item->save($this->request->data)) {
				$this->Session->setFlash('Success adding new item', 'flashmessage', ['class' => 'success']);
				return $this->redirect(['action' => 'index']);
			}
			$this->Session->setFlash('Failed to add item');
		} 
	}

	public function delete($item_id)
	{
		if($this->request->is('post')) {
			if (!$item_id) {
                $this->Session->setFlash('No Item choosen', 'flashmessage', ['class' => 'warning']);
            }
            try {
            	$item = $this->get_data_by_item_id($item_id);
	            $this->Item->id = $item['Item']['id'];
	            if ($this->Item->saveField('status', 0)) {
	            	$this->Session->setFlash('Item data has been deleted', 'flashmessage', ['class' => 'success']);
	            }
            } catch (NotFoundException $ex) {
            	$this->Session->setFlash('Item not found', 'flashmessage', ['class' => 'warning']);
            }
        }
		$this->redirect(['action'=>'index']);
	}

	public function edit($item_id = null)
	{
		$this->set('title', 'Edit Item Data');
		if($this->request->is('post') || $this->request->is('put')) {
			$this->Item->id = $this->request->data['Item']['id'];
			if($this->Item->save($this->request->data)){
				$this->Session->setFlash('Item data has been changed', 'flashmessage', ['class' => 'success']);
            } else {
            	$this->Session->setFlash('Item data has not changed', 'flashmessage', ['class' => 'warning']);
            }
            $this->redirect(['action'=>'index']);
		} else {
			if($item_id) {
				try {
					$this->request->data = $this->get_data_by_item_id($item_id);
				} catch (NotFoundException $ex) {
					$this->Session->setFlash('Item not found', 'flashmessage', ['class' => 'warning']);
					$this->redirect(['action'=>'index']);
				}
			} else {
				$this->Session->setFlash('Item not found', 'flashmessage', ['class' => 'warning']);
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

	private function get_data_by_item_id($item_id)
	{
		$condition = ['item_id' => $item_id];
        $item = $this->Item->findByItemId($item_id);

        if(!$item) 
        	throw new NotFoundException ('Item not found', 404);

        return $item;
	}

	private function generate_item_id()
	{
		$pid = 'PID';
		$idgenerator = new IdGenerator('Item', 'item_id');

		$missing_code = str_pad($idgenerator->get_free_number(), 4, '0', STR_PAD_LEFT);
		
		return $pid.$missing_code;
	}

}