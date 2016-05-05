<?php
App::uses('Model', 'Model');
App::import('TransactionType', 'PrepareModel');

class GivingTransaction
{
    private $uses = ['Item', 'Transaction'];

    public function __construct($transaction = [])
    {
        $this->transaction = $transaction;

        foreach($this->uses as $use)
            App::import('Model', $use);
    }

    public function save()
    {
        $itemModel = new $this->uses[0]();
        $item = $itemModel->findByItemId('IID0001');

        $transactionModel = new $this->uses[1]();
        $data = [];
        $dataSource = $transactionModel->getDataSource();
        $dataSource->begin();
        try {
            $this->transaction['item_id'] = $item['Item']['id'];
            $transaction = (new PrepareModel(1, $this->transaction))->run();
            $transaction = $transactionModel->save($transaction);
            $dataSource->commit();

            $data['status'] = true;
            $data['customer'] = 1;
            $data['failed'] = [];
        } catch(Exception $e) {
            $dataSource->rollback();
            $data['status'] = false;
            $data['customer'] = 1;
            $data['failed'] = [$this->transaction['customer_id']];
        }

        return $data;
    }
}
