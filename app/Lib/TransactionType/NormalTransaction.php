<?php
App::uses('Model', 'Model');
App::uses('PrepareModel', 'TransactionType');

class NormalTransaction
{
    private $uses = ['Transaction'];

    public function __construct($transaction = [])
    {
        $this->transaction = $transaction;

        foreach($this->uses as $use)
            App::import('Model', $use);
    }

    public function save()
    {
        $transactionModel = new $this->uses[0]();
        $transaction = (new PrepareModel(1, $this->transaction))->run();
        $transaction = $transactionModel->save($transaction);
        return $transaction['Transaction']['id'];
    }
}
