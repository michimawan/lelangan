<?php
App::uses('Model', 'Model');
App::import('Lib', 'IdGenerator');
App::import('TransactionType', 'PrepareModel');

class PaymentRepository
{
    private $uses = ['Transaction', 'Payment'];

    public function __construct($data = [])
    {
        // debug($data);
        // $this->_stop();
        $this->payment = isset($data['Payment']) ? $data['Payment'] : [];
        $this->transaction = isset($data['Transaction']) ? $data['Transaction'] : [];

        foreach($this->uses as $use)
            App::import('Model', $use);
    }

    public function store()
    {
        $paymentModel = new $this->uses[1]();
        $transactionModel = new $this->uses[0]();

        $current_payment = $transactionModel->findById($this->payment['transaction_id']);
        $total_payment = $current_payment['Transaction']['payment_count'] + $this->payment['pay'];

        $status = $total_payment >= $this->transaction['bid_price'] ? 1 : 0;
        $this->updateTransactionPayedStatus($transactionModel, $total_payment, $status);

        $this->payment['payment_id'] = $this->generate_payment_id();
        $payment = (new PrepareModel(2, $this->payment))->run();
        $payment = $paymentModel->save($payment);

        return $payment['Payment']['id'];
    }

    public function update()
    {
        $paymentModel = new $this->uses[1]();
        $transactionModel = new $this->uses[0]();

        $new_amount = $this->payment['pay'];
        $payment_id = $this->payment['id'];
        $transaction_id = $this->payment['transaction_id'];

        $transaction = $transactionModel->findById($transaction_id);
        $payment = $paymentModel->findById($payment_id);
        $current_payment = $transaction['Transaction']['payment_count'] - $payment['Payment']['pay'];

        $total_payment = $current_payment + $new_amount;
        $status = $total_payment >= $this->transaction['bid_price'] ? 1 : 0;
        $this->updateTransactionPayedStatus($transactionModel, $total_payment, $status);

        $paymentModel->id = $payment_id;
        return $paymentModel->saveField('pay', $new_amount);
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
            try{
                $transactionModel->getDataSource();
                $transactionModel->id = $transaction['Transaction']['id'];

                $payment_count = $transaction['Transaction']['payment_count'] - $deletedPayment['Payment']['pay'];
                $transactionModel->saveField('payment_count', $payment_count);
                $transactionModel->saveField('payed', 0);
                $transactionModel->commit();
            } catch (Exception $e) {
                $transactionModel->rollback();
            }
        }

        try{
            $paymentModel->getDataSource();
            $paymentModel->id = $deletedPayment['Payment']['id'];
            $paymentModel->saveField('status', 0);
            $paymentModel->commit();
            return true;
        } catch (Exception $e) {
            $paymentModel->rollback();
            return false;
        }
    }

    private function updateTransactionPayedStatus($transactionModel, $payment_count = 0, $status = 0)
    {
        $transactionModel->id = $this->payment['transaction_id'];
        try {
            $transactionModel->getDataSource();
            $transactionModel->saveField('payed', $status);
            $transactionModel->saveField('payment_count', $payment_count);
            $transactionModel->commit();
            return true;
        } catch (Exception $e) {
            $transactionModel->rollback();
            return false;
        }
    }

    private function canUpdatePayedStatusToUnpaid($deletedPayment)
    {
        $paymentModel = new $this->uses[1]();
        $transactionModel = new $this->uses[0]();
        $total_payment = $transactionModel->find('first', ['conditions' => ['Transaction.id' => $deletedPayment['Payment']['transaction_id']]]);
        $transaction = $transactionModel->findById($deletedPayment['Payment']['transaction_id']);

        return $transaction['Transaction']['payed'] &&
            (($total_payment['Transaction']['payment_count'] - $deletedPayment['Payment']['pay']) < $transaction['Transaction']['bid_price']);
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
