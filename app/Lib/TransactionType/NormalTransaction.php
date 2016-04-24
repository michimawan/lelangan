<?php
App::uses('Model', 'Model');
App::uses('PrepareModel', 'TransactionType');

class NormalTransaction
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
        // $item = $this->prepareModel(0, $this->item);
        $item = $itemModel->save($item);

        $transactionModel = new $this->uses[1]();
        $this->transaction['item_id'] = $item['Item']['id'];
        $transaction = (new PrepareModel(1, $this->transaction))->run();
        // $transaction = $this->prepareModel(1, $this->transaction);
        $transaction = $transactionModel->save($transaction);
        return $item['Item']['id'] && $transaction['Transaction']['id'];
    }
}
