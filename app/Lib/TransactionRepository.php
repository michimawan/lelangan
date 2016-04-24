<?php
App::uses('Model', 'Model');

class TransactionRepository
{
    private $uses = ['Item', 'Transaction', 'Payment'];

    public function __construct($data = [])
    {
        $this->item = isset($data['Item']) ? $data['Item']: [];
        $this->transaction = isset($data['Transaction']) ? $data['Transaction'] : [];
    }

    public function save()
    {
        switch ($this->transaction['type']) {
            case 'common' :
                return $this->normalTransaction();
            case 'selling' :
                return $this->sellingTransaction();
            case 'giving' :
                return $this->givingTransaction();
            default :
                return false;
        }

        return false;
    }

    private function prepareModel($idx, $data = []) {
        $model = new $this->uses[$idx]();
        $obj = $model->create();
        foreach($data as $key => $value) {
            $obj[$this->uses[$idx]][$key] = $value;
        }
        $obj[$this->uses[$idx]]['created_at'] = '';
        $obj[$this->uses[$idx]]['updated_at'] = '';

        return $obj;
    }

    private function normalTransaction() {
        App::import('Model', $this->uses[0]);
        App::import('Model', $this->uses[1]);

        $itemModel = new $this->uses[0]();
        $item = $this->prepareModel(0, $this->item);
        $item = $itemModel->save($item);

        $transactionModel = new $this->uses[1]();
        $this->transaction['item_id'] = $item['Item']['id'];
        $transaction = $this->prepareModel(1, $this->transaction);
        $transaction = $transactionModel->save($transaction);
        return $item['Item']['id'] && $transaction['Transaction']['id'];
    }

    private function sellingTransaction() {
        App::import('Model', $this->uses[0]);
        App::import('Model', $this->uses[1]);
        App::import('Model', $this->uses[2]);

        $itemModel = new $this->uses[0]();
        $item = $this->prepareModel(0, $this->item);
        $item = $itemModel->save($item);

        $transactionModel = new $this->uses[1]();
        $this->transaction['item_id'] = $item['Item']['id'];
        $this->transaction['bid_price'] = $item['Item']['base_price'];
        $this->transaction['payed'] = 1;
        $transaction = $this->prepareModel(1, $this->transaction);
        $transaction = $transactionModel->save($transaction);

        $paymentModel = new $this->uses[2]();
        $payment = $this->prepareModel(2);
        $payment['Payment']['transaction_id'] = $transaction['Transaction']['id'];
        $payment['Payment']['customer_id'] = $transaction['Transaction']['customer_id'];
        $payment['Payment']['pay'] = $transaction['Transaction']['bid_price'];
        $payment = $paymentModel->save($payment);
        return $item['Item']['id'] && $transaction['Transaction']['id'] && $payment['Payment']['id'];
    }

    private function givingTransaction() {
        App::import('Model', $this->uses[0]);
        App::import('Model', $this->uses[1]);
        App::import('Model', $this->uses[2]);

        $itemModel = new $this->uses[0]();
        $item = $itemModel->findByItemId($this->item['item_id']);

        $transactionModel = new $this->uses[1]();
        $this->transaction['item_id'] = $item['Item']['id'];
        $this->transaction['payed'] = 1;
        $transaction = $this->prepareModel(1, $this->transaction);
        $transaction = $transactionModel->save($transaction);

        $paymentModel = new $this->uses[2]();
        $payment = $this->prepareModel(2);
        $payment['Payment']['transaction_id'] = $transaction['Transaction']['id'];
        $payment['Payment']['customer_id'] = $transaction['Transaction']['customer_id'];
        $payment['Payment']['pay'] = $transaction['Transaction']['bid_price'];
        $payment = $paymentModel->save($payment);
        return $item['Item']['id'] && $transaction['Transaction']['id'] && $payment['Payment']['id'];
    }
}
