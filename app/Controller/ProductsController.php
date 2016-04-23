<?php
App::import('Lib', 'IdGenerator');

class ProductsController extends AppController
{
	public $layout = 'layout';
	public $uses = array('Product');

	public function index()
	{
		$this->set('title', 'List of Product');
		$this->paginate = array(
            'limit' => 20,
            'order' => array('Product.product_id' => 'asc' ),
            'conditions' => array('NOT' => array('Product.status' => '0'))
        );
        $products = $this->paginate('Product');
		$this->set(compact('products'));
	}

	public function add()
	{
		$this->set('title', 'Add Product');
		if($this->request->is('post') || $this->request->is('put')) {
			$this->Product->create();
			$this->request->data['Product']['product_id'] = $this->generate_product_id();
			if($this->Product->save($this->request->data)) {
				$this->Session->setFlash('Success adding new product', 'flashmessage', array('class' => 'success'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash('Failed to add product');
		} 
	}

	public function delete($product_id)
	{
		if($this->request->is('post')) {
			if (!$product_id) {
                $this->Session->setFlash('No Product choosen', 'flashmessage', array('class' => 'warning'));
            }
            try {
            	$product = $this->get_data_by_product_id($product_id);
	            $this->Product->id = $product["Product"]["id"];
	            if ($this->Product->saveField('status', 0)) {
	            	$this->Session->setFlash('Product data has been deleted', 'flashmessage', array('class' => 'success'));
	            }
            } catch (NotFoundException $ex) {
            	$this->Session->setFlash('Product not found', 'flashmessage', array('class' => 'warning'));
            }
        }
		$this->redirect(array('action'=>'index'));
	}

	public function edit($product_id = null)
	{
		$this->set('title', 'Edit Product Data');
		if($this->request->is("post") || $this->request->is("put")) {
			$this->Product->id = $this->request->data['Product']['id'];
			if($this->Product->save($this->request->data)){
				$this->Session->setFlash('Product data has been changed', 'flashmessage', array('class' => 'success'));
            } else {
            	$this->Session->setFlash('Product data has not changed', 'flashmessage', array('class' => 'warning'));
            }
            $this->redirect(array('action'=>'index'));
		} else {
			if($product_id) {
				try {
					$this->request->data = $this->get_data_by_product_id($product_id);
				} catch (NotFoundException $ex) {
					$this->Session->setFlash('Product not found', 'flashmessage', array('class' => 'warning'));
					$this->redirect(array('action'=>'index'));
				}
			} else {
				$this->Session->setFlash('Product not found', 'flashmessage', array('class' => 'warning'));
				$this->redirect(array('action'=>'index'));
			}
		}
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

	private function get_data_by_product_id($product_id)
	{
		$condition = ["product_id" => $product_id];
        $product = $this->Product->findByProductId($product_id);

        if(!$product) 
        	throw new NotFoundException ("Product not found", 404);

        return $product;
	}

	private function generate_product_id()
	{
		$pid = 'PID';
		$idgenerator = new IdGenerator('Supplier', 'supplier_id');

		$missing_code = str_pad($idgenerator->get_free_number(), 4, '0', STR_PAD_LEFT);
		
		return $pid.$missing_code;
	}

}
