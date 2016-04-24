<?php
App::uses('Model', 'Model');
App::uses('PrepareModel', 'TransactionType');

class SellingTransaction
{
    private $uses = ['Item', 'Transaction', 'Payment'];

    public function __construct($item = [], $transaction = [])
    {
        $this->item = $item;
        $this->transaction = $transaction;

        foreach($this->uses as $use)
            App::import('Model', $use);
    }

    public function save()
    {
        $itemModel = new $this->uses[0]();
        $item = (new PrepareModel(0, $this->item))->run();
        $item = $itemModel->save($item);

        $transactionModel = new $this->uses[1]();
        $this->transaction['item_id'] = $item['Item']['id'];
        $this->transaction['bid_price'] = $item['Item']['base_price'];
        $this->transaction['payed'] = 1;
        $transaction = (new PrepareModel(1, $this->transaction))->run();
        $transaction = $transactionModel->save($transaction);

        $paymentModel = new $this->uses[2]();
        $payment = (new PrepareModel(2))->run();
        $payment['Payment']['transaction_id'] = $transaction['Transaction']['id'];
        $payment['Payment']['customer_id'] = $transaction['Transaction']['customer_id'];
        $payment['Payment']['pay'] = $transaction['Transaction']['bid_price'];
        $payment = $paymentModel->save($payment);
        return $item['Item']['id'] && $transaction['Transaction']['id'] && $payment['Payment']['id'];
    }
}
