<?php
App::uses('Model', 'Model');
App::uses('PrepareModel', 'TransactionType');

class SellingTransaction
{
    private $uses = ['Item', 'Transaction'];

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
        $transaction = (new PrepareModel(1, $this->transaction))->run();
        $transaction = $transactionModel->save($transaction);

        return $item['Item']['id'] && $transaction['Transaction']['id'];
    }
}
