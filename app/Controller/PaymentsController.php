<?php
App::import('Lib', 'IdGenerator');
App::import('Lib', 'Autocomplete');
App::import('Lib', 'PaymentRepository');

class PaymentsController extends AppController
{
	public $layout = 'layout';
	public $uses = ['Payment'];

	public function index()
	{
		$this->set('title', 'List of Payment');
		$this->paginate = [
            'limit' => 20,
            'order' => ['Payment.payment_id' => 'asc' ],
            'conditions' => ['Payment.status' => 1 ],
        ];
        $payments = $this->paginate('Payment');
        $this->set(['payments' => $payments]);
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
		$this->redirect(['action'=>'index']);
	}

	public function edit($payment_id = null)
	{
		$this->set('title', 'Edit Payment Data');
		if($this->request->is('post') || $this->request->is('put')) {
            $paymentRepo = new PaymentRepository($this->request->data);

            if($paymentRepo->update()){
				$this->Session->setFlash('Payment data has been changed', 'flashmessage', ['class' => 'success']);
            } else {
            	$this->Session->setFlash('Payment data has not changed', 'flashmessage', ['class' => 'warning']);
            }
            $this->redirect(['action'=>'index']);
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
}
