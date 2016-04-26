<?php
App::uses('Model', 'Model');
App::import('Lib', 'IdGenerator');
App::import('TransactionType', 'PrepareModel');

class PaymentRepository
{
    private $uses = ['Transaction', 'Payment'];

    public function __construct($data = [])
    {
        $this->payment = isset($data['Payment']) ? $data['Payment'] : [];
        $this->transaction = isset($data['Transaction']) ? $data['Transaction'] : [];

        foreach($this->uses as $use)
            App::import('Model', $use);
    }

    public function store()
    {
        $paymentModel = new $this->uses[1]();
        $transactionModel = new $this->uses[0]();

        $total_payment = $this->countTotalPayment($paymentModel, $this->payment['transaction_id']);
        $total_payment += $this->payment['pay'];

        if($total_payment >= $this->transaction['bid_price']) {
            $updateStatus = $this->updateTransactionPayedStatus($transactionModel);
        }

        //save model payment
        $this->payment['payment_id'] = $this->generate_payment_id();
        $payment = (new PrepareModel(2, $this->payment))->run();
        $payment = $paymentModel->save($payment);

        return $payment['Payment']['id'];
    }

    public function update()
    {
    }

    public function delete($payment_id = null)
    {
        if(!$payment_id)
            throw new NotFoundException();

        $paymentModel = new $this->uses[1]();
        $transactionModel = new $this->uses[0]();

        $deletedPayment = $paymentModel->findByPaymentId($payment_id);
        $transaction = $transactionModel->findById($deletedPayment['Payment']['transaction_id']);

        if($this->canUpdatePayedStatusToUnpaid($deletedPayment)) {
            $transactionModel->id = $transaction['Transaction']['id'];
            $transactionModel->saveField('payed', 0);
        }

        $paymentModel->id = $deletedPayment['Payment']['id'];
        return $paymentModel->saveField('status', 0);
    }

    private function updateTransactionPayedStatus($transactionModel)
    {
        $transactionModel->id = $this->payment['transaction_id'];
        return $transactionModel->saveField('payed', 1);
    }

    private function canUpdatePayedStatusToUnpaid($deletedPayment)
    {
        $paymentModel = new $this->uses[1]();
        $transactionModel = new $this->uses[0]();
        $total_payment = $this->countTotalPayment($paymentModel, $deletedPayment['Payment']['transaction_id']);
        $transaction = $transactionModel->findById($deletedPayment['Payment']['transaction_id']);

        return $transaction['Transaction']['payed'] &&
            (($total_payment - $deletedPayment['Payment']['pay']) < $transaction['Transaction']['bid_price']);
    }

    private function countTotalPayment($paymentModel, $transaction_id)
    {
        $payments = $paymentModel->find('all', [
            'conditions' => [
                'Payment.status' => 1,
                'Payment.transaction_id' => $transaction_id
            ],
            'fields' => [
                'Payment.pay'
            ],
            'recursive' => -1
        ]);

        $total_payment = 0;
        foreach($payments as $payment) {
            $total_payment += $payment['Payment']['pay'];
        }

        return $total_payment;
    }

	private function generate_payment_id()
	{
		$pid = 'PID';
        $length = 8;
		$idgenerator = new IdGenerator('Payment', 'payment_id', $length);

		$missing_code = str_pad($idgenerator->get_free_number(), $length, '0', STR_PAD_LEFT);

		return $pid.$missing_code;
	}
}
