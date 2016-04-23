<?php

App::import('Lib', 'IdGenerator');

class SuppliersController extends AppController
{
	public $layout = 'layout';
	public $uses = array('Supplier');

	public function index()
	{
		$this->set('title', 'List of Supplier');
		$this->paginate = array(
            'limit' => 20,
            'order' => array('Supplier.supplier_id' => 'asc' ),
            'conditions' => array('NOT' => array('Supplier.status' => '0'))
        );
        $suppliers = $this->paginate('Supplier');
		$this->set(compact('suppliers'));
	}

	public function add()
	{
		$this->set('title', 'Add Supplier');
		if($this->request->is('post') || $this->request->is('put')) {
			$this->Supplier->create();
			$this->request->data['Supplier']['supplier_id'] = $this->generate_supplier_id();
			if($this->Supplier->save($this->request->data)) {
				$this->Session->setFlash('Success adding new supplier', 'flashmessage', array('class' => 'success'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash('Failed to add supplier');
		} 
	}

	public function delete($supplier_id)
	{
		if($this->request->is('post')) {
			if (!$supplier_id) {
                $this->Session->setFlash('No Supplier choosen', 'flashmessage', array('class' => 'warning'));
            }
            try {
            	$supplier = $this->get_data_by_supplier_id($supplier_id);
	            $this->Supplier->id = $supplier["Supplier"]["id"];
	            if ($this->Supplier->saveField('status', 0)) {
	            	$this->Session->setFlash('Supplier data has been deleted', 'flashmessage', array('class' => 'success'));
	            }
            } catch (NotFoundException $ex) {
            	$this->Session->setFlash('Supplier not found', 'flashmessage', array('class' => 'warning'));
            }
        }
		$this->redirect(array('action'=>'index'));
	}

	public function edit($supplier_id = null)
	{
		$this->set('title', 'Edit Supplier Data');
		if($this->request->is("post") || $this->request->is("put")) {
			$this->Supplier->id = $this->request->data['Supplier']['id'];
			if($this->Supplier->save($this->request->data)){
				$this->Session->setFlash('Supplier data has been changed', 'flashmessage', array('class' => 'success'));
            } else {
            	$this->Session->setFlash('Supplier data has not changed', 'flashmessage', array('class' => 'warning'));
            }
            $this->redirect(array('action'=>'index'));
		} else {
			if($supplier_id) {
				try {
					$this->request->data = $this->get_data_by_supplier_id($supplier_id);
				} catch (NotFoundException $ex) {
					$this->Session->setFlash('Supplier not found', 'flashmessage', array('class' => 'warning'));
					$this->redirect(array('action'=>'index'));
				}
			} else {
				$this->Session->setFlash('Supplier not found', 'flashmessage', array('class' => 'warning'));
				$this->redirect(array('action'=>'index'));
			}
		}
	}

	private function get_data_by_supplier_id($supplier_id)
	{
		$condition = ["supplier_id" => $supplier_id];
        $supplier = $this->Supplier->findBySupplierId($supplier_id);

        if(!$supplier) 
        	throw new NotFoundException ("Supplier not found", 404);

        return $supplier;
	}

	public function isAuthorized($user)
	{
	    if ($this->action === 'add' || $this->action === 'index') {
	        return true;
	    }

	    if ($this->action === 'edit' || $this->action === 'delete') {
	    	return parent::isAuthorized($user);
	    }

	    return parent::isAuthorized($user);
	}

	private function generate_supplier_id()
	{
		$pid = 'SID';
		$idgenerator = new IdGenerator('Supplier', 'supplier_id');

		$missing_code = str_pad($idgenerator->get_free_number(), 4, '0', STR_PAD_LEFT);
		
		return $pid.$missing_code;
	}
}
