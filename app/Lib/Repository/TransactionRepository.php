<?php
App::uses('Model', 'Model');
App::import('TransactionType', 'NormalTransaction');
App::import('TransactionType', 'SpecialTransaction');
App::import('TransactionType', 'SellingTransaction');
App::import('TransactionType', 'GivingTransaction');

class TransactionRepository
{
    private $uses = ['Item', 'Transaction', 'Payment'];

    public function __construct($data = [])
    {
        $this->transaction = isset($data['Transaction']) ? $data['Transaction'] : [];
    }

    public function save()
    {
        switch ($this->transaction['type']) {
            case 'common' :
                return (new NormalTransaction($this->transaction))->save();
            case 'special' :
                return (new SpecialTransaction($this->transaction))->save();
            case 'selling' :
                return (new SellingTransaction($this->transaction))->save();
            case 'giving' :
                return (new GivingTransaction($this->transaction))->save();
            default :
                return false;
        }
        return false;
    }

    public function delete($transaction_id)
    {
        App::import('Model', $this->uses[1]);
        App::import('Model', $this->uses[2]);

        $transactionModel = new $this->uses[1]();
        $paymentModel = new $this->uses[2]();

        $transactionDataSource = $transactionModel->getDataSource();
        $paymentDataSource = $paymentModel->getDataSource();
        try {
            $transactionDataSource->begin();
            $transaction = $this->get_data_by_transaction_id($transactionModel, $transaction_id);

            $transaction['Transaction']['status'] = false;
            foreach($transaction['Payment'] as &$payment) {
                $payment['status'] = false;
            }

            $transactionModel->saveAll($transaction);

            $transactionDataSource->commit();

            return true;
        } catch(Exception $e) {
            $transactionDataSource->rollback();

            throw new Exception($e);
        }
    }

    private function get_data_by_transaction_id($transactionModel, $transaction_id)
    {
        $transaction = $transactionModel->findByTransactionId($transaction_id);

        if(!$transaction)
            throw new NotFoundException ('Transaction not found', 404);

        return $transaction;
    }

}
