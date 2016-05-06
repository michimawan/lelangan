<?php
App::import('Lib', 'IdGenerator');
App::import('Lib', 'Autocomplete');
App::import('Repository', 'PaymentRepository');

class PaymentsController extends AppController
{
	public $layout = 'layout';
	public $uses = ['Payment'];

	public function index()
	{
        $this->redirect(['controller' => 'transactions', 'action' => 'index']);
	}

	public function add()
	{
		$this->set('title', 'Add Payment');
		if($this->request->is('post') || $this->request->is('put')) {

            $paymentRepo = new PaymentRepository($this->request->data);

			if($paymentRepo->store()) {
				$this->Session->setFlash('Success adding new payment', 'flashmessage', ['class' => 'success']);
                return $this->redirect(['controller' => 'transactions', 'action' => 'to_print', $this->request->data['Transaction']['transaction_id']]);
			}
			$this->Session->setFlash('Failed to add payment');
		}

        $transaction = $this->getTransactionFromPrevUrl();

        $this->set(['transaction' => $transaction]);
	}

	public function delete($payment_id)
	{
		if($this->request->is('post')) {
			if (!$payment_id) {
                $this->Session->setFlash('No payment choosen', 'flashmessage', ['class' => 'warning']);
            }
            try {
                $paymentRepo = new PaymentRepository();

                if($paymentRepo->delete($payment_id)) {
	            	$this->Session->setFlash('Payment data has been deleted', 'flashmessage', ['class' => 'success']);
	            }
            } catch (NotFoundException $ex) {
            	$this->Session->setFlash('Payment not found', 'flashmessage', ['class' => 'warning']);
            }
        }
        $this->redirect(['controller' => 'transactions', 'action' => 'index']);
	}

	public function edit($payment_id = null)
	{
		$this->set('title', 'Edit Payment Data');
		if($this->request->is('post') || $this->request->is('put')) {
            $transaction_id = $this->request->data['Transaction']['transaction_id'];
            $paymentRepo = new PaymentRepository($this->request->data);

            if($paymentRepo->update()){
				$this->Session->setFlash('Payment data has been changed', 'flashmessage', ['class' => 'success']);
            } else {
            	$this->Session->setFlash('Payment data has not changed', 'flashmessage', ['class' => 'warning']);
            }
            $this->redirect(['controller' => 'transactions', 'action' => 'show', $transaction_id]);
		} else {
			if($payment_id) {
				try {
					$this->request->data = $this->get_data_by_payment_id($payment_id);
				} catch (NotFoundException $ex) {
					$this->Session->setFlash('Payment not found', 'flashmessage', ['class' => 'warning']);
					$this->redirect(['action'=>'index']);
				}
			} else {
				$this->Session->setFlash('Payment not found', 'flashmessage', ['class' => 'warning']);
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

	private function get_data_by_payment_id($payment_id)
	{
		$condition = ['payment_id' => $payment_id];
        $payment = $this->Payment->findByPaymentId($payment_id);

        if(!$payment)
        	throw new NotFoundException ('payment not found', 404);

        return $payment;
	}

    private function get_transactions($transaction_id)
    {
        $conditions = [
            'Transaction.transaction_id LIKE' => '%'.$transaction_id.'%',
            'Transaction.status' => 1,
            'Transaction.payed' => 0
        ];
        $fields = ['Transaction.id',
            'Transaction.transaction_id',
            'Transaction.customer_id',
            'Transaction.bid_price',
            'Customer.name'
        ];

        return (new Autocomplete('Transaction', $fields, $conditions))->get();
    }

    private function getTransactionFromPrevUrl()
    {
        $current_url = $this->request->here();

        $matches = [];
        preg_match("/(TID[\d]*)/", $current_url, $matches);

        if(count($matches) == 0)
            $this->redirect(['controller' => 'transactions', 'action' => 'index']);

        $transaction_id = $matches[0];

        $transaction = $this->get_transactions($transaction_id);

        if(count($transaction) == 0)
            $this->redirect(['controller' => 'transactions', 'action' => 'index']);

        return $transaction;
    }
}
