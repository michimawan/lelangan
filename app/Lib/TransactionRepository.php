<?php
App::uses('Model', 'Model');

class TransactionRepository
{
    private $uses = ['Item', 'Transaction'];

    public function __construct($data = [])
    {
        $this->item = isset($data['Item']) ? $data['Item']: [];
        $this->transaction = isset($data['Transaction']) ? $data['Transaction'] : [];

        foreach($this->uses as $use) {
            App::import('Model', $use);
        }
    }

    public function save()
    {
        $itemModel = new $this->uses[0]();
        $item = $this->prepareModel(0, $this->item);
        $item = $itemModel->save($item);

        $transactionModel = new $this->uses[1]();
        $this->transaction['item_id'] = $item['Item']['id'];
        $transaction = $this->prepareModel(1, $this->transaction);
        $transaction = $transactionModel->save($transaction);
        return $item['Item']['id'] && $transaction['Transaction']['id'];
    }

    private function prepareModel($idx, $data) {
        $model = new $this->uses[$idx]();
        $obj = $model->create();
        foreach($data as $key => $value) {
            $obj[$this->uses[$idx]][$key] = $value;
        }
        $obj[$this->uses[$idx]]['created_at'] = '';
        $obj[$this->uses[$idx]]['updated_at'] = '';

        return $obj;
    }
}
