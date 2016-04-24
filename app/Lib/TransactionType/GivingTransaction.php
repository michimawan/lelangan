<?php
App::uses('Model', 'Model');
App::uses('PrepareModel', 'TransactionType');

class GivingTransaction
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
        $item = $itemModel->findByItemId($this->item['item_id']);

        $transactionModel = new $this->uses[1]();
        $this->transaction['item_id'] = $item['Item']['id'];
        $transaction = (new PrepareModel(1, $this->transaction))->run();
        $transaction = $transactionModel->save($transaction);

        return $item['Item']['id'] && $transaction['Transaction']['id'];
    }
}
