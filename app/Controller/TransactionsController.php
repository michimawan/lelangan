<?php
App::import('Lib', 'IdGenerator');
App::import('Lib', 'TransactionRepository');

class TransactionsController extends AppController
{
	public $layout = 'layout';
	public $uses = ['Transaction'];

	public function index()
	{
		$this->set('title', 'List of Transaction');
		$this->paginate = [
            'limit' => 20,
            'order' => ['Transaction.transaction_id' => 'asc' ],
            'conditions' => ['NOT' => ['Transaction.status' => '0']]
        ];
        $transactions = $this->paginate('Transaction');
        $this->set(['transactions' => $transactions]);
	}

	public function add($type = null)
	{
		$this->set('title', 'Add Transaction');
        if($this->request->is('post') || $this->request->is('put')) {

            $transactionRepo = new TransactionRepository($this->request->data);

            if($transactionRepo->save()) {
				$this->Session->setFlash('Success adding new transaction', 'flashmessage', ['class' => 'success']);
				return $this->redirect(['action' => 'index']);
			}
			$this->Session->setFlash('Failed to add transaction');
		}

        if(!$type)
            $this->redirect(['action' => 'index']);

        $this->set(['type' => $type, 'transaction_id' => $this->generate_transaction_id()]);
        return $this->render('add_'.$type);
	}

	public function delete($transaction_id)
	{
		if($this->request->is('post')) {
			if (!$transaction_id) {
                $this->Session->setFlash('No transaction choosen', 'flashmessage', ['class' => 'warning']);
            }
            try {
            	$transaction = $this->get_data_by_transaction_id($transaction_id);
	            $this->Transaction->id = $transaction['Transaction']['id'];
	            if ($this->Transaction->saveField('status', 0)) {
	            	$this->Session->setFlash('Transaction data has been deleted', 'flashmessage', ['class' => 'success']);
	            }
            } catch (NotFoundException $ex) {
            	$this->Session->setFlash('Transaction not found', 'flashmessage', ['class' => 'warning']);
            }
        }
		$this->redirect(['action'=>'index']);
	}

	public function edit($transaction_id = null)
	{
		$this->set('title', 'Edit Transaction Data');
		if($this->request->is('post') || $this->request->is('put')) {
            $transaction = $this->get_data_by_transaction_id($transaction_id);
			if($this->Transaction->save($this->request->data)){
				$this->Session->setFlash('Transaction data has been changed', 'flashmessage', ['class' => 'success']);
            } else {
            	$this->Session->setFlash('Transaction data has not changed', 'flashmessage', ['class' => 'warning']);
            }
            $this->redirect(['action'=>'index']);
		} else {
			if($transaction_id) {
				try {
					$this->request->data = $this->get_data_by_transaction_id($transaction_id);
				} catch (NotFoundException $ex) {
					$this->Session->setFlash('Transaction not found', 'flashmessage', ['class' => 'warning']);
					$this->redirect(['action'=>'index']);
				}
			} else {
				$this->Session->setFlash('Transaction not found', 'flashmessage', ['class' => 'warning']);
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

	private function get_data_by_transaction_id($transaction_id)
	{
        $transaction = $this->Transaction->findByTransactionId($transaction_id);

        if(!$transaction)
        	throw new NotFoundException ('Transaction not found', 404);

        return $transaction;
	}

	private function generate_transaction_id()
	{
		$pid = 'TID';
        $length = 8;
		$idgenerator = new IdGenerator('Transaction', 'transaction_id', $length);

		$missing_code = str_pad($idgenerator->get_free_number(), $length, '0', STR_PAD_LEFT);

		return $pid.$missing_code;
	}
}
